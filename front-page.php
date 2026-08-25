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
	$title = 'コミュニケーションデザイン事務所 Goûter（グーテ）｜福岡・宗像市';
	$desc  = '福岡県宗像市のコミュニケーションデザイン事務所 Goûter（グーテ）。事業の「或るべき姿」を一緒に考えて、ホームページ、SNS、広報、広告、商品、仕組みづくりまでカタチにします。開業支援や経営のご相談から、制作・運営代行まで。';
	$url   = home_url( '/' );
	$img   = get_stylesheet_directory_uri() . '/assets/img/hero.jpg';

	// JIN:R は canonical も OGP も出していないため、この固定ページ分を自前で出す
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="website" />' . "\n" );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="ja_JP" />' . "\n" );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $img ) );
	printf( '<meta property="og:image:width" content="1600" />' . "\n" );
	printf( '<meta property="og:image:height" content="900" />' . "\n" );
	printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $desc ) );
	printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $img ) );

	// 構造化データ。JIN:R が出す WebSite は headline も logo も空なので、
	// 地域事業者として正しく拾われるよう ProfessionalService を別途出す
	$ld = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'ProfessionalService',
		'name'         => 'コミュニケーションデザイン事務所 Goûter（グーテ）',
		'alternateName'=> 'Goûter',
		'url'          => $url,
		'image'        => $img,
		'description'  => $desc,
		'address'      => array(
			'@type'           => 'PostalAddress',
			'addressCountry'  => 'JP',
			'postalCode'      => '811-4173',
			'addressRegion'   => '福岡県',
			'addressLocality' => '宗像市',
			'streetAddress'   => '栄町2-1-2F',
		),
		'areaServed'   => array(
			array( '@type' => 'City', 'name' => '福岡市' ),
			array( '@type' => 'City', 'name' => '宗像市' ),
			array( '@type' => 'City', 'name' => '北九州市' ),
			array( '@type' => 'AdministrativeArea', 'name' => '福岡県' ),
		),
		'knowsAbout'   => array(
			'コミュニケーションデザイン', 'ホームページ制作', 'SNS運用', '広報', '広告',
			'商品開発', '事業コンサルティング', '開業支援', 'ECサイト構築', 'WordPress',
		),
		'sameAs'       => array(),
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

    <section class="gt-hero">
      <div>
        <p class="gt-eyebrow">福岡・宗像 ｜ コミュニケーションデザイン事務所</p>
        <?php // 1行14文字だと左カラムに収まらず「何でも」だけが孤立した行になる。改行は明示する ?>
        <h1 class="gt-h1">「困ってあることは<br />何ですか？<br /><span class="gt-mark">何でもお手伝い<br />できますよ。」</span></h1>
        <p class="gt-hero__sub">毎回、相談に来られた方にそうお伝えしています。</p>
        <p class="gt-hero__note">ITコンサル、Webディレクター、プランナー。肩書を3つ並べても説明しきれませんが、やっていることはひとつです。</p>
        <div class="gt-cta">
          <a class="gt-btn" href="#contact">まず相談してみる</a>
          <a class="gt-btn--ghost" href="#flow">相談の流れ</a>
        </div>
        <p class="gt-area">福岡市・宗像市・北九州市を中心に、福岡県全域</p>
      </div>
      <div class="gt-hero__fig">
        <div class="gt-hero__card">
          <?php gouter_image( 'hero.png', '窓辺の机でノートに書き込んでいる手元', 'gt-ratio-45', array( 'eager' => true ) ); ?>
          <p class="gt-hero__cap">THINK FIRST</p>
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
        <?php // 親テーマが a の margin/padding を !important で潰すため、余白は div 側で取る ?>
        <div class="gt-linkwrap"><a class="gt-link" href="#contact">相談してみる →</a></div>
      </div>
    </section>

    <aside class="gt-ctaband" aria-label="相談への案内">
      <div class="gt-ctaband__inner">
        <p>「こんなことを相談していいのかな？」<span>くらいからで大丈夫です。</span></p>
        <a class="gt-btn gt-btn--light" href="#contact">まず相談してみる</a>
      </div>
    </aside>

    <section id="service" aria-labelledby="service-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">02</span>
          <div class="gt-head__body">
            <p class="gt-en">SERVICE</p>
            <h2 id="service-h" class="gt-h2">できること</h2>
          </div>
          <p class="gt-lead">コミュニケーションデザイン事業と、WEBソリューション事業。この2つを軸にしています。</p>
        </div>
        <div class="gt-cards2">
          <div class="gt-svc">
            <div class="gt-thumb"><?php gouter_image( 'consult.png', '壁に貼った付箋と手書きの図で課題を整理している様子', 'gt-ratio-169' ); ?></div>
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
          <a class="gt-link" href="<?php echo esc_url( home_url( '/service' ) ); ?>">事業内容をくわしく見る →</a>
        </div>
      </div>
    </section>

    <section id="flow" class="gt-pale" aria-labelledby="flow-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">03</span>
          <div class="gt-head__body">
            <p class="gt-en">FLOW</p>
            <h2 id="flow-h" class="gt-h2">相談してから、<br />どうなるのか。</h2>
          </div>
          <p class="gt-lead">いきなり見積もりを出したり、契約を迫ったりはしません。まず話を聞くところから始めます。</p>
        </div>

        <ol class="gt-flow">
          <li>
            <p class="gt-flow__n">STEP 01</p>
            <h3>まず、話を聞きます</h3>
            <p>フォームからご連絡ください。何が問題なのかはっきりしていなくて構いません。「何から手をつければいいか」から一緒に整理します。オンラインでも伺っても、どちらでも。</p>
          </li>
          <li>
            <p class="gt-flow__n">STEP 02</p>
            <h3>「或るべき姿」を一緒に決めます</h3>
            <p>いきなり手段の話はしません。その事業がどうなればいいのかを先に決めます。ここが決まると、ホームページが要るのか、SNSなのか、別のことなのかが見えてきます。</p>
          </li>
          <li>
            <p class="gt-flow__n">STEP 03</p>
            <h3>必要なところから、カタチにします</h3>
            <p>必要なものを、必要なだけ。全部まとめて頼む必要はありません。一部だけ、一度だけでも構いません。</p>
          </li>
        </ol>

        <figure class="gt-band gt-band--bleed">
          <?php gouter_image( 'talk.png', 'テーブルを挟んで資料を広げ、一緒に考えている様子', 'gt-ratio-1610' ); ?>
        </figure>

        <p class="gt-pull">「困ってあることは何ですか？」<br />そこから始めます。</p>
      </div>
    </section>

    <aside class="gt-ctaband" aria-label="相談への案内">
      <div class="gt-ctaband__inner">
        <p>必要なものを、必要なだけ。<span>一部だけ、一度だけでも構いません。</span></p>
        <a class="gt-btn gt-btn--light" href="#contact">まず相談してみる</a>
      </div>
    </aside>

    <section id="comdesign" aria-labelledby="comdesign-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head">
          <span class="gt-num">04</span>
          <div class="gt-head__body">
            <p class="gt-en">COMMUNICATION DESIGN</p>
            <h2 id="comdesign-h" class="gt-h2--lg">コミュニケーションデザイン<br />という考え方をしています。</h2>
          </div>
          <p class="gt-lead">人と人の間にあるあらゆる「モノ」「コト」を、隅々までデザインする。</p>
        </div>

        <div class="gt-prose" style="margin-top:var(--blk)">
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

        <p class="gt-pull">でも今は、ラブレターを渡すのも簡単ではありません。<br />会えないし、受け取ってもらえないかもしれない。</p>

        <ul class="gt-why">
          <li>
            <span class="gt-why__n">01</span>
            <h3>他に楽しいことが、たくさんある</h3>
            <p>誘惑が多い。そもそも、見てもらえない。</p>
          </li>
          <li>
            <span class="gt-why__n">02</span>
            <h3>表現を信じてくれない</h3>
            <p>うまいことを言われるのに、慣れている。</p>
          </li>
          <li>
            <span class="gt-why__n">03</span>
            <h3>じっくり比較検討ができる</h3>
            <p>みんな、検索が上手になった。</p>
          </li>
          <li>
            <span class="gt-why__n">04</span>
            <h3>友達に判断を任せたりする</h3>
            <p>レビューを読んでから決める。</p>
          </li>
        </ul>

        <p class="gt-pull">では、どうすればいいでしょう？<br />絶対に成功するために、戦略が必要です。</p>

        <h3 class="gt-subhead">コミュニケーションデザイン的な考え方</h3>
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
          <span class="gt-num">05</span>
          <p class="gt-en" style="margin-bottom:0">PHILOSOPHY</p>
          <p style="font-weight:700;font-size:14px;letter-spacing:.04em">Goûterの考え方</p>
        </div>
        <div class="gt-phil">
          <h2 id="phil-h">或るべき姿を考えて、<br />それをカタチにする。</h2>
          <p>本人が気づかないほど自然に、いい結果につながる。そんな状態を、わたしたちは「或るべき姿」と呼んでいます。</p>
        </div>
        <div class="gt-stmt">
          <p class="gt-stmt__lead">その姿を見出した時、カタチにするまで、<br />必要なことはすべて行います。一切の妥協もありません。</p>
          <div class="gt-stmt__cols">
            <p>片足ではなく、両足を突っ込んで一緒に取り組みます。必要なら毎日の朝礼にも、経営会議にも出ます。</p>
            <p>わたしたちが見出す「或るべき姿」は、自身では思いもしない魅力や切り口の発見に繋がります。</p>
          </div>
        </div>
      </div>
    </section>



    <?php
    /**
     * Goûter がやっている事業。
     *
     * ポケット文庫・ツキヌケ・Digne・Dignement は UTAGE で動いている別サイトなので、
     * ここでは中身を持たず、外に送り出すだけにする。
     * リンク切れを防ぐため、URL を変えるときはこの配列だけ直せばよい。
     *
     * 'desc' は空にできる。文言が決まっていない事業は、名前とリンクだけで出る。
     */
    $gt_biz = array(
        array(
            'no'    => '01',
            'en'    => 'COMMUNICATION DESIGN',
            'name'  => 'コミュニケーションデザイン',
            'desc'  => '事業の「或るべき姿」を一緒に考えて、ホームページ、SNS、広報、広告、商品、仕組みづくりまでカタチにします。Goûter の本業です。',
            'links' => array(
                array( 'label' => '事業内容をくわしく見る', 'url' => home_url( '/service' ), 'ext' => false ),
            ),
        ),
        array(
            'no'    => '02',
            'en'    => 'POCKET BUNKO',
            'name'  => 'ポケット文庫',
            // 説明文は本人の言葉待ち。空のままでも名前とリンクだけで成立する
            'desc'  => '',
            'links' => array(
                array( 'label' => 'ポケット文庫', 'url' => 'https://www.pocket-bunko.com', 'ext' => true ),
            ),
        ),
        array(
            'no'    => '03',
            'en'    => 'TSUKINUKE',
            'name'  => 'ツキヌケ編集部',
            'desc'  => 'ツキヌケの本部です。フランチャイズ、福岡・北九州・熊本の編集部、ランチ会イベントの華サロン、美食倶楽部 G/g まで、この中にあります。',
            'links' => array(
                array( 'label' => 'ツキヌケ編集部', 'url' => 'https://www.tsukinuke.com', 'ext' => true ),
            ),
        ),
        array(
            'no'    => '04',
            'en'    => 'DIGNE / DIGNEMENT / CCL',
            'name'  => 'ディーニュ ／ ディニマン ／ CCL',
            'desc'  => 'ビジネスの話を届ける音声配信「Digne」。ワークショップとセミナーの「Dignement」。その上位プランになるグループコンサル「CCL」。',
            'links' => array(
                array( 'label' => 'Digne（音声配信）', 'url' => 'https://www.biz-digne.com', 'ext' => true ),
                array( 'label' => 'Dignement', 'url' => 'https://www.dignement.com', 'ext' => true ),
                array( 'label' => 'CCL', 'url' => 'https://www.dignement.com/ccl', 'ext' => true ),
            ),
        ),
    );
    ?>
    <section id="business" class="gt-pale" aria-labelledby="business-h">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">06</span>
          <div class="gt-head__body">
            <p class="gt-en">BUSINESS</p>
            <h2 id="business-h" class="gt-h2">この考え方で、<br />こういうことをしています。</h2>
          </div>
          <p class="gt-lead">コミュニケーションデザインを軸に、事業を増やしてきました。全部、Goûter がやっています。</p>
        </div>

        <ul class="gt-biz">
          <?php foreach ( $gt_biz as $gt_b ) : ?>
            <li>
              <p class="gt-biz__no"><?php echo esc_html( $gt_b['no'] ); ?></p>
              <div class="gt-biz__body">
                <p class="gt-biz__en"><?php echo esc_html( $gt_b['en'] ); ?></p>
                <h3><?php echo esc_html( $gt_b['name'] ); ?></h3>
                <?php if ( $gt_b['desc'] ) : ?>
                  <p class="gt-biz__desc"><?php echo esc_html( $gt_b['desc'] ); ?></p>
                <?php endif; ?>
                <p class="gt-biz__links">
                  <?php foreach ( $gt_b['links'] as $gt_l ) : ?>
                    <a class="gt-link" href="<?php echo esc_url( $gt_l['url'] ); ?>"<?php echo $gt_l['ext'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php
                      echo esc_html( $gt_l['label'] );
                      // 別サイトへ出ることを、記号と読み上げの両方で伝える
                      echo $gt_l['ext'] ? ' ↗<span class="gt-sr">（別サイトが開きます）</span>' : ' →';
                    ?></a>
                  <?php endforeach; ?>
                </p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <section id="knowledge" aria-labelledby="knowledge-h" style="border-top:1px solid #E3E7EB">
      <div class="gt__wrap">
        <div class="gt-head gt-head--rule">
          <span class="gt-num">07</span>
          <div class="gt-head__body">
            <p class="gt-en">KNOWLEDGE</p>
            <h2 id="knowledge-h" class="gt-h2">現場で使えるノウハウを、<br />公開しています。</h2>
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
            <span class="gt-num">08</span>
            <div>
              <p class="gt-en">ABOUT</p>
              <h2 id="about-h" class="gt-h2">Goûterは、<br />「おやつ」という意味です。</h2>
            </div>
          </div>
          <div class="gt-prose" style="margin-top:var(--blk)">
            <p>Goûterは、フランス語の「味覚」という意味の名詞 le goût から来た言葉で、「おやつ」とか「茶話会」という意味です。</p>
            <p class="gt-mincho" style="font-size:17px">感動や喜びを「味わう」「楽しむ」。<br />そんな意味もあります。</p>
            <p>鞄に忍ばせておくと何かと役に立つ、おやつのような存在。</p>
            <p>たくさんの経験や感動を「味わう」「楽しむ」をお届けする。そういう仕事をしています。</p>
          </div>
          <dl class="gt-dl">
            <div><dt>屋号</dt><dd>Goûter（グーテ）</dd></div>
            <div><dt>事務所</dt><dd>〒811-4173　福岡県宗像市栄町2-1-2F</dd></div>
            <div><dt>対応地域</dt><dd>福岡市・宗像市・北九州市を中心に、福岡県全域</dd></div>
          </dl>
        </div>
        <div style="padding-top:0">
          <?php gouter_image( 'tea.png', '木のテーブルに置かれた紅茶と焼き菓子、ノートと万年筆', 'gt-ratio-34' ); ?>
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
            <p class="gt-contact__pull">「困ってあることは何ですか？<br />何でもお手伝いできますよ。」</p>
            <p class="gt-area" style="color:rgba(255,255,255,.6);border-top-color:rgba(255,255,255,.28)">福岡市・宗像市・北九州市を中心に、福岡県全域<br />オンラインでのご相談も承ります。</p>
          </div>
          <div class="gt-form">
            <?php gouter_contact_form(); ?>
          </div>
        </div>
      </div>
    </section>

  </main>

  <div class="gt-sticky" aria-hidden="false">
    <a class="gt-btn" href="#contact">まず相談してみる</a>
  </div>

  <?php require get_stylesheet_directory() . '/parts/footer.php'; ?>

</div>

<script>
(function () {
  if (!('IntersectionObserver' in window)) return;
  var sel = '.gt__wrap > *, .gt-hero > div, .gt-cell, .gt-svc, .gt-flow > li, .gt-why > li, .gt-tri > li, .gt-post, .gt-ctaband__inner';
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
