<?php

// JIN:R 側(theme-style)が後から同じ style.css を読み、ver 固定の古いキャッシュで
// こちらの指定を打ち消すため、優先度を下げて必ず最後に読み込ませる
add_action('wp_enqueue_scripts', 'gouter_theme_enqueue_styles', 999);
function gouter_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

	wp_enqueue_style(
		'gouter-fonts',
		'https://fonts.googleapis.com/css2?family=Zen+Old+Mincho:wght@400;500;600&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap',
		array(),
		null
	);

	// バージョンを 1.00 固定にすると、CSSを更新してもURLが変わらず
	// 再訪問者に古いスタイルが残り続けるため、更新時刻を使う
	$css = get_stylesheet_directory() . '/style.css';
	wp_enqueue_style(
		'gouter-front',
		get_stylesheet_directory_uri() . '/style.css',
		array('parent-style', 'gouter-fonts'),
		file_exists($css) ? filemtime($css) : wp_get_theme()->get('Version')
	);
}

/**
 * この子テーマの style.css は JIN:R 側(handle: theme-style)からも読み込まれ、
 * そちらは ver=7.1 固定のため、更新しても古いCSSがキャッシュから使われ、
 * 後勝ちで新しい指定を打ち消してしまう。
 * どの handle から読まれても更新時刻が付くように src を正規化する。
 */
add_filter('style_loader_src', 'gouter_style_version', 10, 2);
function gouter_style_version($src, $handle)
{
	$css = get_stylesheet_directory() . '/style.css';
	$uri = get_stylesheet_directory_uri() . '/style.css';

	if (file_exists($css) && strpos($src, $uri) === 0) {
		return add_query_arg('ver', filemtime($css), $uri);
	}
	return $src;
}

/**
 * Contact Form 7 のフォームID
 * 管理画面「お問い合わせ」のショートコード [contact-form-7 id="◯◯"] の数値を入れる
 */
if (!defined('GOUTER_CF7_ID')) {
	define('GOUTER_CF7_ID', 'cd451e2');
}

function gouter_contact_form()
{
	if (GOUTER_CF7_ID && shortcode_exists('contact-form-7')) {
		echo do_shortcode('[contact-form-7 id="' . esc_attr(GOUTER_CF7_ID) . '"]');
		return;
	}
	echo '<p style="font-size:13px;line-height:1.9">functions.php の GOUTER_CF7_ID に Contact Form 7 のフォームIDを設定してください。</p>';
}

/**
 * 画像出力。assets/img/ にファイルがあれば img、無ければプレースホルダ。
 */
function gouter_image($file, $alt, $ratio_class, $args = array())
{
	$path = get_stylesheet_directory() . '/assets/img/' . $file;

	if ($file && file_exists($path)) {
		// width/height を出して CLS を防ぐ。ヒーローだけ eager にして LCP を早める
		$size = @getimagesize($path);
		$dim  = $size ? sprintf(' width="%d" height="%d"', $size[0], $size[1]) : '';
		$load = !empty($args['eager'])
			? ' loading="eager" fetchpriority="high" decoding="async"'
			: ' loading="lazy" decoding="async"';
		printf(
			'<img class="%1$s" src="%2$s" alt="%3$s"%4$s%5$s />',
			esc_attr($ratio_class),
			esc_url(get_stylesheet_directory_uri() . '/assets/img/' . $file),
			esc_attr($alt),
			$dim,
			$load
		);
		return;
	}

	printf('<div class="gt-ph %1$s">%2$s</div>', esc_attr($ratio_class), esc_html($alt));
}
