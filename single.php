<?php
/**
 * 記事詳細（読みもの58本・お知らせ4本）。
 *
 * これまで記事だけが JIN:R 標準の見た目のままで、トップや下層ページと
 * つながっていなかった。page-gt.php と同じ考え方で、親テーマの
 * ヘッダー・フッターを使わず自前で組む。
 *
 * ■ SEO について（重要）
 * JIN:R は description / canonical / OGP を親テーマの header.php に
 * 直接書き出している（wp_head 経由ではない）。get_header() を呼ばない
 * このテンプレートではそれらが丸ごと消えるため、自前で出す。
 * 一方 JSON-LD（BreadcrumbList / Article）と <title> はフック経由なので
 * JIN:R 側がそのまま出す。二重にしないよう、ここでは出さない。
 */

$gt_id  = get_queried_object_id();
$gt_cat = gouter_post_cat( $gt_id );

// 記事詳細のレイアウト（外観 → カスタマイズ →「記事詳細のレイアウト」）。
// 幅は CSS 変数で流し、切り替えで済むものはクラスで持つ
$gt_layout = gouter_article_layout();

$gt_single_class = 'gt-single';
if ( ! $gt_layout['sidebar'] ) {
	$gt_single_class .= ' gt-single--full';
}
if ( 'left' === $gt_layout['position'] ) {
	$gt_single_class .= ' gt-single--left';
}
if ( ! $gt_layout['sticky'] ) {
	$gt_single_class .= ' gt-single--nostick';
}

$gt_desc = gouter_post_description( $gt_id );
$gt_url  = get_permalink( $gt_id );

$gt_canon = trim( (string) get_post_meta( $gt_id, '_jinr_canonical_display', true ) );
if ( '' === $gt_canon ) {
	$gt_canon = $gt_url;
}

$gt_ogimg = trim( (string) get_post_meta( $gt_id, '_jinr_ogp_image_url', true ) );
if ( '' === $gt_ogimg ) {
	$gt_ogimg = get_the_post_thumbnail_url( $gt_id, 'full' );
}
if ( ! $gt_ogimg ) {
	$gt_ogimg = get_stylesheet_directory_uri() . '/assets/img/hero.jpg';
}

