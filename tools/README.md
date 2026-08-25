# tools

## wp.py

コラムの原稿を検査し、WordPressへ反映する。標準ライブラリだけで動く。

```
python3 tools/wp.py lint  docs/articles/02-line-coupon.md
python3 tools/wp.py check
python3 tools/wp.py push  docs/articles/02-line-coupon.md
python3 tools/wp.py schedule docs/articles/02-line-coupon.md --at 2026-09-01T07:00:00
```

`lint` はネットに繋がらなくても動く。`push` と `schedule` はlintを通ってからでないと実行されない。

### WordPressに繋ぐ

**アプリケーションパスワードを作る。** ログインパスワードとは別物で、これだけを失効させられる。

1. 管理画面 → ユーザー → プロフィール → 「アプリケーションパスワード」
2. 名前を入れて発行する
3. `abcd EFGH ijkl MNOP qrst UVWX` の形で1度だけ表示される。**画面を離れると二度と出ない**。スペースは込みのままでよい

欄が見当たらないときは、セキュリティプラグイン（SiteGuard、Wordfenceなど）が機能を止めていることがある。

**環境変数に入れる。** リポジトリには絶対に置かない。

```
export WP_URL=https://gouter.works
export WP_USER=ユーザー名
export WP_APP_PASSWORD='abcd EFGH ijkl MNOP qrst UVWX'
```

**確かめる。**

```
python3 tools/wp.py check
```

`401` が返るときは、サーバーが `Authorization` ヘッダーを落としている可能性が高い。`.htaccess` に足す。

```
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
```

### アイキャッチを設定する

```
python3 tools/wp.py featured --post 9327 --url <画像のURL> --alt "カフェで…"
```

Canvaから書き出したPNGのURLをそのまま渡せる。メディアに登録し、altを入れ、記事のアイキャッチにする。

`tools/featured.json` を置いてpushすると、GitHub Actionsが同じことをする。

```json
{
  "post_id": "9327",
  "image_url": "https://...",
  "alt": "カフェでスマートフォンとノートパソコンを使う人",
  "name": "9327-kuchikomi-henshin.png"
}
```

`workflow_dispatch`（手動実行）は**ワークフローが既定ブランチに無いと使えない**というGitHubの仕様があるため、
このPRが `main` に入るまでの回り道。設定が済んだらファイルは消すこと。

### 実行する場所

**クラウドのセッションからは実行できない。** 環境のネットワークポリシーが `gouter.works` を許可しておらず、
egressプロキシが403で遮断する。回避してはいけない種類の制限なので、次のどちらかを取る。

- 手元のPCのClaude Codeから実行する
- 環境のネットワークポリシーに `gouter.works` を許可する
  （[Claude Code on the web のドキュメント](https://code.claude.com/docs/en/claude-code-on-the-web)）

`push` と `schedule` は、サイトに到達できる環境で**まだ一度も実行されていない**。
最初は下書き1本で確かめること。
