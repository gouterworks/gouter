/**
 * サーチコンソールとGA4の数字を、このスプレッドシートに書き出す。
 *
 * Windsor.ai のような中継サービスを通さず、Googleの無料APIだけで動く。
 * 書き出し先はさとこさんのDriveなので、Claudeはそこから読める。
 *
 * 使い方は docs/ANALYTICS-FREE.md。
 */

// ── 設定 ────────────────────────────────────────────────
// 最初に setUp() を動かすと「設定メモ」シートに候補が並ぶ。そこから選んで貼る。

var SITE_URL     = 'sc-domain:gouter.works';  // サーチコンソールのプロパティ
var GA4_PROPERTY = '';                        // 例 '123456789'（アカウントIDではない）
var MONTHS_BACK  = 4;                         // 何か月ぶん取るか
var ROW_LIMIT    = 5000;

// ── 入口 ────────────────────────────────────────────────

/**
 * 最初に一度だけ動かす。使えるプロパティの一覧を「設定メモ」シートに出す。
 * SITE_URL と GA4_PROPERTY をここから確定させる。
 */
function setUp() {
  var rows = [['種類', '貼る値', '名前']];

  // サーチコンソールで見られるサイト
  try {
    var sites = callApi_('https://www.googleapis.com/webmasters/v3/sites').siteEntry || [];
    for (var i = 0; i < sites.length; i++) {
      rows.push(['サーチコンソール', sites[i].siteUrl, sites[i].permissionLevel]);
    }
    if (!sites.length) rows.push(['サーチコンソール', '(無し)', 'このアカウントに登録されたサイトがない']);
  } catch (e) {
    rows.push(['サーチコンソール', '(取得失敗)', String(e)]);
  }

  // GA4のプロパティ
  try {
    var summaries = callApi_('https://analyticsadmin.googleapis.com/v1beta/accountSummaries?pageSize=200').accountSummaries || [];
    for (var a = 0; a < summaries.length; a++) {
      var props = summaries[a].propertySummaries || [];
      for (var p = 0; p < props.length; p++) {
        rows.push(['GA4', String(props[p].property).replace('properties/', ''),
                   summaries[a].displayName + ' / ' + props[p].displayName]);
      }
    }
    if (!summaries.length) rows.push(['GA4', '(無し)', 'このアカウントで見られるプロパティがない']);
  } catch (e) {
    rows.push(['GA4', '(取得失敗)', String(e)]);
  }

  write_('設定メモ', rows);
  SpreadsheetApp.getActive().toast('「設定メモ」シートを見て、Code.gs の SITE_URL と GA4_PROPERTY を書き換えてください。');
}

/**
 * 本番。サーチコンソールとGA4の数字を取ってシートに書く。
 * 毎週これが自動で動くようにするのが 毎週動かす()。
 */
function run() {
  var to   = daysAgo_(3);                 // 直近はデータが揃わないので3日あける
  var from = monthsAgo_(MONTHS_BACK);

  // ── サーチコンソール ──
  sc_('SC_クエリ',       ['query'],          from, to);
  sc_('SC_ページ',       ['page'],           from, to);
  sc_('SC_ページ別クエリ', ['page', 'query'],  from, to);
  sc_('SC_日別',         ['date'],           from, to);

  // ── GA4 ──
  if (GA4_PROPERTY) {
    ga4_('GA4_ページ',   [['pagePath'], ['pageTitle']], ['screenPageViews', 'sessions'], from, to);
    ga4_('GA4_着地',     [['landingPage']],             ['sessions', 'totalUsers'],      from, to);
    ga4_('GA4_流入元',   [['sessionSource'], ['sessionMedium']], ['sessions'],           from, to);
    ga4_('GA4_日別',     [['date']],                    ['screenPageViews', 'sessions'], from, to);
  }

  write_('最終更新', [
    ['最終更新', new Date()],
    ['期間',     from + ' 〜 ' + to],
    ['SITE_URL', SITE_URL],
    ['GA4',      GA4_PROPERTY || '(未設定)']
  ]);
}

