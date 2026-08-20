<?php
/**
 * /service（固定ページ ID 38）専用テンプレート。
 * 本文はデータベース側にあるので the_content() をそのまま出し、
 * 見た目だけトップページと揃える。
 */

add_filter( 'pre_get_document_title', function () {
	return '事業内容｜コミュニケーションデザイン事務所 Goûter（グーテ）｜福岡・宗像市';
}, 99 );

add_action( 'wp_head', function () {
	$title = '事業内容｜コミュニケーションデザイン事務所 Goûter（グーテ）';
	$desc  = 'Goûter（グーテ）の事業内容。コミュニケーションデザインという考え方と、コンサルティング、クライアント案件制作、運営サポート・代行、WEBソリューションまで。福岡県宗像市から、福岡県全域に対応しています。';
	$url   = get_permalink();
	$img   = get_stylesheet_directory_uri() . '/assets/img/comdesign.jpg';

	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="article" />' . "\n" );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="ja_JP" />' . "\n" );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $img ) );
	printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
	printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $img ) );

	// パンくず。トップ → 事業内容
	$ld = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(
			array( '@type' => 'ListItem', 'position' => 1, 'name' => 'ホーム', 'item' => home_url( '/' ) ),
			array( '@type' => 'ListItem', 'position' => 2, 'name' => '事業内容', 'item' => $url ),
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
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a> ／ 事業内容
        </nav>
        <p class="gt-en">SERVICE</p>
        <h1 class="gt-h1">事業内容</h1>
        <p class="gt-lead">コミュニケーションデザインという考え方と、実際にお引き受けしている仕事の内容です。</p>
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

        <div class="gt-service__foot">
          <p>「こんなこと、できますか？」からでもどうぞ。</p>
          <a class="gt-btn" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
          <a class="gt-link" href="<?php echo esc_url( home_url( '/' ) ); ?>#service">トップのできることを見る →</a>
        </div>
      </div>
    </section>

  </main>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
