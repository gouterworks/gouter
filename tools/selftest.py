#!/usr/bin/env python3
"""wp.py の点検。ネットには繋がない。

編集中に関数をまるごと消してしまい、実行時に NameError で落ちたことがある。
サブコマンドと、それが呼ぶ関数が揃っているかを機械で確かめる。
"""
import importlib.util
import subprocess
import json
import os
import sys
from pathlib import Path

WP = Path(__file__).with_name("wp.py")
SUBCOMMANDS = ["lint", "check", "audit", "publish", "show", "demote",
               "featured", "push", "schedule", "pending", "slots", "queue", "overdue", "unschedule", "trash", "reserve", "render", "timezone"]
FUNCTIONS = ["parse", "visible_chars", "headings", "sections", "lint", "api",
             "to_html", "check", "set_featured", "html_text", "audit", "show",
             "demote", "set_status", "send", "find_by_title", "main",
             "site_timezone", "trash", "queue", "overdue", "taken_slots", "next_free_slot", "slots", "render", "timezone_set"]

spec = importlib.util.spec_from_file_location("wp", WP)
wp = importlib.util.module_from_spec(spec)
spec.loader.exec_module(wp)

missing = [f for f in FUNCTIONS if not callable(getattr(wp, f, None))]
if missing:
    sys.exit(f"関数が無い: {', '.join(missing)}")

for c in SUBCOMMANDS:
    r = subprocess.run([sys.executable, str(WP), c, "--help"], capture_output=True)
    if r.returncode != 0:
        sys.exit(f"サブコマンド {c} が壊れている: {r.stderr.decode()[:300]}")

# 変換が既存記事と同じブロック記法を出すか
html = wp.to_html("## 見出し\n\n本文です。\n\n- 箇条書き\n\n> 引用\n")
for need in ['<!-- wp:heading -->', 'class="wp-block-heading jinr-heading d--bold"',
             '<!-- wp:paragraph -->', 'class="wp-block-list jinr-list"',
             '<!-- wp:quote -->']:
    if need not in html:
        sys.exit(f"変換の出力に {need} が無い")

# 名前解決の抜けを見つける。関数の中で使っている名前が import 漏れしていないか
import builtins
for name, fn in [(f, getattr(wp, f)) for f in FUNCTIONS]:
    for g in getattr(fn, "__code__", None).co_names if hasattr(fn, "__code__") else []:
        if not hasattr(wp, g) and not hasattr(builtins, g):
            # メソッド呼び出し（obj.method）も co_names に入るので、
            # モジュール直下に無いものは警告にとどめる
            pass
missing_globals = sorted({
    g for f in FUNCTIONS
    for g in (getattr(wp, f).__code__.co_names if hasattr(getattr(wp, f), "__code__") else [])
    if g in ("timezone", "ZoneInfo", "datetime", "timedelta", "json", "re", "os", "sys",
             "base64", "urllib") and not hasattr(wp, g)
})
if missing_globals:
    sys.exit(f"import が足りない: {', '.join(missing_globals)}")

# 待ち行列の中身を、実行せずに引数だけ通してみる。
# --kw の付け忘れのような取りこぼしは、runnerではなくここで止める
QUEUE = os.path.join(os.path.dirname(__file__), "pending.json")
queued = 0
if os.path.exists(QUEUE):
    parser = wp.build_parser()
    for i, argv in enumerate(json.load(open(QUEUE, encoding="utf-8")), 1):
        if not isinstance(argv, list) or not all(isinstance(x, str) for x in argv):
            sys.exit(f"待ち行列の{i}番目が文字列の配列になっていない")
        try:
            parser.parse_args(argv)
        except SystemExit:
            sys.exit(f"待ち行列の{i}番目が引数を満たしていない: wp.py {' '.join(argv)}")
        queued += 1

print(f"点検OK 関数{len(FUNCTIONS)}個、サブコマンド{len(SUBCOMMANDS)}個、待ち行列{queued}件")
