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
 * 固定ページを Goûter のテンプレート(page-gt.php)で表示する。
 *
 * 固定ページには管理画面で JIN:R のカスタムテンプレート
 * (template-full-width 等) が割り当てられており、WordPress の
 * テンプレート階層では page-{slug}.php より優先されてしまう。
 * そのため template_include で明示的に差し替える。
 *
 * 以前は 事業内容 / お問い合わせ / プライバシーポリシー / サイトマップ の
 * 4枚を ID で名指ししていたが、ページを足すたびに ID を書き足す必要があり、
 * 書き忘れるとそのページだけ JIN:R の見た目で出てしまう。
 * サイト全体が Goûter のデザインになった今は、全固定ページを対象にする。
 *
 * ただしトップページは front-page.php が受け持つ。ホームページの表示を
 * 固定ページにしているため、除外しないとトップまで下層の見た目になる。
 */
add_filter('template_include', 'gouter_page_template', 99);
function gouter_page_template($template)
{
	if (is_page() && !is_front_page()) {
		$mine = get_stylesheet_directory() . '/page-gt.php';
		if (file_exists($mine)) {
			return $mine;
		}
	}
	return $template;
}

/**
 * /service 本文に残っている「※特に、飲食業界の方へ」のブロックを表示から外す。
 * 特定の業界を強みとして打ち出さない方針のため。
 *
 * 注意: これは表示時に取り除いているだけで、文章そのものは
 * WordPress のデータベースに残っている。恒久的に消すには
 * 管理画面から該当ブロックを削除すること。
 */
