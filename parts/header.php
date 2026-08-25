<?php
/**
 * サイト共通ヘッダー。トップと下層で同じものを使う。
 * 下層ページではアンカーだけでは飛べないので、トップのURLを前置きする。
 */
$gt_home = is_front_page() ? '' : esc_url( home_url( '/' ) );
?>
  <header class="gt-header">
    <div class="gt-header__inner">
      <a class="gt-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php gouter_logo(); ?></a>
      <nav class="gt-nav" aria-label="グローバルナビゲーション">
        <ul>
          <li><a href="<?php echo $gt_home; ?>#problem">困りごと</a></li>
          <li><a href="<?php echo $gt_home; ?>#comdesign">考え方</a></li>
          <li><a href="<?php echo $gt_home; ?>#service">できること</a></li>
          <li><a href="<?php echo $gt_home; ?>#flow">相談の流れ</a></li>
          <li><a href="<?php echo $gt_home; ?>#knowledge">読みもの</a></li>
          <li><a href="<?php echo $gt_home; ?>#about">事務所について</a></li>
        </ul>
      </nav>
      <a class="gt-btn--sm" href="<?php echo $gt_home; ?>#contact">お問い合わせ</a>
    </div>
  </header>
