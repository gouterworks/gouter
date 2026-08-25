#!/usr/bin/env python3
"""gouter.works のコラムを扱う道具。

  lint   原稿が docs/WRITING-STYLE.md のルールを守っているか検査する（ネット不要）
  push   WordPressへ下書きとして反映する（新規/更新）
  schedule  公開日時を指定して予約投稿にする

原稿は Markdown。先頭にフロントマターを置く。

    ---
    title: 口コミ返信の例文つき！低評価レビューで店の印象を落とさない書き方
    kw: 口コミ 返信 例文
    primary: 昨年の飲食店クライアントで、返信を始めてから3か月の口コミ件数を実測
    post_id: 9327
    ---

WordPressの接続情報は環境変数から読む。

    WP_URL             https://gouter.works
    WP_USER            ユーザー名
    WP_APP_PASSWORD    アプリケーションパスワード
"""

import argparse
import base64
import json
import os
import re
import sys
import urllib.error
import urllib.request

CATEGORY_COLUMN = 110
MIN_CHARS, MAX_CHARS = 3500, 5500
TITLE_MAX = 32


# ---------------------------------------------------------------- 原稿を読む

def parse(path):
    text = open(path, encoding="utf-8").read()
    meta, body = {}, text
    if text.startswith("---"):
        end = text.find("\n---", 3)
        if end == -1:
            raise SystemExit(f"{path}: フロントマターが閉じていない")
        for line in text[3:end].strip().splitlines():
            if ":" in line:
                k, v = line.split(":", 1)
                meta[k.strip()] = v.strip()
        body = text[end + 4:].lstrip("\n")
    return meta, body


def visible_chars(body):
    """装飾記号を除いた、読者が目にする文字数。"""
    t = re.sub(r"^```.*?^```", "", body, flags=re.S | re.M)   # コードブロック
    t = re.sub(r"!\[[^\]]*\]\([^)]*\)", "", t)                 # 画像
    t = re.sub(r"\[([^\]]*)\]\([^)]*\)", r"\1", t)             # リンクは文字だけ残す
    t = re.sub(r"^#{1,6}\s*", "", t, flags=re.M)               # 見出し記号
    t = re.sub(r"[*_`>|-]", "", t)
    t = re.sub(r"\s+", "", t)
    return len(t)


def headings(body, level=2):
    mark = "#" * level
    return re.findall(rf"^{mark}\s+(.+)$", body, flags=re.M)


def sections(body):
    """H2ごとの本文字数。"""
    parts = re.split(r"^##\s+(.+)$", body, flags=re.M)[1:]
    return [(parts[i], visible_chars(parts[i + 1])) for i in range(0, len(parts), 2)]


# ---------------------------------------------------------------- 検査

class Report:
    def __init__(self):
        self.errors, self.warns = [], []

    def error(self, msg):
        self.errors.append(msg)

    def warn(self, msg):
        self.warns.append(msg)

    def show(self, path):
        for m in self.errors:
            print(f"  ✗ {m}")
        for m in self.warns:
            print(f"  ! {m}")
        if not self.errors and not self.warns:
            print("  ○ 問題なし")
        print(f"\n{path}: エラー{len(self.errors)}件、警告{len(self.warns)}件")
        return 1 if self.errors else 0


def lint(path):
    meta, body = parse(path)
    r = Report()
    title = meta.get("title", "")
    kws = meta.get("kw", "").split()

    print(f"{path}")

    if not title:
        r.error("フロントマターに title が無い")
    if not kws:
        r.error("フロントマターに kw が無い")
    if not meta.get("primary"):
        r.error("フロントマターに primary が無い（一次情報を1つ以上入れる。WRITING-STYLE §7）")

    # タイトル
    if title:
        if len(title) > TITLE_MAX:
            r.error(f"タイトルが{len(title)}字。{TITLE_MAX}字以内にする")
        if not re.search(r"[！？]", title):
            r.error("タイトルに前半／後半の区切り（！ か ？）が無い")
        for kw in kws:
            n = title.count(kw)
            if n == 0:
                r.error(f"タイトルにKW「{kw}」が完全一致で入っていない")
            elif n > 2:
                r.error(f"タイトルのKW「{kw}」が{n}回。2回まで")
        if kws and kws[0] in title:
            i = title.index(kws[0])
            if i > 8:
                r.warn(f"KW「{kws[0]}」がタイトルの{i}文字目。できるだけ先頭に置く")

    # 本文の分量
    chars = visible_chars(body)
    if chars < MIN_CHARS:
        r.error(f"本文が{chars}字。{MIN_CHARS}字以上にする")
    elif chars > MAX_CHARS:
        r.error(f"本文が{chars}字。{MAX_CHARS}字を超えたら前後編か初級・応用に分割する")
    else:
        print(f"  本文 {chars}字")

    # 見出し
    h2 = headings(body, 2)
    if not h2:
        r.error("H2が1本も無い")
    else:
        if kws and not any(k in h2[0] for k in kws):
            r.error(f"最初のH2「{h2[0]}」にKWが入っていない（WRITING-STYLE §4）")
        if "まとめ" not in h2[-1]:
            r.error(f"最後のH2が「{h2[-1]}」。まとめで終える")
        limit = chars // 1000 + 1
        if len(h2) > limit:
            r.error(f"H2が{len(h2)}本。{chars}字なら{limit}本まで")
        else:
            print(f"  H2 {len(h2)}本（上限{limit}本）")
        for name, n in sections(body):
            if n > 1200:
                r.warn(f"H2「{name}」が{n}字。H3で割ることを検討する")

    # 段落
    for block in re.split(r"\n{2,}", re.sub(r"^```.*?^```", "", body, flags=re.S | re.M)):
        block = block.strip()
        if block.startswith(("#", "|", ">", "-", "*")) or not block:
            continue
        if len(block) > 400:
            r.warn(f"段落が{len(block)}字。3〜4行のブロックに割る（「{block[:20]}…」）")

    # 内部リンク
    links = re.findall(r"\[[^\]]*\]\((https?://[^)]+|/[^)]*)\)", body)
    if not any("gouter.works" in u or u.startswith("/") for u in links):
        r.error("内部リンクが1本も無い（WRITING-STYLE §12）")

    # 画像のalt
    for alt, _ in re.findall(r"!\[([^\]]*)\]\(([^)]*)\)", body):
        if not alt.strip():
            r.error("altが空の画像がある")

    return r.show(path)