add_filter('the_content', 'gouter_strip_food_block', 20);
function gouter_strip_food_block($content)
{
	if (strpos($content, '特に、飲食業界の方へ') === false) {
		return $content;
	}
	// JIN:R の simplebox セクション単位で取り除く
	$pattern = '#<section class="wp-block-jinr-blocks-simplebox.*?</section>#s';
	return preg_replace_callback($pattern, function ($m) {
		return (strpos($m[0], '特に、飲食業界の方へ') !== false) ? '' : $m[0];
	}, $content);
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

/**
 * 記事詳細を Goûter のテンプレート(single.php)で表示する。
 *
 * 子テーマの single.php はテンプレート階層でも選ばれるはずだが、
 * 固定ページと同じく JIN:R 側が template_include で差し替えてくる
 * 可能性があるため、こちらでも明示して確実にする。
 */
add_filter('template_include', 'gouter_single_template', 100);
function gouter_single_template($template)
{
	if (is_singular('post')) {
		$mine = get_stylesheet_directory() . '/single.php';
		if (file_exists($mine)) {
			return $mine;
		}
	}
	return $template;
}

/**
 * 記事の代表カテゴリ。複数付いていても最初のひとつを使う。
 * カテゴリが無い記事でも落ちないよう、既定カテゴリに退避する。
 */
function gouter_post_cat($post_id)
{
	$cats = get_the_category($post_id);

	if (!empty($cats)) {
		return $cats[0];
	}

	$fallback = get_category(get_option('default_category'));
	return $fallback ? $fallback : (object) array('term_id' => 0, 'slug' => '', 'name' => '', 'count' => 0);
}

/**
 * カテゴリの表示名。
 *
 * WordPress 側のカテゴリ名が英小文字のスラッグのまま（column / information）
 * なので、画面に出す日本語名をここで持つ。管理画面のカテゴリ名を
 * 日本語に変えれば、この対応表は不要になる。
 */
function gouter_cat_label($term)
{
	$map = array(
		'column'      => '読みもの',
		'information' => 'お知らせ',
	);

	$slug = is_object($term) ? $term->slug : (string) $term;

	if (isset($map[$slug])) {
		return $map[$slug];
	}
	return is_object($term) ? $term->name : $slug;
}

/**
 * 見出しに重ねる大きな英字ラベル。
 */
function gouter_cat_en($term)
{
	$slug = is_object($term) ? $term->slug : (string) $term;
	return $slug ? strtoupper($slug) : 'ARTICLE';
}

/**
 * 記事の description。
 *
 * 優先順位:
 *  1. JIN:R の記事ごとの説明文（管理画面で個別に設定したもの）
 *  2. 本文に紛れ込んでいる <meta name="description"> の中身
 *     ※ 5記事で、書いた説明文が本文の先頭に貼り付けられている。
 *       本来 head に入るものなので、そこから拾って head に出す。
 *  3. 本文の先頭120文字
 */
function gouter_post_description($post_id)
{
	$set = trim((string) get_post_meta($post_id, '_jinr_description_display', true));
	if ($set !== '') {
		return $set;
	}

	$raw = (string) get_post_field('post_content', $post_id);

	if (preg_match('/<meta\s[^>]*name=["\']description["\'][^>]*content=["\']([^"\']*)["\']/i', $raw, $m)) {
		$found = trim(html_entity_decode($m[1], ENT_QUOTES, 'UTF-8'));
		if ($found !== '') {
			return $found;
		}
	}

	$text = wp_strip_all_tags(strip_shortcodes($raw));
	$text = trim(preg_replace('/\s+/u', ' ', $text));

	return function_exists('mb_substr') ? mb_substr($text, 0, 120) : substr($text, 0, 360);
}

/**
 * 本文に貼り付けられてしまった <meta> タグを表示から取り除く。
 *
 * <meta> は本来 head に置くもので、本文にあると空の段落が残るだけになる。
 * 中身は gouter_post_description() が head の description として使うので、
 * 情報は失われない。データベース側は書き換えていない。
 */
add_filter('the_content', 'gouter_strip_stray_meta', 20);
function gouter_strip_stray_meta($content)
{
	if (stripos($content, '<meta') === false) {
		return $content;
	}

	// <p><meta ...></p> ごと消す。残すと空の段落の余白だけが残る
	$content = preg_replace('/<p[^>]*>\s*<meta\b[^>]*>\s*<\/p>/i', '', $content);

	return preg_replace('/<meta\b[^>]*>/i', '', $content);
}

/**
 * サイトのロゴ。
 *
 * ファイル名を直書きすると、差し替えのたびにテーマの再アップロードが要る。
 * WordPress 標準の「カスタムロゴ」に対応させて、管理画面
 * （外観 → カスタマイズ → サイト基本情報 → ロゴ）で差し替えられるようにする。
 *
 * 親テーマ(JIN:R)も after_setup_theme で custom-logo を宣言している可能性があり、
 * 子テーマの functions.php は親より先に読まれる。同じ優先度だと親に上書き
 * されるため、優先度を下げて必ず後から宣言する。
 */
add_action('after_setup_theme', 'gouter_logo_support', 20);
function gouter_logo_support()
{
	add_theme_support('custom-logo', array(
		'height'      => 72,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	));
}

/**
 * ロゴを出力する。ヘッダーとフッターの両方から呼ぶ。
 *
 * 探す順番:
 *  1. 管理画面のカスタムロゴ
 *  2. テーマ内の assets/img/logo.svg / logo.png（1が使えないテーマ設定のときの逃げ道）
 *  3. どちらも無ければ、これまで通り文字の「Goûter」
 *
 * 3があるので、ロゴが未設定でもヘッダーが空になることはない。
 */
function gouter_logo()
{
	$id = get_theme_mod('custom_logo');

	if ($id && wp_attachment_is_image($id)) {
		echo wp_get_attachment_image($id, 'full', false, array(
			'class' => 'gt-logo__img',
			'alt'   => get_bloginfo('name'),
		));
		return;
	}

	foreach (array('logo.svg', 'logo.png') as $file) {
		$path = get_stylesheet_directory() . '/assets/img/' . $file;

		if (file_exists($path)) {
			printf(
				'<img class="gt-logo__img" src="%1$s" alt="%2$s" />',
				esc_url(get_stylesheet_directory_uri() . '/assets/img/' . $file),
				esc_attr(get_bloginfo('name'))
			);
			return;
		}
	}

	echo 'Goûter';
}

/**
 * 記事一覧を Goûter のテンプレート(archive.php / search.php)で表示する。
 *
 * 固定ページや記事詳細と同じく、JIN:R 側が template_include で
 * 差し替えてくるため、こちらでも明示して確実にする。
 */
add_filter('template_include', 'gouter_archive_template', 100);
function gouter_archive_template($template)
{
	if (is_search()) {
		$mine = get_stylesheet_directory() . '/search.php';
		if (file_exists($mine)) {
			return $mine;
		}
	}

	if (is_category() || is_tag() || is_date() || is_author() || is_home()) {
		$mine = get_stylesheet_directory() . '/archive.php';
		if (file_exists($mine)) {
			return $mine;
		}
	}

	return $template;
}

/**
 * 一覧に出す記事数。
 *
 * 既定の10本だと3列のグリッドで最後の行が1本だけ残って落ち着かない。
 * 12本にすると 3列×4行 / 2列×6行 のどちらでも埋まる。
 */
add_action('pre_get_posts', 'gouter_archive_per_page');
function gouter_archive_per_page($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	if ($query->is_category() || $query->is_tag() || $query->is_date() || $query->is_author() || $query->is_search()) {
		$query->set('posts_per_page', 12);
	}
}

/**
 * 記事の横に出すウィジェットエリアを決める。
 *
 * JIN:R が登録しているウィジェットエリアの id は親テーマ側にあり、
 * この子テーマからは分からない。決め打ちすると親の更新で外れるので、
 * 実行時に登録済みのものから選ぶ。
 *
 * 中身が入っているエリアだけを対象にする。空のエリアを出しても
 * サイドバーが痩せて見えるだけで、意味がない。
 */
function gouter_article_sidebar_id()
{
	global $wp_registered_sidebars;

	if (empty($wp_registered_sidebars) || !is_array($wp_registered_sidebars)) {
		return '';
	}

	// フッターやトップページ専用のエリアを記事の横に出すと的外れになる
	$skip = array('footer', 'front', 'home', 'top', 'mobile', 'header');

	foreach ($wp_registered_sidebars as $id => $sidebar) {
		$hay = strtolower($id . ' ' . (isset($sidebar['name']) ? $sidebar['name'] : ''));

		foreach ($skip as $ng) {
			if (strpos($hay, $ng) !== false) {
				continue 2;
			}
		}

		if (is_active_sidebar($id)) {
			return $id;
		}
	}

	return '';
}

/**
 * 記事詳細のレイアウト設定。
 *
 * 外観 → カスタマイズ →「記事詳細のレイアウト」で変えられるようにする。
 *
 * 親テーマ(JIN:R)にも記事レイアウトの設定はあるが、その option キーは
 * 親テーマの中にあり、この子テーマからは分からない。決め打ちすると
 * 親の更新で外れて設定が効かなくなるため、こちらで項目を持つ。
 */
function gouter_article_layout()
{
	return array(
		'sidebar'  => (bool) get_theme_mod('gouter_article_sidebar', true),
		'position' => get_theme_mod('gouter_article_sidebar_position', 'right') === 'left' ? 'left' : 'right',
		'side_w'   => gouter_sanitize_side_width(get_theme_mod('gouter_article_sidebar_width', 320)),
		'body_w'   => gouter_sanitize_body_width(get_theme_mod('gouter_article_body_width', 46)),
		'sticky'   => (bool) get_theme_mod('gouter_article_sidebar_sticky', true),
	);
}

function gouter_sanitize_bool($value)
{
	return (bool) $value;
}

function gouter_sanitize_side_position($value)
{
	return $value === 'left' ? 'left' : 'right';
}

// 極端な値を入れられるとレイアウトが壊れるので、両端で止める
function gouter_sanitize_side_width($value)
{
	return max(240, min(440, (int) $value));
}

function gouter_sanitize_body_width($value)
{
	return max(34, min(64, (int) $value));
}

add_action('customize_register', 'gouter_customize_register');
function gouter_customize_register($wp_customize)
{
	$wp_customize->add_section('gouter_article', array(
		'title'       => '記事詳細のレイアウト',
		'description' => '記事ページの本文とサイドバーの並びを決めます。サイドバーの中身は「ウィジェット」で変えられます。',
		'priority'    => 130,
	));

	$fields = array(
		'gouter_article_sidebar' => array(
			'default'  => true,
			'sanitize' => 'gouter_sanitize_bool',
			'label'    => 'サイドバーを出す',
			'type'     => 'checkbox',
		),
		'gouter_article_sidebar_position' => array(
			'default'  => 'right',
			'sanitize' => 'gouter_sanitize_side_position',
			'label'    => 'サイドバーの位置',
			'type'     => 'radio',
			'choices'  => array('right' => '右', 'left' => '左'),
		),
		'gouter_article_sidebar_width' => array(
			'default'     => 320,
			'sanitize'    => 'gouter_sanitize_side_width',
			'label'       => 'サイドバーの幅（px）',
			'type'        => 'number',
			'input_attrs' => array('min' => 240, 'max' => 440, 'step' => 10),
		),
		'gouter_article_body_width' => array(
			'default'     => 46,
			'sanitize'    => 'gouter_sanitize_body_width',
			'label'       => '本文の幅（em）',
			'description' => '1行の長さ。46 で約40文字。大きくすると1行が長くなります。',
			'type'        => 'number',
			'input_attrs' => array('min' => 34, 'max' => 64, 'step' => 1),
		),
		'gouter_article_sidebar_sticky' => array(
			'default'  => true,
			'sanitize' => 'gouter_sanitize_bool',
			'label'    => 'サイドバーをスクロールに追従させる',
			'type'     => 'checkbox',
		),
	);

	foreach ($fields as $id => $f) {
		$wp_customize->add_setting($id, array(
			'default'           => $f['default'],
			'sanitize_callback' => $f['sanitize'],
			// 表示に関わる指定なので、触ったらプレビューを読み直して結果を見せる
			'transport'         => 'refresh',
		));

		$control = array(
			'section' => 'gouter_article',
			'label'   => $f['label'],
			'type'    => $f['type'],
		);
		foreach (array('choices', 'input_attrs', 'description') as $k) {
			if (isset($f[$k])) {
				$control[$k] = $f[$k];
			}
		}

		$wp_customize->add_control($id, $control);
	}
}

/**
 * 設定した幅を CSS に流す。
 * クラスで持てる（出す/出さない・左右・追従）はテンプレート側で付ける。
 */
add_action('wp_head', 'gouter_article_layout_css', 20);
function gouter_article_layout_css()
{
	if (!is_singular('post')) {
		return;
	}

	$l = gouter_article_layout();

	printf(
		'<style id="gouter-article-layout">.gt-single{--gt-side-w:%dpx;--gt-article-w:%dem}</style>' . "\n",
		$l['side_w'],
		$l['body_w']
	);
}
