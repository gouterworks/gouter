<?php
/**
 * 記事一覧（カテゴリ・タグ・日付・書き手・検索）。
 *
 * これまで一覧のテンプレートが1枚も無く、「読みものを全部見る」の
 * 飛び先が JIN:R 標準の見た目のままだった。記事を主役にする以上、
 * 記事の入り口がサイトから浮いているのは致命的なので作る。
 *
 * single.php / page-gt.php と同じ考え方で、親テーマのヘッダー・
 * フッターを使わず自前で組む。
 *
 * search.php はこのファイルを読み込むだけ。分岐は is_search() で持つ。
 *
 * ■ SEO について
 * JIN:R は description / canonical / OGP を親テーマの header.php に
 * 直接書き出している（wp_head 経由ではない）。get_header() を呼ばない
 * このテンプレートでは丸ごと消えるため、自前で出す。
 */

$gt_obj   = get_queried_object();
$gt_total = (int) $GLOBALS['wp_query']->found_posts;
$gt_page  = max( 1, (int) get_query_var( 'paged' ) );

/**
 * 見出しに重ねる英字ラベル。
 * スラッグが日本語のカテゴリもあるので、英数字にならなければ ARTICLE に戻す。
 */
$gt_en = 'ARTICLE';
if ( is_category() || is_tag() ) {
	$gt_try = gouter_cat_en( $gt_obj );
	if ( preg_match( '/\A[A-Z0-9 -]+\z/', $gt_try ) ) {
		$gt_en = $gt_try;
	}
}

if ( is_search() ) {
	$gt_en    = 'SEARCH';
	$gt_name  = '「' . get_search_query() . '」の検索結果';
	$gt_lead  = '';
	$gt_crumb = '検索結果';
} elseif ( is_category() || is_tag() ) {
	$gt_name  = gouter_cat_label( $gt_obj );
	$gt_lead  = trim( wp_strip_all_tags( term_description() ) );
	$gt_crumb = $gt_name;
} elseif ( is_author() ) {
	$gt_en    = 'AUTHOR';
	$gt_name  = get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) );
	$gt_lead  = '';
	$gt_crumb = $gt_name;
} elseif ( is_date() ) {
	$gt_en    = 'ARCHIVE';
	$gt_name  = wp_strip_all_tags( get_the_archive_title() );
	$gt_lead  = '';
	$gt_crumb = $gt_name;
} else {
	$gt_name  = '読みもの';
	$gt_lead  = '';
	$gt_crumb = $gt_name;
}

// カテゴリの説明文が未設定でも一覧が寂しくならないよう、既定の一文を置く
if ( '' === $gt_lead && ! is_search() ) {
	$gt_lead = 'Webのこと。SNSのこと。広報や広告のこと。事業や売上、店舗や商品、仕事の進め方のこと。現場で使えるノウハウを公開しています。';
}

$gt_title = $gt_name;
if ( $gt_page > 1 ) {
	$gt_title .= '（' . $gt_page . 'ページ目）';
}
$gt_title .= '｜コミュニケーションデザイン事務所 Goûter（グーテ）';

$gt_desc = is_search()
	? $gt_name . '。コミュニケーションデザイン事務所 Goûter（グーテ）のサイト内検索です。'
	: ( function_exists( 'mb_substr' ) ? mb_substr( $gt_lead, 0, 120 ) : substr( $gt_lead, 0, 360 ) );

add_filter( 'pre_get_document_title', function () use ( $gt_title ) {
	return $gt_title;
}, 99 );