/** 毎週月曜の朝7時に run() が動くようにする。一度だけ実行すればいい。 */
function 毎週動かす() {
  var triggers = ScriptApp.getProjectTriggers();
  for (var i = 0; i < triggers.length; i++) {
    if (triggers[i].getHandlerFunction() === 'run') ScriptApp.deleteTrigger(triggers[i]);
  }
  ScriptApp.newTrigger('run').timeBased().onWeekDay(ScriptApp.WeekDay.MONDAY).atHour(7).create();
  SpreadsheetApp.getActive().toast('毎週月曜7時に動くようにしました。');
}

// ── 中身 ────────────────────────────────────────────────

/** サーチコンソールの検索パフォーマンスを1シートに書く。 */
function sc_(sheetName, dimensions, from, to) {
  var url = 'https://www.googleapis.com/webmasters/v3/sites/'
          + encodeURIComponent(SITE_URL) + '/searchAnalytics/query';
  var body = {
    startDate:  from,
    endDate:    to,
    dimensions: dimensions,
    rowLimit:   ROW_LIMIT,
    dataState:  'all'
  };

  var res;
  try {
    res = callApi_(url, body);
  } catch (e) {
    write_(sheetName, [['取得失敗'], [String(e)]]);
    return;
  }

  var header = dimensions.concat(['クリック', '表示', 'CTR', '平均順位']);
  var rows = [header];
  var list = res.rows || [];
  for (var i = 0; i < list.length; i++) {
    var r = list[i];
    rows.push((r.keys || []).concat([r.clicks, r.impressions, r.ctr, r.position]));
  }
  if (list.length === 0) rows.push(['データなし']);
  write_(sheetName, rows);
}

/** GA4のレポートを1シートに書く。 */
function ga4_(sheetName, dimensionNames, metricNames, from, to) {
  var request = {
    dateRanges: [{ startDate: from, endDate: to }],
    dimensions: dimensionNames.map(function (d) { return { name: d[0] }; }),
    metrics:    metricNames.map(function (m) { return { name: m }; }),
    limit:      ROW_LIMIT
  };

  var res;
  try {
    res = AnalyticsData.Properties.runReport(request, 'properties/' + GA4_PROPERTY);
  } catch (e) {
    write_(sheetName, [['取得失敗'], [String(e)]]);
    return;
  }

  var header = (res.dimensionHeaders || []).map(function (h) { return h.name; })
    .concat((res.metricHeaders || []).map(function (h) { return h.name; }));
  var rows = [header];
  var list = res.rows || [];
  for (var i = 0; i < list.length; i++) {
    var dv = (list[i].dimensionValues || []).map(function (v) { return v.value; });
    var mv = (list[i].metricValues    || []).map(function (v) { return Number(v.value); });
    rows.push(dv.concat(mv));
  }
  if (list.length === 0) rows.push(['データなし']);
  write_(sheetName, rows);
}

/** スクリプト自身の認可トークンでGoogleのAPIを叩く。bodyがあればPOST。 */
function callApi_(url, body) {
  var options = {
    method: body ? 'post' : 'get',
    headers: { Authorization: 'Bearer ' + ScriptApp.getOAuthToken() },
    muteHttpExceptions: true
  };
  if (body) {
    options.contentType = 'application/json';
    options.payload = JSON.stringify(body);
  }

  var res  = UrlFetchApp.fetch(url, options);
  var code = res.getResponseCode();
  var text = res.getContentText();
  if (code < 200 || code >= 300) throw new Error('HTTP ' + code + ' ' + text);
  return JSON.parse(text);
}

/** シートをまるごと置き換える。無ければ作る。 */
function write_(sheetName, rows) {
  var ss    = SpreadsheetApp.getActive();
  var sheet = ss.getSheetByName(sheetName) || ss.insertSheet(sheetName);
  sheet.clear();
  if (!rows.length) return;

  var width = 0;
  for (var i = 0; i < rows.length; i++) width = Math.max(width, rows[i].length);
  for (var j = 0; j < rows.length; j++) {
    while (rows[j].length < width) rows[j].push('');
  }

  sheet.getRange(1, 1, rows.length, width).setValues(rows);
  sheet.setFrozenRows(1);
}

function ymd_(d) {
  return Utilities.formatDate(d, 'Asia/Tokyo', 'yyyy-MM-dd');
}

function daysAgo_(n) {
  var d = new Date();
  d.setDate(d.getDate() - n);
  return ymd_(d);
}

function monthsAgo_(n) {
  var d = new Date();
  d.setMonth(d.getMonth() - n);
  return ymd_(d);
}
