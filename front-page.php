<?php
/**
 * Front Page — コミュニケーションデザイン事務所 Goûter
 * 「設定 → 表示設定 → ホームページの表示」を固定ページにしている場合もこのテンプレートが使われます。
 * 本文は /service（固定ページID 38）および /service/business-design（同 7121）の
 * 実コンテンツをもとに構成しています。
 */

/**
 * SEO。JIN:R 側の title が旧い文言のままで、description は出力されていないため
 * このテンプレートに限り上書きする。wp_head() より前に登録する必要がある。
 */
add_filter( 'pre_get_document_title', function () {
	return 'コミュニケーションデザイン事務所 Goûter（グーテ）｜福岡・宗像市';
}, 99 );

add_action( 'wp_head', function () {
	$desc = '福岡県宗像市のコミュニケーションデザイン事務所 Goûter（グーテ）。事業の「或るべき姿」を一緒に考えて、ホームページ、SNS、広報、広告、商品、仕組みづくりまでカタチにします。開業支援や経営のご相談から、制作・運営代行まで。';
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $desc ) );
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

  <header class="gt-header">
    <div class="gt-header__inner">
      <a class="gt-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">Goûter</a>
      <nav class="gt-nav" aria-label="グローバルナビゲーション">
        <ul>
          <li><a href="#problem">困りごと</a></li>
          <li><a href="#comdesign">考え方</a></li>
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
        <p class="gt-eyebrow">福岡・宗像 ｜ コミュニケーションデザイン事務所</p>
        <h1 class="gt-h1">「困ってあることは、<br /><span class="gt-mark">何ですか？」</span></h1>
        <p class="gt-hero__sub">何でもお手伝いできますよ。<br />毎回、相談に来られた方にそうお伝えしています。</p>
        <p class="gt-hero__note">ITコンサル、Webディレクター、プランナー。肩書を3つ並べても説明しきれませんが、やっていることはひとつです。</p>
        <div class="gt-cta">
          <a class="gt-btn" href="#contact">まず相談してみる</a>
          <a class="gt-btn--ghost" href="#service">できること</a>
        </div>
        <p class="gt-area">福岡市・宗像市・北九州市を中心に、福岡県全域</p>
      </div>
      <div class="gt-hero__fig">
        <div class="gt-hero__card">
          <?php gouter_image( 'hero.jpg', '打ち合わせを見下ろす位置に灯る電球', 'gt-ratio-45' ); ?>
          <p class="gt-hero__cap">THINK TOGETHER</p>
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
          <p class="gt-lead">人と人の間にあるあらゆる「モノ」「コト」を、隅々までデザインする。</p>
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

        <figure class="gt-band gt-band--bleed">
          <?php gouter_image( 'comdesign.jpg', '点と点を糸で結んだ関係図', 'gt-ratio-1610' ); ?>
        </figure>

        <p class="gt-pull">でも今は、ラブレターを渡すのも簡単ではありません。<br />会えないし、受け取ってもらえないかもしれない。</p>

        <ul class="gt-cards4">
          <li class="gt-card">
            <h3>他に楽しいことが、<br />たくさんある</h3>
            <p>誘惑が多い。そもそも見てもらえない。</p>
          </li>
          <li class="gt-card">
            <h3>表現を<br />信じてくれない</h3>
            <p>うまいことを言われ慣れている。</p>
          </li>
          <li class="gt-card">
            <h3>じっくり比較検討<br />ができる</h3>
            <p>みんな、検索が上手になった。</p>
          </li>
          <li class="gt-card">
            <h3>友達に判断を<br />任せたりする</h3>
            <p>レビューを読んでから決める。</p>
          </li>
        </ul>

        <p class="gt-pull">では、どうすればいいでしょう？<br />絶対に成功するために、戦略が必要です。</p>

        <p class="gt-tri__n" style="margin-top:clamp(44px,5vw,68px)">コミュニケーションデザイン的な考え方</p>
        <ol class="gt-service">
          <li>
            <div class="gt-service__title"><span>01</span><h3>ターゲットを明確にする</h3></div>
            <p>誰に届けたいのかを、はっきりさせるところから。</p>
          </li>
          <li>
            <div class="gt-service__title"><span>02</span><h3>その人を、しっかり調べる</h3></div>
            <p>どんな風に生活し、どういう行動を日々とっているか。何を感じ、何に不満を持ち、何を好むのか。</p>
          </li>
          <li>
            <div class="gt-service__title"><span>03</span><h3>上手に「出会える」場所を探す</h3></div>
            <p>その人がいるシチュエーションを見つける。無ければ、つくる。</p>
          </li>
          <li>
            <div class="gt-service__title"><span>04</span><h3>相手にしてもらえる表現で話しかける</h3></div>
            <p>どのコンタクトポイントが、メッセージを伝える適切な場なのかを考える。</p>
          </li>
        </ol>

        <p class="gt-pull">隅々まで考え抜いて、計算し尽くして、準備する。<br />昔うまくいった方法が、今も効くとは限りません。</p>
      </div>
    </section>

    <section id="philosophy" class="gt-navy" aria-labelledby="phil-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">03</span>
          <p class="gt-en" style="margin-bottom:0">PHILOSOPHY</p>
          <p style="font-weight:700;font-size:14px;letter-spacing:.04em">Goûterの考え方</p>
        </div>
        <div class="gt-phil">
          <h2 id="phil-h">或るべき姿を考えて、<br />それをカタチにする。</h2>
          <p>本人が気づかないほど自然に、いい結果につながる。そんな状態を、わたしたちは「或るべき姿」と呼んでいます。</p>
        </div>
        <figure class="gt-band gt-band--bleed">
          <?php gouter_image( 'philosophy.jpg', '黒板に描かれた電球と、そこから伸びる線', 'gt-ratio-1610' ); ?>
        </figure>

        <div class="gt-cols3">
          <div>
            <h3>その姿を見出した時、カタチにするまで、必要なことはすべて行います。</h3>
          </div>
          <div>
            <p>一切の妥協もありません。</p>
            <p style="margin-top:14px">自身では思いもしない魅力や切り口の発見に繋がります。</p>
          </div>
          <div>
            <p>片足ではなく、両足を突っ込んで一緒に取り組みます。必要なら毎日の朝礼にも、経営会議にも出ます。</p>
          </div>
        </div>
      </div>
    </section>


    <section id="service" class="gt-pale" aria-labelledby="service-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">04</span>
          <div class="gt-head__body">
            <p class="gt-en">SERVICE</p>
            <h2 id="service-h" class="gt-h2">できること</h2>
          </div>
          <p class="gt-lead">コミュニケーションデザイン事業と、WEBソリューション事業。この2つを軸にしています。</p>
        </div>
        <div class="gt-cards2">
          <div class="gt-svc">
            <div class="gt-thumb"><?php gouter_image( 'service-1.jpg', 'コンサルティングのイメージ', 'gt-ratio-169' ); ?></div>
            <p class="gt-svc__en">01 — CONSULTING</p>
            <h3>コンサルティング</h3>
            <p>開業支援 / 事業経営（企画立案）/ IT活用（集客アップ・売上アップ）</p>
          </div>
          <div class="gt-svc">
            <div class="gt-thumb"><?php gouter_image( 'service-2.jpg', 'クライアント案件制作のイメージ', 'gt-ratio-169' ); ?></div>
            <p class="gt-svc__en">02 — CREATIVE</p>
            <h3>クライアント案件制作</h3>
            <p>ロゴ / WEB / 広告（看板、チラシ、WEB）/ システム / 販促物 / イベント企画・運営</p>
          </div>
          <div class="gt-svc">
            <div class="gt-thumb"><?php gouter_image( 'service-3.jpg', '運営サポート・記事執筆代行のイメージ', 'gt-ratio-169' ); ?></div>
            <p class="gt-svc__en">03 — OPERATION</p>
            <h3>運営サポート・運営代行</h3>
            <p>WEB / EC / SNS活用（Instagram、Twitter、LINE、Googleビジネス 他）/ 記事執筆代行（SEO対策、キーワード選定、記事構成、ディレクション 他）</p>
          </div>
          <div class="gt-svc">
            <div class="gt-thumb"><?php gouter_image( 'service-4.jpg', 'WEBソリューションのイメージ', 'gt-ratio-169' ); ?></div>
            <p class="gt-svc__en">04 — WEB SOLUTION</p>
            <h3>WEBソリューション</h3>
            <p>ポータルサイト運営 / オーダーメイドシステムの構築 / ECサイトの構築（フルスクラッチ・既存サービスのカスタマイズ）/ WordPressカスタマイズ・専用プラグイン制作</p>
          </div>
        </div>
        <div class="gt-service__foot">
          <p>「こんなこと、できますか？」からでもどうぞ。</p>
          <a class="gt-btn--sm" href="#contact">相談してみる</a>
        </div>
      </div>
    </section>

    <section id="knowledge" aria-labelledby="knowledge-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">05</span>
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
              'cat'                 => 110, // column（コラム一覧 /column）
              'posts_per_page'      => 6,
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
        <div class="gt-more">
          <a class="gt-btn--ghost" href="<?php echo esc_url( get_category_link( 110 ) ); ?>">読みものを全部見る（<?php echo esc_html( get_category( 110 )->count ); ?>記事）</a>
        </div>
      </div>
    </section>

    <section id="about" aria-labelledby="about-h">
      <div class="gt__wrap gt-about">
        <div>
          <div class="gt-head">
            <span class="gt-num">06</span>
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
          <?php gouter_image( 'about.jpg', 'ノートに描かれた電球と、青い紙のかたまり', 'gt-ratio-34' ); ?>
        </div>
      </div>
    </section>

    <section id="contact" class="gt-navy" aria-labelledby="contact-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">07</span>
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
          <li><a href="#service">できること</a></li>
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
