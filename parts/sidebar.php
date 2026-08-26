<?php
/**
 * 記事の横に出すサイドバー。
 *
 * 中身は JIN:R のウィジェット（外観 → ウィジェット）をそのまま出す。
 * 何を並べるかを管理画面で変えられるようにしておきたいので、
 * ここにブロックを直書きはしない。
 *
 * ただし相談への導線だけは、ウィジェットの設定に関係なく必ず出す。
 * このサイトの成果は問い合わせ数で測るため、そこをウィジェット任せにしない。
 */

$gt_sb = gouter_article_sidebar_id();
?>
<aside class="gt-side" aria-label="記事の補助情報">

  <div class="gt-sidecta">
    <p class="gt-sidecta__en">CONTACT</p>
    <p class="gt-sidecta__lead">「何が問題なのかわからない」からでも大丈夫です。</p>
    <a class="gt-btn--sm" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">まず相談してみる</a>
  </div>

  <?php if ( $gt_sb ) : ?>
    <div class="gt-side__widgets">
      <?php dynamic_sidebar( $gt_sb ); ?>
    </div>
  <?php endif; ?>

</aside>
