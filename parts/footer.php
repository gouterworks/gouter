<?php
/**
 * サイト共通フッター。
 */
$gt_home = is_front_page() ? '' : esc_url( home_url( '/' ) );
?>
  <footer class="gt-footer">
    <div class="gt-footer__inner">
      <div>
        <p class="gt-footer__logo"><?php gouter_logo(); ?></p>
        <p class="gt-footer__meta">コミュニケーションデザイン事務所<br />〒811-4173　福岡県宗像市栄町2-1-2F</p>
      </div>
      <nav aria-label="フッターナビゲーション">
        <ul>
          <li><a href="<?php echo $gt_home; ?>#problem">困りごと</a></li>
          <li><a href="<?php echo $gt_home; ?>#comdesign">考え方</a></li>
          <li><a href="<?php echo $gt_home; ?>#philosophy">或るべき姿</a></li>
          <li><a href="<?php echo $gt_home; ?>#service">できること</a></li>
          <li><a href="<?php echo $gt_home; ?>#business">事業</a></li>
          <li><a href="<?php echo $gt_home; ?>#knowledge">読みもの</a></li>
          <li><a href="<?php echo $gt_home; ?>#about">事務所について</a></li>
          <li><a href="<?php echo $gt_home; ?>#contact">お問い合わせ</a></li>
        </ul>
      </nav>
      <nav aria-label="サイト内ページ">
        <p class="gt-footer__navlabel">サイト内のページ</p>
        <ul>
          <li><a href="<?php echo esc_url( home_url( '/service' ) ); ?>">事業内容の詳細</a></li>
          <li><a href="<?php echo esc_url( get_category_link( 110 ) ); ?>">読みもの一覧</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">お問い合わせフォーム</a></li>
          <li><a href="<?php echo esc_url( home_url( '/sitemap' ) ); ?>">サイトマップ</a></li>
          <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">プライバシーポリシー</a></li>
        </ul>
      </nav>
      <p class="gt-footer__area">福岡市・宗像市・北九州市を中心に、<br />福岡県全域<br />© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Goûter</p>
    </div>
  </footer>