# ---------------------------------------------------------------- WordPress

def api(method, endpoint, payload=None):
    base = os.environ.get("WP_URL", "").rstrip("/")
    user = os.environ.get("WP_USER", "")
    pw = os.environ.get("WP_APP_PASSWORD", "")
    if not (base and user and pw):
        raise SystemExit("WP_URL / WP_USER / WP_APP_PASSWORD を環境変数に設定する")
    token = base64.b64encode(f"{user}:{pw}".encode()).decode()
    req = urllib.request.Request(
        f"{base}/wp-json/wp/v2/{endpoint}",
        method=method,
        data=json.dumps(payload).encode() if payload else None,
        headers={"Authorization": f"Basic {token}", "Content-Type": "application/json"},
    )
    try:
        with urllib.request.urlopen(req) as res:
            return json.loads(res.read())
    except urllib.error.HTTPError as e:
        raise SystemExit(f"WordPress {e.code}: {e.read().decode()[:400]}")


def to_html(body):
    """Markdownを、記事に必要な範囲だけHTMLにする。"""
    out, buf = [], []

    def flush():
        if buf:
            out.append("<p>" + "<br />".join(buf) + "</p>")
            buf.clear()

    def inline(s):
        s = re.sub(r"!\[([^\]]*)\]\(([^)]+)\)", r'<img src="\2" alt="\1" />', s)
        s = re.sub(r"\[([^\]]+)\]\(([^)]+)\)", r'<a href="\2">\1</a>', s)
        s = re.sub(r"\*\*([^*]+)\*\*", r"<strong>\1</strong>", s)
        return s

    lst = None
    for line in body.splitlines():
        line = line.rstrip()
        m = re.match(r"^(#{2,4})\s+(.+)$", line)
        if m:
            flush()
            if lst:
                out.append(f"</{lst}>")
                lst = None
            out.append(f"<h{len(m.group(1))}>{inline(m.group(2))}</h{len(m.group(1))}>")
            continue
        m = re.match(r"^\s*([-*]|\d+\.)\s+(.+)$", line)
        if m:
            flush()
            want = "ul" if m.group(1) in "-*" else "ol"
            if lst != want:
                if lst:
                    out.append(f"</{lst}>")
                out.append(f"<{want}>")
                lst = want
            out.append(f"<li>{inline(m.group(2))}</li>")
            continue
        if lst:
            out.append(f"</{lst}>")
            lst = None
        if not line:
            flush()
        else:
            buf.append(inline(line))
    flush()
    if lst:
        out.append(f"</{lst}>")
    return "\n".join(out)


def send(path, status, date=None):
    meta, body = parse(path)
    payload = {
        "title": meta.get("title", ""),
        "content": to_html(body),
        "status": status,
        "categories": [int(meta.get("category", CATEGORY_COLUMN))],
    }
    if date:
        payload["date"] = date
    post_id = meta.get("post_id")
    if post_id:
        res = api("POST", f"posts/{post_id}", payload)
        print(f"更新 {res['id']}: {res['link']}")
    else:
        res = api("POST", "posts", payload)
        print(f"作成 {res['id']}: {res['link']}")
        print(f"フロントマターに post_id: {res['id']} を書き足すこと")
    return res


# ---------------------------------------------------------------- 入口

def main():
    p = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    sub = p.add_subparsers(dest="cmd", required=True)

    s = sub.add_parser("lint", help="ルール違反を検査する")
    s.add_argument("files", nargs="+")

    s = sub.add_parser("push", help="下書きとして反映する")
    s.add_argument("file")

    s = sub.add_parser("schedule", help="予約投稿にする")
    s.add_argument("file")
    s.add_argument("--at", required=True, help="例 2026-09-01T07:00:00")

    a = p.parse_args()
    if a.cmd == "lint":
        code = 0
        for f in a.files:
            code |= lint(f)
            print()
        sys.exit(code)
    if a.cmd == "push":
        if lint(a.file):
            sys.exit("ルール違反があるので反映しない")
        send(a.file, "draft")
    if a.cmd == "schedule":
        if lint(a.file):
            sys.exit("ルール違反があるので反映しない")
        send(a.file, "future", a.at)


if __name__ == "__main__":
    main()
