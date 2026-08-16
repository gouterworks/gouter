<?php
/**
 * Front Page — コミュニケーションデザイン事務所 Goûter
 * 「設定 → 表示設定 → ホームページの表示」を固定ページにしている場合もこのテンプレートが使われます。
 * 本文は /service（固定ページID 38）および /service/business-design（同 7121）の
 * 実コンテンツをもとに構成しています。
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
          <li><a href="#comdesign">考え方</a></li>
          <li><a href="#works">仕事</a></li>
          <li><a href="#service">できること</a></li>
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
        <h1 class="gt-h1">「困ってあることは<br />何ですか？」</h1>
        <p class="gt-hero__sub">何でもお手伝いできますよ。<br />毎回、相談に来られた方にそうお伝えしています。</p>
        <p class="gt-hero__note">ITコンサル、Webディレクター、プランナー。肩書は3つ並べてもうまく説明できませんが、やっていることはひとつです。或るべき姿を考えて、それをカタチにする。</p>
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
        <p class="gt-pull">「困ってあることは何ですか？」から、一緒に考えます。</p>
        <a class="gt-link" href="#contact">相談してみる →</a>
      </div>
    </section>

    <section id="comdesign" aria-labelledby="comdesign-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">02</span>
          <div class="gt-head__body">
            <p class="gt-en">COMMUNICATION DESIGN</p>
            <h2 id="comdesign-h" class="gt-h2--lg">コミュニケーションデザイン<br />という考え方をしています。</h2>
          </div>
          <p class="gt-lead">人と人の間に存在するあらゆる「モノ」「コト」をコミュニケーションと捉え、それを隅々まで全てデザインする。Goûterが大切にしている考え方です。</p>
        </div>

        <div class="gt-prose" style="margin-top:clamp(32px,4vw,56px)">
          <p class="gt-mincho">コミュニケーションデザインは、<br />よく、ラブレターに例えられます。</p>
        </div>

        <ul class="gt-tri">
          <li>
            <p class="gt-tri__n">Q 01</p>
            <h3>どんなラブレターを<br />作るのか？</h3>
          </li>
          <li>
            <p class="gt-tri__n">Q 02</p>
            <h3>どのような環境で<br />渡すのがベストなのか？</h3>
          </li>
          <li>
            <p class="gt-tri__n">Q 03</p>
            <h3>そもそもラブレターが、<br />手段として最適なのか？</h3>
          </li>
        </ul>

        <p class="gt-pull">これらを俯瞰して考え、最良の環境を設定し、設計していく。<br />それがコミュニケーションデザインです。</p>

        <div class="gt-prose" style="margin-top:clamp(28px,3vw,44px)">
          <p>人々の趣味趣向は多様化し、目にする情報、耳に入る情報の量は急激に増えました。メディアも多様化しました。そして、人々は広告にすっかり慣れて、賢くなっています。</p>
          <p>昔は成り立っていた成功例が、残念ながら現代では通用しない、効果がないという場合がたくさんあります。だからこそ、それぞれに合ったコミュニケーションのデザインが必要になります。</p>
        </div>
      </div>
    </section>

    <section id="philosophy" class="gt-navy" aria-labelledby="phil-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">03</span>
          <p class="gt-en" style="margin-bottom:0">PHILOSOPHY</p>
          <p style="font-family:var(--mincho);font-size:13px;letter-spacing:.1em">Goûterの考え方</p>
        </div>
        <div class="gt-phil">
          <h2 id="phil-h">或るべき姿を考えて、<br />それをカタチにする。</h2>
          <p>本人が気づかないほど自然に、いい結果につながる。そんな状態をつくることができたなら、それは最良の戦略です。素敵なコミュニケーションデザインです。そういうものを、わたしたちは「或るべき姿」と呼んでいます。</p>
        </div>
        <div class="gt-cols3">
          <div>
            <h3>絶対にこう或るべきだという姿を見出した時、それをカタチにするまで、必要なことはすべて行います。</h3>
          </div>
          <div>
            <p>一切の妥協もありません。</p>
            <p style="margin-top:14px">わたしたちが見出す「或るべき姿」は、自身では思いもしない魅力や切り口の発見に繋がります。</p>
          </div>
          <div>
            <p>片足を突っ込むのではなく、がっつり両足を突っ込んで、クライアントの皆さんと一緒に取り組みます。必要と思えば、契約からしばらくは毎日朝礼に出たり、経営会議や部門長会議に出たりもします。</p>
          </div>
        </div>
      </div>
    </section>

    <section id="works" aria-labelledby="works-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">04</span>
          <div class="gt-head__body">
            <p class="gt-en">WORKS</p>
            <h2 id="works-h" class="gt-h2">こんな仕事を<br />してきました。</h2>
          </div>
          <p class="gt-lead">ご相談の入口は「ホームページ」や「SNS」のことがほとんどです。でも実際に携わるようになると、事業のいろいろなところを一緒にやることになります。</p>
        </div>

        <ul class="gt-worklist">
          <li class="gt-work">
            <div class="gt-work__head">
              <p class="gt-work__en">CLINIC</p>
              <h3>新しく開院するクリニック</h3>
            </div>
            <ul class="gt-tags">
              <li>ロゴ</li><li>ホームページ</li><li>駐車場看板</li><li>院内デザイン</li>
              <li>マットレスのラッピング</li><li>自動販売機のラッピング</li><li>餅まきイベント</li>
              <li>内覧会の企画</li><li>診察券</li><li>LINE活用</li><li>開院後のイベント企画</li>
              <li>ネット広告</li><li>コラム記事の執筆</li>
            </ul>
          </li>
          <li class="gt-work">
            <div class="gt-work__head">
              <p class="gt-work__en">RESTAURANT &amp; CAFE</p>
              <h3>カフェ・レストラン</h3>
            </div>
            <ul class="gt-tags">
              <li>新メニューの開発</li><li>店舗とECサイトの運用</li><li>在庫管理</li>
              <li>購入者への同梱物の開発</li><li>サンプル商品の開発</li>
              <li>ホールでのサーヴィス</li><li>電話対応</li>
            </ul>
          </li>
          <li class="gt-work">
            <div class="gt-work__head">
              <p class="gt-work__en">FARM</p>
              <h3>農家</h3>
            </div>
            <ul class="gt-tags">
              <li>3年後を見据えた事業計画</li><li>販売方法の設計</li><li>単価設定</li>
              <li>安心・安全な野菜づくりに注力できる体制づくり</li>
            </ul>
          </li>
          <li class="gt-work">
            <div class="gt-work__head">
              <p class="gt-work__en">REAL ESTATE</p>
              <h3>不動産</h3>
            </div>
            <ul class="gt-tags">
              <li>SNS運用</li><li>動画の撮影</li><li>物件管理システムの構築</li>
              <li>システムと連動したホームページ</li><li>大家さん用の閲覧画面</li>
            </ul>
          </li>
          <li class="gt-work">
            <div class="gt-work__head">
              <p class="gt-work__en">CONSTRUCTION</p>
              <h3>土木系の企業</h3>
            </div>
            <ul class="gt-tags">
              <li>新卒採用の支援</li><li>今年のスローガン策定</li><li>特設サイト</li>
              <li>リクナビの活用</li><li>座談会の企画</li><li>インタビュー・司会進行</li>
              <li>インターンシップの設計</li>
            </ul>
          </li>
        </ul>

        <p class="gt-pull">店名や商品名を変えた方がいいと思ったら、変更を提案します。<br />商品規格も、値段も、同じです。</p>
      </div>
    </section>

    <section id="service" class="gt-pale" aria-labelledby="service-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">05</span>
          <div class="gt-head__body">
            <p class="gt-en">SERVICE</p>
            <h2 id="service-h" class="gt-h2">できること</h2>
          </div>
          <p class="gt-lead">コミュニケーションデザイン事業と、WEBソリューション事業。この2つを軸にしています。</p>
        </div>
        <ol class="gt-service">
          <li>
            <div class="gt-service__title"><span>01</span><h3>コンサルティング</h3></div>
            <p>開業支援 / 事業経営（企画立案）/ IT活用（集客アップ・売上アップ）</p>
          </li>
          <li>
            <div class="gt-service__title"><span>02</span><h3>クライアント案件制作</h3></div>
            <p>ロゴ / WEB / 広告（看板、チラシ、WEB）/ システム / 販促物 / イベント企画・運営</p>
          </li>
          <li>
            <div class="gt-service__title"><span>03</span><h3>運営サポート・運営代行</h3></div>
            <p>WEB / EC / SNS活用（Instagram、Twitter、LINE、Googleビジネス 他）/ 記事執筆代行（SEO対策、キーワード選定、記事構成、ディレクション 他）</p>
          </li>
          <li>
            <div class="gt-service__title"><span>04</span><h3>WEBソリューション</h3></div>
            <p>ポータルサイト運営 / オーダーメイドシステムの構築 / ECサイトの構築（フルスクラッチ・既存サービスのカスタマイズ）/ WordPressカスタマイズ・専用プラグイン制作</p>
          </li>
        </ol>
        <div class="gt-service__foot">
          <p>「こんなこと、できますか？」からでもどうぞ。</p>
          <a class="gt-btn--sm" href="#contact">相談してみる</a>
        </div>
      </div>
    </section>

    <section id="food" aria-labelledby="food-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">06</span>
          <div class="gt-head__body">
            <p class="gt-en">FOR RESTAURANTS</p>
            <h2 id="food-h" class="gt-h2">特に、<br />飲食業界の方へ。</h2>
          </div>
          <p class="gt-lead">飲食店経営、メニュー監修、店舗プロデュース。飲食店経営でお悩みをお持ちの経営者さま、開業支援をご希望の方、企業のご担当者さま。お気軽にお問い合わせください。</p>
        </div>
        <ul class="gt-tags gt-tags--lg">
          <li>飲食店開業コンサル</li>
          <li>開業への資金調達相談</li>
          <li>経営コンサルティング（経営相談・覆面調査を含む）</li>
          <li>商品開発</li>
          <li>商品アドバイザー</li>
        </ul>
      </div>
    </section>

    <section id="knowledge" class="gt-pale" aria-labelledby="knowledge-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
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

    <section id="about" aria-labelledby="about-h">
      <div class="gt__wrap gt-about">
        <div>
          <div class="gt-head">
            <span class="gt-num">08</span>
            <div>
              <p class="gt-en">ABOUT</p>
              <h2 id="about-h" class="gt-h2">Goûterは、<br />「おやつ」という意味です。</h2>
            </div>
          </div>
          <div class="gt-prose" style="margin-top:clamp(28px,3vw,44px)">
            <p>Goûterは、フランス語の「味覚」という意味の名詞 le goût から来た言葉で、「おやつ」とか「茶話会」という意味です。</p>
            <p class="gt-mincho" style="font-size:17px">感動や喜びを「味わう」「楽しむ」。<br />そんな意味もあります。</p>
            <p>たくさんの経験や感動を「味わう」「楽しむ」をお届けできる、日常になくてはならない「おやつ」のような存在になれればと思っています。</p>
            <p>鞄に忍ばせておくと何かと役に立つ。そんな存在を目指しています。</p>
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
            <p class="gt-contact__pull">「困ってあることは何ですか？」<br />何でもお手伝いできますよ。</p>
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
          <li><a href="#comdesign">考え方</a></li>
          <li><a href="#philosophy">或るべき姿</a></li>
          <li><a href="#works">仕事</a></li>
          <li><a href="#service">できること</a></li>
          <li><a href="#food">飲食業界の方へ</a></li>
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
