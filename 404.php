<?php
/**
 * 見つからなかったときのページ。
 *
 * 子テーマに404のテンプレートが無く、JIN:R標準の見た目が出ていた。
 * GA4で見ると、2026年6〜8月の3か月で113本のURLに約126セッションが
 * 落ちている（消した記事のURLが、検索結果やブックマークに残っている）。
 * 消えた記事は戻せないので、**来た人をそこで終わらせない**ことだけをする。
 *
 * 置くもの：検索窓／よく読まれている記事／最近の記事／相談への導線。
 *
 * archive.php と同じ考え方で、親テーマのヘッダー・フッターは使わず自前で組む。
 * JIN:R は description などを親の header.php に直接書き出しているため、
 * get_header() を呼ばないテンプレートでは自前で出す必要がある。
 */

$gt_title = 'ページが見つかりません｜コミュニケーションデザイン事務所 Goûter（グーテ）';

add_filter( 'pre_get_document_title', function () use ( $gt_title ) {
	return $gt_title;
}, 99 );

add_action( 'wp_head', function () {
	// 404は検索エンジンに載せない。follow は残してリンクは辿らせる
	echo '<meta name="robots" content="noindex,follow" />' . "\n";
	echo '<meta property="og:type" content="website" />' . "\n";
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	echo '<meta property="og:locale" content="ja_JP" />' . "\n";
}, 1 );

/**
 * よく読まれている記事。
 * 2026-09-02にGA4（6/1〜9/2）で確認した上位。順に193／88／49セッション。
 * 数字が変わったら入れ替える。存在しないIDは自動で飛ばす。
 */
$gt_popular = array( 4212, 7864, 567 );
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
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a> ／ ページが見つかりません
        </nav>
        <p class="gt-en">NOT FOUND</p>
        <h1 class="gt-h1">お探しのページが見つかりません</h1>
        <p class="gt-lead">
          お探しのページは、移動または削除された可能性があります。
          お手数ですが、検索するか、下の記事からお探しください。
        </p>

        <form class="gt-404search" role="search" method="get"
              action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <label class="gt-404search__label" for="gt-404-s">サイト内を検索</label>
          <div class="gt-404search__row">
            <input id="gt-404-s" type="search" name="s" placeholder="キーワードを入れる"
                   value="<?php echo esc_attr( get_search_query() ); ?>" />
            <button type="submit">検索</button>
          </div>
        </form>
      </div>
    </section>

    <?php
    // よく読まれている記事（存在するものだけ出す）
    $gt_pop_ids = array();
    foreach ( $gt_popular as $gt_pid ) {
        if ( 'publish' === get_post_status( $gt_pid ) ) {
            $gt_pop_ids[] = $gt_pid;
        }
    }
    if ( $gt_pop_ids ) :
        $gt_pop = new WP_Query( array(
            'post__in'            => $gt_pop_ids,
            'orderby'             => 'post__in',
            'posts_per_page'      => count( $gt_pop_ids ),
            'ignore_sticky_posts' => true,
        ) );
        ?>
        <section class="gt-archivewrap">
          <div class="gt__wrap">
            <h2 class="gt-h2">よく読まれています</h2>
            <div class="gt-posts">
              <?php while ( $gt_pop->have_posts() ) : $gt_pop->the_post(); ?>
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
                  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 44, '…' ) ); ?></p>
                </article>
              <?php endwhile; ?>
            </div>
          </div>
        </section>
        <?php
        wp_reset_postdata();
    endif;

    // 最近の記事
    $gt_recent = new WP_Query( array(
        'posts_per_page'      => 6,
        'post__not_in'        => $gt_pop_ids,
        'ignore_sticky_posts' => true,
    ) );
    if ( $gt_recent->have_posts() ) :
        ?>
        <section class="gt-archivewrap">
          <div class="gt__wrap">
            <h2 class="gt-h2">最近の記事</h2>
            <div class="gt-posts">
              <?php while ( $gt_recent->have_posts() ) : $gt_recent->the_post(); ?>
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
                  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 44, '…' ) ); ?></p>
                </article>
              <?php endwhile; ?>
            </div>
            <div class="gt-empty">
              <a class="gt-btn--ghost" href="<?php echo esc_url( get_category_link( 110 ) ); ?>">読みものを全部見る</a>
            </div>
          </div>
        </section>
        <?php
        wp_reset_postdata();
    endif;
    ?>

    <aside class="gt-ctaband" aria-label="相談への案内">
      <div class="gt-ctaband__inner">
        <p>探しているものが見つからないときは、聞いてください。</p>
        <a class="gt-btn gt-btn--light" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
      </div>
    </aside>

  </main>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
