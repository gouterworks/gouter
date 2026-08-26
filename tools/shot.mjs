// ページを撮ってJPEGで保存する。
//
// クラウドのセッションからは外部サイトに到達できない（egressで遮断される）。
// ランナーからなら開けるので、撮影はここで回す。column.yml と同じ考え方。
//
// 環境変数:
//   URLS       撮るURL。改行かカンマ区切りで複数可
//   WIDTH      画面の横幅(px)。既定 1280
//   FULL_PAGE  "true" ならページ全体も撮る
//
// 出力: shots/*.jpg と shots/INDEX.md

import { chromium } from 'playwright';
import { mkdir, writeFile, stat } from 'node:fs/promises';

const URLS = (process.env.URLS || '')
  .split(/[\n,]+/)
  .map((s) => s.trim())
  .filter(Boolean);

const WIDTH = Number.parseInt(process.env.WIDTH || '1280', 10) || 1280;
const FULL_PAGE = (process.env.FULL_PAGE || 'true') === 'true';
const SETTLE = Number.parseInt(process.env.SETTLE_MS || '3000', 10) || 3000;
const OUT = 'shots';

if (URLS.length === 0) {
  console.error('URLS が空です');
  process.exit(1);
}

// ファイル名に使える形にする。example.com/a/b → example-com_a-b
function slug(url) {
  try {
    const u = new URL(url);
    const path = u.pathname.replace(/\/+$/, '').replace(/^\//, '');
    const base = u.hostname.replace(/^www\./, '').replace(/\./g, '-');
    const tail = path ? '_' + path.replace(/[^a-zA-Z0-9]+/g, '-') : '';
    return (base + tail).slice(0, 80);
  } catch {
    return 'page';
  }
}

// 表の1マスに収める。Playwright のエラーは改行と色指定を含むので、
// そのまま入れると Markdown の表が崩れる
function oneLine(s) {
  return String(s || '')
    .replace(/\u001b\[[0-9;]*m/g, '')
    .replace(/\s+/g, ' ')
    .replace(/\|/g, '｜')
    .trim()
    .slice(0, 160);
}

async function sizeKB(path) {
  try {
    return Math.round((await stat(path)).size / 1024);
  } catch {
    return 0;
  }
}

await mkdir(OUT, { recursive: true });

const browser = await chromium.launch();
const rows = [];

for (const url of URLS) {
  const name = slug(url);
  const context = await browser.newContext({
    viewport: { width: WIDTH, height: 900 },
    // 日本語のサイトが多いので、その前提で取りに行く
    locale: 'ja-JP',
    userAgent:
      'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',
  });
  const page = await context.newPage();

  try {
    await page.goto(url, { waitUntil: 'load', timeout: 45000 });

    // load の直後だと、入場アニメーションの途中で撮れてしまうサイトがある。
    // 実際 rightdesigninc.com は単色のまま、rgf-professional.jp は写真が
    // 散らばった演出の途中で撮れた。通信が落ち着くまで待ってから撮る。
    // networkidle は広告や計測タグが動き続けるサイトでは永遠に来ないので、
    // 短めで打ち切って先へ進む
    try {
      await page.waitForLoadState('networkidle', { timeout: 15000 });
    } catch {
      // 来なくても構わない。下の待ち時間で妥協する
    }
    await page.waitForTimeout(SETTLE);

    // 遅延読み込みの画像を出すために一度下まで送って戻す
    await page.evaluate(async () => {
      const step = window.innerHeight;
      for (let y = 0; y < document.body.scrollHeight; y += step) {
        window.scrollTo(0, y);
        await new Promise((r) => setTimeout(r, 120));
      }
      window.scrollTo(0, 0);
    });
    await page.waitForTimeout(1200);

    const top = `${OUT}/${name}-top.jpg`;
    await page.screenshot({ path: top, type: 'jpeg', quality: 80 });

    let full = '';
    if (FULL_PAGE) {
      // 極端に縦長のページは Chromium が撮りきれずに落ちることがある。
      // 落ちても最初の1画面は残っているので、そこは諦めて先へ進む
      try {
        full = `${OUT}/${name}-full.jpg`;
        await page.screenshot({ path: full, type: 'jpeg', quality: 70, fullPage: true });
      } catch (e) {
        console.error(`全体が撮れなかった: ${url} — ${e.message}`);
        full = '';
      }
    }

    const height = await page.evaluate(() => document.body.scrollHeight);
    const title = await page.title();

    rows.push({
      url,
      title,
      height,
      top,
      topKB: await sizeKB(top),
      full,
      fullKB: full ? await sizeKB(full) : 0,
      error: '',
    });
    console.log(`撮れた: ${url}`);
  } catch (e) {
    rows.push({ url, title: '', height: 0, top: '', topKB: 0, full: '', fullKB: 0, error: e.message });
    console.error(`撮れなかった: ${url} — ${e.message}`);
  } finally {
    await context.close();
  }
}

await browser.close();

// 読む側が「どれを開けばいいか」「大きすぎないか」を先に判断できるようにしておく
const lines = [
  '# 撮影結果',
  '',
  `- 横幅: ${WIDTH}px`,
  `- ページ全体: ${FULL_PAGE ? '撮る' : '撮らない'}`,
  `- 描画待ち: ${SETTLE}ms（＋通信が落ち着くまで最大15秒）`,
  `- 件数: ${rows.length}（成功 ${rows.filter((r) => !r.error).length}）`,
  '',
  '| URL | タイトル | 縦(px) | 最初の1画面 | 全体 | 備考 |',
  '|---|---|---|---|---|---|',
];

for (const r of rows) {
  lines.push(
    `| ${r.url} | ${oneLine(r.title) || '—'} | ${r.height || '—'} | ` +
      `${r.top ? `${r.top} (${r.topKB}KB)` : '—'} | ` +
      `${r.full ? `${r.full} (${r.fullKB}KB)` : '—'} | ${oneLine(r.error)} |`
  );
}

await writeFile(`${OUT}/INDEX.md`, lines.join('\n') + '\n', 'utf8');

const failed = rows.filter((r) => r.error).length;
console.log(`\n完了: ${rows.length}件中 ${failed}件が失敗`);
// 1件でも撮れていれば成果はあるので、全滅のときだけ失敗にする
if (failed === rows.length) process.exit(1);
