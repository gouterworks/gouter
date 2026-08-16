<?php
/**
 * Front Page — コミュニケーションデザイン事務所 Goûter
 * 「設定 → 表示設定 → ホームページの表示」を固定ページにしている場合もこのテンプレートが使われます。
 */
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

  <header class="gt-header">
    <div class="gt-header__inner">
      <a class="gt-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">Goûter</a>
      <nav class="gt-nav" aria-label="グローバルナビゲーション">
        <ul>
          <li><a href="#problem">困りごと</a></li>
          <li><a href="#what-we-do">できること</a></li>
          <li><a href="#philosophy">考え方</a></li>
          <li><a href="#works">仕事</a></li>
          <li><a href="#knowledge">読みもの</a></li>
          <li><a href="#about">事務所について</a></li>
        </ul>
      </nav>
      <a class="gt-btn--sm" href="#contact">お問い合わせ</a>
    </div>
  </header>

  <main id="top">

    <section class="gt-hero">
      <div>
        <p class="gt-eyebrow">COMMUNICATION DESIGN OFFICE</p>
        <h1 class="gt-h1">事業の「どうしよう？」を、<br />一緒に考えて、カタチにします。</h1>
        <p class="gt-hero__sub">ホームページ、SNS、広報、広告、商品、仕組みづくり。<br />必要なものを、必要なだけ。</p>
        <p class="gt-hero__note">Goûterは、事業のそばで考え、整え、つくる仕事をしています。</p>
        <div class="gt-cta">
          <a class="gt-btn" href="#contact">まず相談してみる</a>
          <a class="gt-btn--ghost" href="#service">できること</a>
        </div>
        <p class="gt-area">福岡市・宗像市・北九州市を中心に、福岡県全域</p>
      </div>
      <div class="gt-hero__fig">
        <div class="gt-hero__card">
          <?php gouter_image( 'hero.jpg', 'ヒーロー画像：ノートと手描きの電球', 'gt-ratio-45' ); ?>
          <p class="gt-hero__cap">NOTE &amp; IDEA</p>
        </div>
      </div>
    </section>

    <section id="problem" class="gt-pale" aria-labelledby="problem-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">01</span>
          <div class="gt-head__body">
            <p class="gt-en">PROBLEM</p>
            <h2 id="problem-h" class="gt-h2">こんなことで<br />困っていませんか？</h2>
          </div>
        </div>
        <ul class="gt-grid6">
          <li class="gt-cell">
            <span class="gt-cell__num">01</span>
            <h3>何から手をつければいいのかわからない。</h3>
            <p>やりたいことはある。でも、何から始めればいいのか決められない。</p>
          </li>
          <li class="gt-cell">
            <span class="gt-cell__num">02</span>
            <h3>ホームページをつくったけれど、仕事につながらない。</h3>
            <p>見た目だけではなく、誰に何を伝えるのか、その先でどう動いてもらうのかまで考えたい。</p>
          </li>
          <li class="gt-cell">
            <span class="gt-cell__num">03</span>
            <h3>SNSを始めたけれど、何を発信したらいいのかわからない。</h3>
            <p>「とりあえず投稿する」のではなく、事業全体の中でSNSの役割から考えます。</p>
          </li>
          <li class="gt-cell">
            <span class="gt-cell__num">04</span>
            <h3>新しい事業や商品を考えている。</h3>
            <p>アイデアだけで終わらせず、商品にするところ、売るところ、伝えるところまで。</p>
          </li>
          <li class="gt-cell">
            <span class="gt-cell__num">05</span>
            <h3>社内に相談できる人がいない。</h3>
            <p>Webも、広報も、広告も、それぞれ別の会社に頼む前に、まとめて相談したい。</p>
          </li>
          <li class="gt-cell">
            <span class="gt-cell__num">06</span>
            <h3>そもそも、何を相談すればいいのかわからない。</h3>
            <p>大丈夫です。「こんなことを相談していいのかな？」くらいからでも。</p>
          </li>
        </ul>
        <a class="gt-link" href="#contact">相談してみる →</a>
        <p class="gt-pull">「何から手をつければいい？」から一緒に考えます。</p>
      </div>
    </section>

    <section id="think-first" aria-labelledby="think-h">
      <div class="gt__wrap gt-two">
        <div>
          <div class="gt-head gt-head--rule-light">
            <span class="gt-num">02</span>
            <div>
              <p class="gt-en">THINK FIRST</p>
              <h2 id="think-h" class="gt-h2--lg">「何をつくるか」より、<br />「どうなればいいか」から。</h2>
            </div>
          </div>
        </div>
        <div class="gt-prose">
          <p>ホームページが必要だから、ホームページをつくる。SNSをやりたいから、SNSを始める。広告を出したいから、広告を出す。</p>
          <p>もちろん、それもひとつの方法です。でも、その前に。</p>
          <p class="gt-mincho">本当に必要なのは何なのか。<br />どうなれば、その事業にとっていい状態なのか。</p>
          <p>そこを一緒に考えます。今あるものを整理して、足りないものを見つけて、必要ならつくる。Goûterは、そんなふうに仕事をしています。</p>
        </div>
      </div>
    </section>

    <section id="what-we-do" aria-labelledby="wwd-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">03</span>
          <div class="gt-head__body">
            <p class="gt-en">WHAT WE DO</p>
            <h2 id="wwd-h" class="gt-h2">考える。つくる。整える。</h2>
          </div>
        </div>
        <div class="gt-cards4">
          <div class="gt-card">
            <p class="gt-card__en">THINK</p>
            <h3>考える</h3>
            <p>事業や経営について考える。新しいことを始めるときも、今あるものを見直すときも、まずは話を聞いて、整理するところから。</p>
          </div>
          <div class="gt-card">
            <p class="gt-card__en">DESIGN</p>
            <h3>設計する</h3>
            <p>誰に、何を、どこで、どう伝えるのか。Web、ブランド、広告、SNS、販促物を事業全体の中でつながるように設計します。</p>
          </div>
          <div class="gt-card">
            <p class="gt-card__en">MAKE</p>
            <h3>つくる</h3>
            <p>Webサイト、EC、システム、ロゴ、広告、販促物、コンテンツなど。必要なところは自分たちで手を動かします。</p>
          </div>
          <div class="gt-card">
            <p class="gt-card__en">OPERATE</p>
            <h3>整える</h3>
            <p>Web、EC、SNS、LINE、Googleビジネス、コンテンツなど。つくって終わりではなく、使いながら改善します。</p>
          </div>
        </div>
      </div>
    </section>

    <section id="philosophy" class="gt-navy" aria-labelledby="phil-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">04</span>
          <p class="gt-en" style="margin-bottom:0">PHILOSOPHY</p>
          <p style="font-family:var(--mincho);font-size:13px;letter-spacing:.1em">Goûterの考え方</p>
        </div>
        <div class="gt-phil">
          <h2 id="phil-h">或るべき姿を考えて、<br />それをカタチにする。</h2>
          <p>「とりあえずホームページをつくる。」「とりあえずSNSを始める。」「とりあえず広告を出す。」そんなふうに、手段から始めることがあります。</p>
        </div>
        <div class="gt-cols3">
          <div>
            <h3>本当に大切なのは、<br />その事業が、どうなればいいのか。</h3>
          </div>
          <div>
            <p>誰に届けたいのか。<br />何を伝えたいのか。<br />何ができれば、仕事はもっとよくなるのか。</p>
          </div>
          <div>
            <p>Goûterは、そこから考えます。</p>
            <a class="gt-link" href="#service" style="margin-top:18px">Goûterの考え方を読む</a>
          </div>
        </div>
      </div>
    </section>

    <section id="works" aria-labelledby="works-h">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">05</span>
          <div class="gt-head__body">
            <p class="gt-en">WORKS</p>
            <h2 id="works-h" class="gt-h2">仕事の事例</h2>
          </div>
          <p class="gt-lead">「何をつくったか」だけではなく、どんな相談から始まり、どう考えて、何を変えたのか。</p>
        </div>
        <div class="gt-cards3">
          <article class="gt-case">
            <?php gouter_image( 'work-1.jpg', '事例画像 01', 'gt-ratio-1610' ); ?>
            <p class="gt-case__label">CASE 01 — 事業整理 / Web / 集客</p>
            <h3>「ホームページを変えたい」から始まった仕事</h3>
            <p>本当に見直すべきだったのは、Webサイトそのものではありませんでした。</p>
          </article>
          <article class="gt-case">
            <?php gouter_image( 'work-2.jpg', '事例画像 02', 'gt-ratio-1610' ); ?>
            <p class="gt-case__label">CASE 02 — SNS / 商品 / 販促</p>
            <h3>「SNSを伸ばしたい」を事業全体から考える</h3>
            <p>発信だけではなく、商品と導線まで見直しました。</p>
          </article>
          <article class="gt-case">
            <?php gouter_image( 'work-3.jpg', '事例画像 03', 'gt-ratio-1610' ); ?>
            <p class="gt-case__label">CASE 03 — 開業 / 事業企画 / Web</p>
            <h3>「新しい事業を始めたい」から、一緒に整理する</h3>
            <p>アイデアを、事業として動かしていくために。</p>
          </article>
        </div>
      </div>
    </section>

    <section id="service" class="gt-pale" aria-labelledby="service-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">06</span>
          <div class="gt-head__body">
            <p class="gt-en">SERVICE</p>
            <h2 id="service-h" class="gt-h2">できること</h2>
          </div>
          <p class="gt-lead">商品作り、HP、SNS、イベント企画など、売上や集客に繋がるお手伝い。</p>
        </div>
        <ol class="gt-service">
          <li>
            <div class="gt-service__title"><span>01</span><h3>相談・伴走</h3></div>
            <p>事業相談 / 経営相談 / 開業支援 / 事業企画 / 商品開発 / 集客・売上改善 など</p>
          </li>
          <li>
            <div class="gt-service__title"><span>02</span><h3>Web・EC</h3></div>
            <p>Webサイト / ECサイト / WordPress / サイト改善 / Web運用 など</p>
          </li>
          <li>
            <div class="gt-service__title"><span>03</span><h3>広報・マーケティング</h3></div>
            <p>広報 / 広告 / SNS / SEO / コンテンツ制作 / LINE / Googleビジネス など</p>
          </li>
          <li>
            <div class="gt-service__title"><span>04</span><h3>デザイン・制作</h3></div>
            <p>ロゴ / 販促物 / 広告クリエイティブ / 記事 / コンテンツ / イベント など</p>
          </li>
          <li>
            <div class="gt-service__title"><span>05</span><h3>システム・仕組みづくり</h3></div>
            <p>Webシステム / ECカスタマイズ / 業務改善 / オーダーメイド開発 など</p>
          </li>
        </ol>
        <div class="gt-service__foot">
          <p>「こんなこと、できますか？」からでもどうぞ。</p>
          <a class="gt-btn--sm" href="#contact">相談してみる</a>
        </div>
      </div>
    </section>

    <section id="knowledge" aria-labelledby="knowledge-h">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">07</span>
          <div class="gt-head__body">
            <p class="gt-en">KNOWLEDGE</p>
            <h2 id="knowledge-h" class="gt-h2">仕事の中で考えたこと、<br />試したこと。</h2>
          </div>
          <p class="gt-lead">Webのこと。SNSのこと。広報や広告のこと。事業や売上、店舗や商品、仕事の進め方のこと。</p>
        </div>
        <div class="gt-posts">
          <?php
          $gt_posts = new WP_Query( array(
              'post_type'           => 'post',
              'posts_per_page'      => 3,
              'ignore_sticky_posts' => true,
          ) );
          if ( $gt_posts->have_posts() ) :
              while ( $gt_posts->have_posts() ) : $gt_posts->the_post();
                  $cat = get_the_category();
                  ?>
                  <article class="gt-post">
                      <a href="<?php the_permalink(); ?>">
                          <?php if ( has_post_thumbnail() ) : ?>
                              <?php the_post_thumbnail( 'large', array( 'class' => 'gt-ratio-169', 'style' => 'object-fit:cover;width:100%' ) ); ?>
                          <?php else : ?>
                              <div class="gt-ph gt-ratio-169">サムネイル未設定（16:9）</div>
                          <?php endif; ?>
                      </a>
                      <div class="gt-post__meta">
                          <span class="gt-post__cat"><?php echo $cat ? esc_html( $cat[0]->name ) : ''; ?></span>
                          <span><?php echo esc_html( get_the_date() ); ?></span>
                      </div>
                      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                      <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 60, '…' ) ); ?></p>
                  </article>
                  <?php
              endwhile;
              wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </section>

    <section id="about" aria-labelledby="about-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap gt-about">
        <div>
          <div class="gt-head">
            <span class="gt-num">08</span>
            <div>
              <p class="gt-en">ABOUT</p>
              <h2 id="about-h" class="gt-h2">Goûterは、<br />飴（あめ）/ Satoko Kimura が<br />運営する個人事業です。</h2>
            </div>
          </div>
          <div class="gt-prose" style="margin-top:clamp(28px,3vw,44px)">
            <p>福岡県宗像市を拠点に、Web、広報、広告、事業支援、商品開発、システムなど、さまざまな仕事に携わっています。</p>
            <p class="gt-mincho" style="font-size:17px">必要なことを、必要なだけ。<br />考えるところから、つくるところまで。</p>
            <p>ひとつの専門領域だけでは解決できないことを、一緒に整理して、前に進めていく。</p>
            <p>鞄に忍ばせておくと何かと役に立つ、おやつのような存在を目指してます。</p>
          </div>
          <dl class="gt-dl">
            <div><dt>屋号</dt><dd>Goûter（グーテ）</dd></div>
            <div><dt>形態</dt><dd>個人事業</dd></div>
            <div><dt>事務所</dt><dd>宗像事務所（福岡県宗像市）</dd></div>
            <div><dt>対応地域</dt><dd>福岡市・宗像市・北九州市を中心に、福岡県全域</dd></div>
          </dl>
        </div>
        <div style="padding-top:clamp(0px,3vw,48px)">
          <?php gouter_image( 'about.jpg', '事務所・手元・道具などの風景写真', 'gt-ratio-34' ); ?>
        </div>
      </div>
    </section>

    <section id="contact" class="gt-navy" aria-labelledby="contact-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">09</span>
          <p class="gt-en" style="margin-bottom:0">CONTACT</p>
        </div>
        <div class="gt-contact">
          <div>
            <h2 id="contact-h">まずは、<br />話してみませんか。</h2>
            <p class="gt-contact__lead">「ホームページをつくりたい」「集客を相談したい」「新しいことを始めたい」。具体的な相談はもちろん、「何が問題なのかわからない」からでも大丈夫です。</p>
            <p class="gt-contact__pull">「こんなこと、相談していいのかな？」<br />くらいからどうぞ。</p>
            <p class="gt-area" style="color:rgba(255,255,255,.6);border-top-color:rgba(255,255,255,.28)">福岡市・宗像市・北九州市を中心に、福岡県全域<br />オンラインでのご相談も承ります。</p>
          </div>
          <div class="gt-form">
            <?php gouter_contact_form(); ?>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="gt-footer">
    <div class="gt-footer__inner">
      <div>
        <p class="gt-footer__logo">Goûter</p>
        <p class="gt-footer__meta">コミュニケーションデザイン事務所<br />宗像事務所</p>
      </div>
      <nav aria-label="フッターナビゲーション">
        <ul>
          <li><a href="#problem">困りごと</a></li>
          <li><a href="#what-we-do">できること</a></li>
          <li><a href="#philosophy">考え方</a></li>
          <li><a href="#works">仕事</a></li>
          <li><a href="#service">サービス</a></li>
          <li><a href="#knowledge">読みもの</a></li>
          <li><a href="#about">事務所について</a></li>
          <li><a href="#contact">お問い合わせ</a></li>
        </ul>
      </nav>
      <p class="gt-footer__area">福岡市・宗像市・北九州市を中心に、<br />福岡県全域<br />© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Goûter</p>
    </div>
  </footer>

</div>
<?php wp_footer(); ?>
</body>
</html>
