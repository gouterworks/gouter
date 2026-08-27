# gouter.works

Goûter（グーテ）のコーポレートサイト。WordPressの自作テーマと、コラムの運用ルールが入っている。

## 記事を書くときは

**`docs/WRITING-STYLE.md` を必ず読んでから書く。** タイトル32字・PREP法・一次情報の必須要件など、
守らないと後から直す羽目になるルールが入っている。

- 何を書くか → `docs/THEME-BACKLOG.md`（テーマ20本と公開順）
- アイキャッチの素材 → `docs/EYECATCH-ASSETS.md`
- 積み残し → `docs/HANDOFF.md`
- 人がいない状態で回す手順 → `docs/DAILY-RUN.md`
- WordPressへの反映とルール検査 → `tools/wp.py`

### 運用の要点

- 分量は**2,500〜5,500字**。超えそうなら前後編か初級・応用に分割する
- **一度で書き切る。** 足りないぶんを何度も膨らませない
- **同じジャンル・同じ商材を2本続けて公開しない**
- **1記事に「具体の数字・現場で見たこと・失敗」を最低1つ**入れる。無い原稿は公開しない
- **実績を捏造しない。** 「クライアントで◯%改善」は実際の数字があるときだけ
- 書く直前に**SERPを実際に見て**顕在／潜在ニーズを確定する。机上で埋めない
- 公開前に `python3 tools/wp.py lint <file>` を通す

### 配信

**予約投稿**で回す。枠は日本時間の **07:00 / 12:00 / 19:00** の3つ。
`python3 tools/wp.py schedule <file> --next` で次の空き枠に入る。
毎回「公開していいか」を聞かない形にする。

コラムはカテゴリ `column`（ID **110**）。トップページの「読みもの」セクションはここから6件引いている。

### 成果指標

**問い合わせ数**で測る。広告収益は目的ではないので、PV×クリック率では評価しない。
サーチコンソールのコネクタは提供されていないため、データが要るときは管理画面からCSVを書き出して読む。

## テーマの構造

WordPressテーマ。ビルド工程は無く、PHPとCSSを直接書く。

| ファイル | 役割 |
|---|---|
| `front-page.php` | トップページ。セクション01〜09の一枚もの |
| `single.php` | 記事詳細 |
| `archive.php` | 記事一覧。カテゴリ・タグ・日付・書き手 |
| `search.php` | 検索結果。`archive.php` を読み込むだけ |
| `page-gt.php` | 下層ページ。トップ以外の全固定ページ |
| `parts/header.php` `parts/footer.php` | 共通ヘッダー・フッター |
| `style.css` | 全スタイル。`gt-` プレフィックス |
| `assets/img/` | 画像 |

- クラス名は `gt-` から始める
- 下層ページからトップのアンカーへ飛ぶときは `home_url()` を前置きする（`parts/header.php` の `$gt_home`）
- コミットメッセージは日本語。`fix:` `feat:` `style:` `copy:` を使い、**何が起きていたか**を書く

## デプロイ

`main` にpushすると GitHub Actions（`.github/workflows/deploy.yml`）がSCPでサーバーへ転送する。
対象は `*.php` `style.css` `parts/**` `assets/**`。テンプレートを1枚ずつ列挙すると追加時に忘れるので、
ルートの `.php` はまとめて送っている。

## 画面を見る

クラウドのセッションからは gouter.works にも外部サイトにも到達できない（egressで遮断される）。
**自分が直した画面を目で確かめられない**ので、撮影はランナーに回す。

Actions → **スクリーンショット**（`.github/workflows/shot.yml`）を Run workflow で叩く。
URLは改行かカンマ区切りで複数可。横幅を `390` にすればスマホの見え方になる。

結果は **`claude/shots` ブランチ**の `shots/` に入る（毎回まるごと置き換わる）。
`git fetch origin claude/shots` して読む。`shots/INDEX.md` に一覧と画像の大きさが出る。

撮影の中身は `tools/shot.mjs`。Playwright + Chromium で、最初の1画面と全体の2枚を撮る。
