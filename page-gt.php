<?php
/**
 * 下層ページ共通テンプレート。
 * /service・/contact・/privacy-policy・/sitemap で使う。
 * 本文はデータベース側にあるので the_content() をそのまま出し、
 * 見た目だけトップページと揃える。
 *
 * どのページに適用するかは functions.php の gouter_page_template() で決めている。
 */

$gt_id   = get_queried_object_id();
$gt_slug = get_post_field( 'post_name', $gt_id );

// ページごとの英字ラベルと説明文。未定義のページは汎用の文言にする
$gt_meta = array(
	'service'        => array(
		'title'=> '事業内容',
		'en'   => 'SERVICE',
		'lead' => 'コミュニケーションデザインという考え方と、実際にお引き受けしている仕事の内容です。',
		'desc' => 'Goûter（グーテ）の事業内容。コミュニケーションデザインという考え方と、コンサルティング、クライアント案件制作、運営サポート・代行、WEBソリューションまで。福岡県宗像市から福岡県全域に対応しています。',
		'cta'  => true,
	),
	'contact'        => array(
		'title'=> 'お問い合わせ',
		'en'   => 'CONTACT',
		'lead' => '「何が問題なのかわからない」からでも大丈夫です。お気軽にご連絡ください。',
		'desc' => '福岡県宗像市のコミュニケーションデザイン事務所 Goûter（グーテ）へのお問い合わせ。ホームページ、SNS、広報、広告、商品、仕組みづくりのご相談を承っています。',
		'cta'  => false,
	),
	'privacy-policy' => array(
		'en'   => 'PRIVACY POLICY',
		'lead' => '',
		'desc' => 'コミュニケーションデザイン事務所 Goûter（グーテ）のプライバシーポリシーです。',
		'cta'  => false,
	),
	'sitemap'        => array(
		'en'   => 'SITEMAP',
		'lead' => '',
		'desc' => 'コミュニケーションデザイン事務所 Goûter（グーテ）のサイトマップです。',
		'cta'  => false,
	),
);
$gt = isset( $gt_meta[ $gt_slug ] ) ? $gt_meta[ $gt_slug ] : array(
	'en'   => 'PAGE',
	'lead' => '',
	'desc' => get_bloginfo( 'description' ),
	'cta'  => true,
);

// WordPress 側のページ名がスラッグのまま（service / contact）のものがあるので、
// 表示用の日本語見出しを持っている場合はそちらを使う
$gt_name = isset( $gt['title'] ) ? $gt['title'] : get_the_title( $gt_id );

$gt_title = $gt_name . '｜コミュニケーションデザイン事務所 Goûter（グーテ）';

add_filter( 'pre_get_document_title', function () use ( $gt_title ) {
	return $gt_title;
}, 99 );

add_action( 'wp_head', function () use ( $gt, $gt_title, $gt_id, $gt_name ) {
	$url = get_permalink( $gt_id );
	$img = get_stylesheet_directory_uri() . '/assets/img/hero.jpg';

	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $gt['desc'] ) );
	printf( '<meta property="og:type" content="article" />' . "\n" );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="ja_JP" />' . "\n" );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $gt_title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $gt['desc'] ) );
	printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $img ) );
	printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
	printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $img ) );

	$ld = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(
			array( '@type' => 'ListItem', 'position' => 1, 'name' => 'ホーム', 'item' => home_url( '/' ) ),
			array( '@type' => 'ListItem', 'position' => 2, 'name' => $gt_name, 'item' => $url ),
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 1 );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
<style>
  /* 親テーマ（JIN:R）のレイアウト制約を打ち消す */
  #wrapper, #contents, #main, .main-inner, .content-inner {
    max-width: none;
    width: auto;
    margin: 0;
    padding: 0;
    float: none;
  }
  body { padding-top: 0 !important; }
</style>
</head>
<body <?php body_class(); ?>>
<div class="gt">

  <?php require get_stylesheet_directory() . '/parts/header.php'; ?>

  <main id="top">

    <section class="gt-pagehead">
      <div class="gt__wrap">
        <nav class="gt-crumb" aria-label="パンくず">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a> ／ <?php echo esc_html( $gt_name ); ?>
        </nav>
        <p class="gt-en"><?php echo esc_html( $gt['en'] ); ?></p>
        <h1 class="gt-h1"><?php echo esc_html( $gt_name ); ?></h1>
        <?php if ( $gt['lead'] ) : ?>
          <p class="gt-lead"><?php echo esc_html( $gt['lead'] ); ?></p>
        <?php endif; ?>
      </div>
    </section>

    <section id="body" class="gt-articlewrap">
      <div class="gt__wrap">
        <div class="gt-article">
          <?php
          while ( have_posts() ) :
              the_post();
              the_content();
          endwhile;
          ?>
        </div>

        <?php if ( $gt['cta'] ) : ?>
        <div class="gt-service__foot">
          <p>「こんなこと、できますか？」からでもどうぞ。</p>
          <a class="gt-btn" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
        </div>
        <?php endif; ?>
      </div>
    </section>

  </main>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>

<script>
(function () {
  if (!('IntersectionObserver' in window)) return;
  var sel = '.gt__wrap > *, .gt-hero > div, .gt-cell, .gt-svc, .gt-flow > li, .gt-why > li, .gt-tri > li, .gt-post, .gt-ctaband__inner';
  var els = document.querySelectorAll(sel);
  for (var i = 0; i < els.length; i++) { els[i].classList.add('gt-reveal'); }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e, n) {
      if (!e.isIntersecting) return;
      var d = (n % 6) * 70;
      setTimeout(function () { e.target.classList.add('is-in'); }, d);
      io.unobserve(e.target);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
  for (var j = 0; j < els.length; j++) { io.observe(els[j]); }
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