add_action( 'wp_head', function () use ( $gt_id, $gt_desc, $gt_url, $gt_canon, $gt_ogimg ) {
	if ( get_post_meta( $gt_id, '_jinr_noindex_display', true ) ) {
		echo '<meta name="robots" content="noindex,follow" />' . "\n";
	}
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $gt_desc ) );
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $gt_canon ) );
	echo '<meta property="og:type" content="article" />' . "\n";
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	echo '<meta property="og:locale" content="ja_JP" />' . "\n";
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $gt_url ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( get_the_title( $gt_id ) . '｜' . get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $gt_desc ) );
	printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $gt_ogimg ) );
	printf( '<meta property="article:published_time" content="%s" />' . "\n", esc_attr( get_the_date( 'c', $gt_id ) ) );
	printf( '<meta property="article:modified_time" content="%s" />' . "\n", esc_attr( get_the_modified_date( 'c', $gt_id ) ) );
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $gt_ogimg ) );
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
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
    <article>

      <header class="gt-posthead">
        <div class="gt__wrap">
          <nav class="gt-crumb" aria-label="パンくず">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a> ／
            <a href="<?php echo esc_url( get_category_link( $gt_cat->term_id ) ); ?>"><?php echo esc_html( gouter_cat_label( $gt_cat ) ); ?></a> ／
            <span><?php the_title(); ?></span>
          </nav>
          <p class="gt-en"><?php echo esc_html( gouter_cat_en( $gt_cat ) ); ?></p>
          <h1 class="gt-posttitle"><?php the_title(); ?></h1>
          <p class="gt-postinfo">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?> 公開</time>
            <?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) : ?>
              <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'Y.m.d' ) ); ?> 更新</time>
            <?php endif; ?>
          </p>
        </div>
      </header>

      <div class="gt-articlewrap">
        <div class="gt__wrap">

          <?php if ( has_post_thumbnail() ) : ?>
            <figure class="gt-postthumb">
              <?php the_post_thumbnail( 'large', array( 'class' => 'gt-ratio-169', 'fetchpriority' => 'high' ) ); ?>
            </figure>
          <?php endif; ?>

          <div class="<?php echo esc_attr( $gt_single_class ); ?>">
            <div class="gt-single__main">

          <div class="gt-article">
            <?php the_content(); ?>
          </div>

          <?php
          /*
           * 記事終わりの広告。
           *
           * JIN:R の single.php は本文のあとで ad-finish を読み込んでいるが、
           * この子テーマは single.php を丸ごと置き換えているため、その行ごと消えていた。
           * 「最初のH2の前」だけ出ていたのは、そちらが the_content のフィルタで
           * 本文に差し込まれるぶん、置き換えの影響を受けなかったため。
           *
           * 親と同じく、記事ごとの「広告を非表示」設定を尊重する。
           * （親の条件式は !get_post_meta(...) == "1" と書かれていて意図が読みにくいので、
           *   同じ挙動になるよう書き直している）
           */
          if ( get_post_meta( get_the_ID(), '_jinr_ads_display', true ) !== '1' ) :
              ?>
              <div class="gt-adfinish"><?php get_template_part( 'ad-finish' ); ?></div>
          <?php endif; ?>

            </div>

            <?php if ( $gt_layout['sidebar'] ) : ?>
              <?php require get_stylesheet_directory() . '/parts/sidebar.php'; ?>
            <?php endif; ?>
          </div>

        </div>
      </div>

    </article>
    <?php endwhile; ?>

    <aside class="gt-ctaband" aria-label="相談への案内">
      <div class="gt-ctaband__inner">
        <p>読んでも、まだ迷うようなら。<span>「こんなこと聞いていいのかな」くらいからで大丈夫です。</span></p>
        <a class="gt-btn gt-btn--light" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
      </div>
    </aside>

    <?php
    // 関連記事の手前の広告。親テーマが ad-related を読み込んでいる位置に合わせる
    if ( get_post_meta( $gt_id, '_jinr_ads_display', true ) !== '1' ) {
        echo '<div class="gt-adrelated gt__wrap">';
        get_template_part( 'ad-related' );
        echo '</div>';
    }

    // 同じカテゴリの新しい記事から3本。読み終えた人の次の一手になるもの
    $gt_rel = new WP_Query( array(
        'post_type'           => 'post',
        'cat'                 => $gt_cat->term_id,
        'posts_per_page'      => 3,
        'post__not_in'        => array( $gt_id ),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ) );
    if ( $gt_rel->have_posts() ) :
        ?>
    <section class="gt-relwrap" aria-labelledby="rel-h">
      <div class="gt__wrap">
        <div class="gt-head">
          <p class="gt-en">READ NEXT</p>
          <h2 id="rel-h" class="gt-h2">続けて読む</h2>
        </div>
        <div class="gt-posts">
          <?php while ( $gt_rel->have_posts() ) : $gt_rel->the_post(); ?>
            <article class="gt-post">
              <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'gt-ratio-169' ) ); ?>
                <?php else : ?>
                  <div class="gt-ph gt-ratio-169">サムネイル未設定（16:9）</div>
                <?php endif; ?>
              </a>
              <div class="gt-post__meta">
                <span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
              </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </article>
          <?php endwhile; ?>
        </div>
        <div class="gt-more">
          <a class="gt-btn--ghost" href="<?php echo esc_url( get_category_link( $gt_cat->term_id ) ); ?>"><?php echo esc_html( gouter_cat_label( $gt_cat ) ); ?>を全部見る（<?php echo esc_html( $gt_cat->count ); ?>記事）</a>
        </div>
      </div>
    </section>
        <?php
        wp_reset_postdata();
    endif;

    $gt_prev = get_adjacent_post( true, '', true, 'category' );
    $gt_next = get_adjacent_post( true, '', false, 'category' );
    if ( $gt_prev || $gt_next ) :
        ?>
    <nav class="gt-pnwrap" aria-label="前後の記事">
      <div class="gt__wrap">
        <ul class="gt-pn">
          <?php if ( $gt_prev ) : ?>
            <li class="gt-pn__prev">
              <a href="<?php echo esc_url( get_permalink( $gt_prev ) ); ?>">
                <span class="gt-pn__label">前の記事</span>
                <span class="gt-pn__title"><?php echo esc_html( get_the_title( $gt_prev ) ); ?></span>
              </a>
            </li>
          <?php endif; ?>
          <?php if ( $gt_next ) : ?>
            <li class="gt-pn__next">
              <a href="<?php echo esc_url( get_permalink( $gt_next ) ); ?>">
                <span class="gt-pn__label">次の記事</span>
                <span class="gt-pn__title"><?php echo esc_html( get_the_title( $gt_next ) ); ?></span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
    <?php endif; ?>

  </main>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>

<script>
(function () {
  if (!('IntersectionObserver' in window)) return;
  var sel = '.gt-posthead .gt__wrap > *, .gt-postthumb, .gt-relwrap .gt__wrap > *, .gt-post, .gt-ctaband__inner, .gt-pn > li';
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
