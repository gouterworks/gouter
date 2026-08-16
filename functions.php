<?php

add_action('wp_enqueue_scripts', 'gouter_theme_enqueue_styles');
function gouter_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

	wp_enqueue_style(
		'gouter-fonts',
		'https://fonts.googleapis.com/css2?family=Zen+Old+Mincho:wght@400;500;600&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'gouter-front',
		get_stylesheet_directory_uri() . '/style.css',
		array('parent-style', 'gouter-fonts'),
		wp_get_theme()->get('Version')
	);
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
function gouter_image($file, $alt, $ratio_class)
{
	$path = get_stylesheet_directory() . '/assets/img/' . $file;

	if ($file && file_exists($path)) {
		printf(
			'<img class="%1$s" src="%2$s" alt="%3$s" loading="lazy" />',
			esc_attr($ratio_class),
			esc_url(get_stylesheet_directory_uri() . '/assets/img/' . $file),
			esc_attr($alt)
		);
		return;
	}

	printf('<div class="gt-ph %1$s">%2$s</div>', esc_attr($ratio_class), esc_html($alt));
}
