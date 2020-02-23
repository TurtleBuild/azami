<?php
/*-------------------------------------------------
AZAMIの機能を定義
- インポート
- 画像表示制御
- ユーザー管理画面からfacebookやTwitterを登録
- フッターに Google Analytics のコードを挿入
- ユーティリティ
-------------------------------------------------*/


/*-------------------------------------------------
インポート
-------------------------------------------------*/

// 記事で使用される関数の定義
require_once 'article-functions.php';
// ウィジェットで使用される関数の定義
require_once 'widget-functions.php';


/*-------------------------------------------------
画像表示制御
-------------------------------------------------*/

/*
サイズを指定して画像のURLを取得
-------------------------------------------------*/
if ( !function_exists('azami_get_the_thumbnail') ) {
  function azami_get_the_thumbnail($size, $id = null)
  {
    // 記事のサムネイル画像
    if ( has_post_thumbnail($id) ) return get_the_post_thumbnail_url($id, $size);

    // アップロードされたデフォルト画像
    $registered = esc_url( get_option('thumb_upload') );
    if ($registered) {
      if ($size == 'thumb-640') return replace_thumbnail_url($registered, '640', '360');
      if ($size == 'thumb-300') return replace_thumbnail_url($registered, '300', '200');
      return $registered;
    } 

    // テーマのimages配下のデフォルト画像
    $template_image_path_base = get_template_directory_uri() . '/library/images/';
    if ($size == 'thumb-640') return $template_image_path_base . '640x360.jpg';
    if ($size == 'thumb-300') return $template_image_path_base . '300x200.jpg';
    return $template_image_path_base . 'default.jpg';
  }
}

/*
サムネイルサイズに応じたファイルURLの変換処理
-------------------------------------------------*/
if ( !function_exists('replace_thumbnail_url') ) {
  function replace_thumbnail_url($url, $width, $height) {
    $types = array('.jpg', '.jpeg', '.png', '.gif', '.bmp');
    $replace_types = array();
    foreach ($types as $type) {
      $replace_types[] = '-' . $width . 'x' . $height . $type;
    }
    return str_replace($types, $replace_types, $url);
  }
}


/*-------------------------------------------------
ユーザー管理画面からfacebookやTwitterを登録
-------------------------------------------------*/
if ( !function_exists('add_user_contactmethods') ) {
  function add_user_contactmethods($user_contactmethods)
  {
    return array(
      'twitter'   => 'TwitterのURL',
      'facebook'  => 'FacebookのURL',
      'instagram' => 'InstagramのURL',
      'feedly'    => 'FeedlyのURL',
      'youtube'   => 'YouTubeのURL',
      'line'      => 'LINEのURL',
      'github'    => 'githubのURL'
    );
  }
  add_filter('user_contactmethods', 'add_user_contactmethods');
}


/*-------------------------------------------------
フッターに Google Analytics のコードを挿入
IDはカスタマイザー画面で入力する
-------------------------------------------------*/
if ( !function_exists('add_google_analytics') ) {
  function add_google_analytics()
  {
    if ( get_option('google_analytics') ):
      if ( get_option('gtagjs') ):
  ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_html( get_option('google_analytics') ); ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?php echo esc_html( get_option('google_analytics') ); ?>');
  </script>
  <?php else: // gtagjsにチェックが入っていない時 ?>
    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '<?php echo esc_html(get_option('google_analytics')); ?>', 'auto');
      ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->
    <?php endif; // end if gtagjs
    endif; // end if google_analytics
  }
  add_action('wp_head', 'add_google_analytics');
}


/*-------------------------------------------------
ユーティリティ
-------------------------------------------------*/

/*
カラーコードをRGB数値に変換
例： #FFFFFF → rgb(255,255,255)
-------------------------------------------------*/
if ( !function_exists('change_RGB') ) {
  function change_RGB($colorcode){  
    //「#」を削除
    $colorcode = preg_replace("/#/", "", $colorcode);

    // RGBに分割して配列に格納
    $array_colorcode["red"]   = hexdec( substr($colorcode, 0, 2) );
    $array_colorcode["green"] = hexdec( substr($colorcode, 2, 2) );
    $array_colorcode["blue"]  = hexdec( substr($colorcode, 4, 2) );

    return 'rgb(' . $array_colorcode["red"] . ',' . $array_colorcode["green"] . ',' . $array_colorcode["blue"] . ')';
  }
}

/*
文字数を制限しながらタイトルを出力
-------------------------------------------------*/
if ( !function_exists('substring_title') ) {
  function substring_title($id, $lim)
  {
    $raw = esc_attr( get_the_title($id) );
    if (mb_strlen($raw, 'UTF-8') > $lim) {
      $title = mb_substr($raw, 0, $lim, 'UTF-8');
      echo $title . '…';
    } else {
      echo $raw;
    }
  }
}