<?php
/**
 * Goûter（STREETIST版）の子テーマ。
 *
 * 旧テーマ(JIN:Rの子)から持ってくるのは、テーマに依存しない道具だけにする。
 * template_include で親のテンプレートを差し替える仕掛けは持ってこない。
 * 記事・一覧・トップ以外の固定ページは STREETIST に任せる方針のため。
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * 子テーマのCSSを読む。
 *
 * 優先度20は親テーマより後に出すため。詳細度ではなく読み込み順で勝つ。
 * ver に更新時刻を入れて、直したのに反映されない事故を防ぐ。
 */
add_action('wp_enqueue_scripts', 'gouter_st_styles', 20);
function gouter_st_styles()
{
	$css = get_stylesheet_directory() . '/style.css';

	wp_enqueue_style(
		'gouter-st',
		get_stylesheet_uri(),
		array(),
		file_exists($css) ? filemtime($css) : false
	);
}