add_action( 'wp_head', function () use ( $gt_title, $gt_desc ) {
	// 検索結果は中身が毎回変わるので検索エンジンに載せない
	if ( is_search() ) {
		echo '<meta name="robots" content="noindex,follow" />' . "\n";
	}

	// ページ送りの2ページ目以降も、そのページ自身を正とする
	// （1ページ目にまとめると2ページ目以降が拾われなくなる）
	$url = is_search()
		? get_search_link()
		: ( is_category() || is_tag() ? get_term_link( get_queried_object() ) : home_url( add_query_arg( array() ) ) );

	if ( ! is_wp_error( $url ) ) {
		$paged = max( 1, (int) get_query_var( 'paged' ) );
		if ( $paged > 1 ) {
			$url = trailingslashit( $url ) . 'page/' . $paged . '/';
		}
		printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
	}

	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $gt_desc ) );
	echo '<meta property="og:type" content="website" />' . "\n";
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	echo '<meta property="og:locale" content="ja_JP" />' . "\n";
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $gt_title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $gt_desc ) );
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
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a> ／ <?php echo esc_html( $gt_crumb ); ?>
        </nav>
        <p class="gt-en"><?php echo esc_html( $gt_en ); ?></p>
        <h1 class="gt-h1"><?php echo esc_html( $gt_name ); ?></h1>
        <?php if ( $gt_lead ) : ?>
          <p class="gt-lead"><?php echo esc_html( $gt_lead ); ?></p>
        <?php endif; ?>
        <?php if ( $gt_total ) : ?>
          <p class="gt-archivecount"><?php echo esc_html( number_format_i18n( $gt_total ) ); ?> 記事</p>
        <?php endif; ?>
      </div>
    </section>

    <section class="gt-archivewrap">
      <div class="gt__wrap">

        <?php if ( have_posts() ) : ?>

          <div class="gt-posts">
            <?php
            while ( have_posts() ) :
                the_post();
                // カテゴリ一覧では全部同じカテゴリなので、札は出さない
                $gt_show_cat = ! is_category();
                $gt_c        = $gt_show_cat ? gouter_post_cat( get_the_ID() ) : null;
                ?>
                <article class="gt-post">
                  <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php if ( has_post_thumbnail() ) : ?>
                      <?php the_post_thumbnail( 'medium_large', array( 'class' => 'gt-ratio-169' ) ); ?>
                    <?php else : ?>
                      <div class="gt-ph gt-ratio-169">サムネイル未設定（16:9）</div>
                    <?php endif; ?>
                  </a>
                  <div class="gt-post__meta">
                    <?php if ( $gt_c && $gt_c->term_id ) : ?>
                      <span class="gt-post__cat"><?php echo esc_html( gouter_cat_label( $gt_c ) ); ?></span>
                    <?php endif; ?>
                    <span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                  </div>
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 44, '…' ) ); ?></p>
                </article>
                <?php
            endwhile;
            ?>
          </div>

          <?php
          $gt_links = paginate_links( array(
              'type'      => 'array',
              'prev_text' => '前へ',
              'next_text' => '次へ',
              'mid_size'  => 1,
              'end_size'  => 1,
          ) );
          if ( $gt_links ) :
              ?>
              <nav class="gt-pager" aria-label="ページ送り">
                <ul>
                  <?php foreach ( $gt_links as $gt_l ) : ?>
                    <li><?php echo $gt_l; // paginate_links() が組んだリンク。エスケープ済み ?></li>
                  <?php endforeach; ?>
                </ul>
              </nav>
              <?php
          endif;
          ?>

        <?php else : ?>

          <div class="gt-empty">
            <p>該当する記事が見つかりませんでした。</p>
            <?php if ( is_search() ) : ?>
              <p class="gt-empty__sub">言葉を変えて、もう一度お試しください。</p>
            <?php endif; ?>
            <a class="gt-btn--ghost" href="<?php echo esc_url( get_category_link( 110 ) ); ?>">読みものを全部見る</a>
          </div>

        <?php endif; ?>

      </div>
    </section>

    <aside class="gt-ctaband" aria-label="相談への案内">
      <div class="gt-ctaband__inner">
        <p>読むだけでは進まないことも、話せば動きます。</p>
        <a class="gt-btn gt-btn--light" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
      </div>
    </aside>

  </main>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
