<?php
/*-------------------------------------------------
カスタマイザー機能の設定
- サニタイジング処理の定義
- カスタマイザーの項目および処理の定義
-------------------------------------------------*/
add_action('customize_register', 'theme_customize_register');

/*-------------------------------------------------
サニタイジング処理の定義
-------------------------------------------------*/

// チェックボックス
function theme_slug_sanitize_checkbox($input) { return ($input == true); }

// サニタイジング処理をしない
function no_sanitize($input) { return $input; }

// アップロードファイル
function theme_slug_sanitize_file($file, $setting)
{
  $mimes = array(
    'jpg|jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'png' => 'image/png',
    'svg' => 'image/svg+xml',
  );
  $file_ext = wp_check_filetype($file, $mimes);
  return ($file_ext['ext'] ? $file : $setting->default);
}


/*-------------------------------------------------
カスタマイザーの項目および処理の定義
-------------------------------------------------*/

function theme_customize_register($wp_customize)
{
  /*-------------------------------------------------
  サイト基本情報
  -------------------------------------------------*/

  // キャッチフレーズ
  $wp_customize->add_control('blogdescription', array(
    'settings' => 'blogdescription',
    'label' => 'キャッチフレーズ',
    'description' => 'ヘッダー中央寄せの場合のみサイトタイトルの下に表示されます。',
    'section' => 'title_tagline',
    'type' => 'text',
  ));

  // メタディスクリプション
  $wp_customize->add_setting('home_description', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  $wp_customize->add_control('home_description', array(
    'settings' => 'home_description',
    'label' => 'サイトの詳しい説明（100字以内推奨）',
    'description' => 'Googleの検索結果一覧に表示されます。',
    'section' => 'title_tagline',
    'type' => 'textarea',
  ));

  // ロゴ画像の登録とヘッダースタイルの変更
  $wp_customize->add_setting('logo_image_upload', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_image_upload', array(
      'settings' => 'logo_image_upload',
      'label' => 'ロゴ画像の登録とヘッダースタイルの変更',
      'section' => 'title_tagline',
    )));
  endif;

  // ヘッダースタイルの変更
  $wp_customize->add_setting('header_center_checkbox', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('header_center_checkbox', array(
    'settings' => 'header_center_checkbox',
    'label' => 'ヘッダータイトルを中央寄せにする',
    'section' => 'title_tagline',
    'type' => 'checkbox',
  ));

  // ロゴ画像だけを表示させるか
  $wp_customize->add_setting('onlylogo_checkbox', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('onlylogo_checkbox', array(
    'settings' => 'onlylogo_checkbox',
    'label' => 'ロゴ画像だけを表示（文字を非表示に）',
    'section' => 'title_tagline',
    'type' => 'checkbox',
  ));

  // Google Analytics
  $wp_customize->add_setting('google_analytics', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  $wp_customize->add_control('google_analytics', array(
    'settings' => 'google_analytics',
    'label' => 'Google Analyticsの設定',
    'description' => '<small>トラッキングIDを貼り付けてください。</small>',
    'section' => 'title_tagline',
    'type' => 'text',
  ));
  $wp_customize->add_setting('gtagjs', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('gtagjs', array(
    'settings' => 'gtagjs',
    'label' => 'アクセス解析にgtag.jsを使う',
    'section' => 'title_tagline',
    'type' => 'checkbox',
  ));

  /*-------------------------------------------------
  色
  -------------------------------------------------*/

  // サイトの背景色
  $wp_customize->add_setting('site_bg', array(
    'default' => '#F8F9FA',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'site_bg', array(
    'label' => 'サイトの背景色',
    'section' => 'colors',
    'settings' => 'site_bg',
  )));

  // リンクの文字色
  $wp_customize->add_setting('anchor_color', array(
    'default' => '#f37159',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anchor_color', array(
    'label' => 'リンクの文字色',
    'section' => 'colors',
    'settings' => 'anchor_color',
  )));

  // メインカラー
  $wp_customize->add_setting('primary_bg', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_bg', array(
    'label' => 'メインカラー',
    'description' => '白文字が目立つ色にしてください。',
    'section' => 'colors',
    'settings' => 'primary_bg',
  )));

  // サイトタイトルの文字色
  $wp_customize->add_setting('site_title_color', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'site_title_color', array(
    'label' => 'サイトタイトルの文字色',
    'section' => 'colors',
    'settings' => 'site_title_color',
  )));

  // ヘッダーの文字色
  $wp_customize->add_setting('header_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color', array(
    'label' => 'ヘッダーの文字色',
    'section' => 'colors',
    'settings' => 'header_color',
  )));

  // ヘッダーの背景色
  $wp_customize->add_setting('header_bg', array(
    'default' => '#3f3936',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg', array(
    'label' => 'ヘッダーの背景色',
    'section' => 'colors',
    'settings' => 'header_bg',
  )));

  // メニューの文字色
  $wp_customize->add_setting('nav_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nav_color', array(
    'label' => 'メニューの文字色',
    'description' => 'ヘッダー中央寄せの場合のみ反映されます。',
    'section' => 'colors',
    'settings' => 'nav_color',
  )));

  // メニューの背景色
  $wp_customize->add_setting('nav_bg', array(
    'default' => '#3f3936',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nav_bg', array(
    'label' => 'メニューの背景色',
    'description' => 'ヘッダー中央寄せの場合のみ反映されます。',
    'section' => 'colors',
    'settings' => 'nav_bg',
  )));

  // フッターの文字色
  $wp_customize->add_setting('footer_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_color', array(
    'label' => 'フッターの文字色',
    'section' => 'colors',
    'settings' => 'footer_color',
  )));

  // フッターのリンクの文字色
  $wp_customize->add_setting('footer_anchor_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_anchor_color', array(
    'label' => 'フッターのリンクの文字色',
    'section' => 'colors',
    'settings' => 'footer_anchor_color',
  )));

  // フッターの背景色
  $wp_customize->add_setting('footer_bg', array(
    'default' => '#3f4d50',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg', array(
    'label' => 'フッターの背景色',
    'section' => 'colors',
    'settings' => 'footer_bg',
  )));

  $wp_customize->add_panel('azami_original_setting',
  array(
    'priority' => 53,
    'title' => 'azamiオリジナル機能設定',
  ));

  /*-------------------------------------------------
  画像関連の設定
  -------------------------------------------------*/
  $wp_customize->add_panel('panel_image_setting',
  array(
    'priority' => 55,
    'title' => '画像関連の設定',
  )
  );

  /*
  デフォルトのサムネイル画像
  -------------------------------------------------*/
  $wp_customize->add_section('default_thumbnail', array(
    'title' => 'デフォルトのサムネイル',
    'panel' => 'panel_image_setting',
  ));
  $wp_customize->add_setting('thumb_upload', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'thumb_upload', array(
      'settings' => 'thumb_upload',
      'label' => 'サムネイルが登録されていない記事に使用されます。',
      'section' => 'default_thumbnail',
    )));
  endif;

  /*
  トップページのOGP画像
  -------------------------------------------------*/
  $wp_customize->add_section('home_ogp_image', array(
    'title' => 'トップページのOGP画像',
    'panel' => 'panel_image_setting',
  ));
  $wp_customize->add_setting('set_home_ogp_image', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'set_home_ogp_image', array(
      'settings' => 'set_home_ogp_image',
      'label' => 'SNSでトップページやアーカイブページがシェアされた際にOGP画像として使用されます。',
      'description' => '画像サイズは縦630px、横1200pxがおすすめです。',
      'section' => 'home_ogp_image',
    )));
  endif;

  /*
  メインビジュアル（1カラム）
  -------------------------------------------------*/
  $wp_customize->add_section('main_visual_1col', array(
    'title' => 'メインビジュアル（1カラム）',
    'panel' => 'panel_image_setting',
  ));
  // メインビジュアルをトップページに表示する
  $wp_customize->add_setting('main_visual_1col_checkbox', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('main_visual_1col_checkbox', array(
    'settings' => 'main_visual_1col_checkbox',
    'label' => 'メインビジュアルをトップページに表示する',
    'section' => 'main_visual_1col',
    'type' => 'checkbox',
  ));
  // メインビジュアルを表示する固定ページIDの入力
  $wp_customize->add_setting('main_visual_1col_pageID', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_1col_pageID', array(
    'settings' => 'main_visual_1col_pageID',
    'label' => '固定ページIDの入力',
    'section' => 'main_visual_1col',
    'description' => '<small>メインビジュアルを表示させたい固定ページIDを入力してください。</small>',
    'type' => 'text',
  ));

  // メインビジュアル画像をアップロードする１枚目
  $wp_customize->add_setting('main_visual_img_1', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_visual_img_1', array(
      'settings' => 'main_visual_img_1',
      'label' => '画像をアップロード（1枚目）',
      'section' => 'main_visual_1col',
    )));
  endif;
  // メインビジュアル画像に見出しを表示する１枚目
  $wp_customize->add_setting('main_visual_heading_1', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_heading_1', array(
    'settings' => 'main_visual_heading_1',
    'label' => '見出し',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示されます。</small>',
    'type' => 'text',
  ));
  // メインビジュアル画像に説明文を表示する１枚目
  $wp_customize->add_setting('main_visual_text_1', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_text_1', array(
    'settings' => 'main_visual_text_1',
    'label' => '説明文',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示される小さめのテキストです。</small>',
    'type' => 'textarea',
  ));
  // 見出しの文字色１枚目
  $wp_customize->add_setting('main_visual_heading_1_color', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_heading_1_color', array(
    'settings' => 'main_visual_heading_1_color',
    'label' => '見出しの文字色',
    'section' => 'main_visual_1col',
  )));
  // テキストの文字色１枚目
  $wp_customize->add_setting('main_visual_text_1_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_text_1_color', array(
    'settings' => 'main_visual_text_1_color',
    'label' => 'テキストの文字色',
    'section' => 'main_visual_1col',
  )));

  // メインビジュアル画像をアップロードする２枚目
  $wp_customize->add_setting('main_visual_img_2', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_visual_img_2', array(
      'settings' => 'main_visual_img_2',
      'label' => '画像をアップロード（2枚目）',
      'section' => 'main_visual_1col',
    )));
  endif;
  // メインビジュアル画像に見出しを表示する２枚目
  $wp_customize->add_setting('main_visual_heading_2', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_heading_2', array(
    'settings' => 'main_visual_heading_2',
    'label' => '見出し',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示されます。</small>',
    'type' => 'text',
  ));
  // メインビジュアル画像に説明文を表示する２枚目
  $wp_customize->add_setting('main_visual_text_2', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_text_2', array(
    'settings' => 'main_visual_text_2',
    'label' => '説明文',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示される小さめのテキストです。</small>',
    'type' => 'textarea',
  ));
  // 見出しの文字色２枚目
  $wp_customize->add_setting('main_visual_heading_2_color', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_heading_2_color', array(
    'settings' => 'main_visual_heading_2_color',
    'label' => '見出しの文字色',
    'section' => 'main_visual_1col',
  )));
  // テキストの文字色２枚目
  $wp_customize->add_setting('main_visual_text_2_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_text_2_color', array(
    'settings' => 'main_visual_text_2_color',
    'label' => 'テキストの文字色',
    'section' => 'main_visual_1col',
  )));

  // メインビジュアル画像をアップロードする３枚目
  $wp_customize->add_setting('main_visual_img_3', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_visual_img_3', array(
      'settings' => 'main_visual_img_3',
      'label' => '画像をアップロード（3枚目）',
      'section' => 'main_visual_1col',
    )));
  endif;
  // メインビジュアル画像に見出しを表示する３枚目
  $wp_customize->add_setting('main_visual_heading_3', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_heading_3', array(
    'settings' => 'main_visual_heading_3',
    'label' => '見出し',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示されます。</small>',
    'type' => 'text',
  ));
  // メインビジュアル画像に説明文を表示する３枚目
  $wp_customize->add_setting('main_visual_text_3', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_text_3', array(
    'settings' => 'main_visual_text_3',
    'label' => '説明文',
    'section' => 'main_visual_1col',
    'description' => '<small>画像上に表示される小さめのテキストです。</small>',
    'type' => 'textarea',
  ));
  // 見出しの文字色３枚目
  $wp_customize->add_setting('main_visual_heading_3_color', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_heading_3_color', array(
    'settings' => 'main_visual_heading_3_color',
    'label' => '見出しの文字色',
    'section' => 'main_visual_1col',
  )));
  // テキストの文字色３枚目
  $wp_customize->add_setting('main_visual_text_3_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_text_3_color', array(
    'settings' => 'main_visual_text_3_color',
    'label' => 'テキストの文字色',
    'section' => 'main_visual_1col',
  )));

  /*
  メインビジュアル（2カラム）
  -------------------------------------------------*/
  $wp_customize->add_section('main_visual_2col', array(
    'title' => 'メインビジュアル（2カラム）',
    'panel' => 'panel_image_setting',
  ));
  // メインビジュアルをトップページに表示する
  $wp_customize->add_setting('main_visual_2col_checkbox', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('main_visual_2col_checkbox', array(
    'settings' => 'main_visual_2col_checkbox',
    'label' => 'メインビジュアルをトップページに表示する',
    'section' => 'main_visual_2col',
    'type' => 'checkbox',
  ));
  // メインビジュアルを表示する固定ページIDの入力
  $wp_customize->add_setting('main_visual_2col_pageID', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_2col_pageID', array(
    'settings' => 'main_visual_2col_pageID',
    'label' => '固定ページIDの入力',
    'section' => 'main_visual_2col',
    'description' => '<small>メインビジュアルを表示させたい固定ページIDを入力してください。</small>',
    'type' => 'text',
  ));
  // メインビジュアル（2カラム）の画像をアップロード
  $wp_customize->add_setting('main_visual_2col_img', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_file',
  ));
  if (class_exists('WP_Customize_Image_Control')):
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_visual_2col_img', array(
      'settings' => 'main_visual_2col_img',
      'label' => '画像をアップロード',
      'section' => 'main_visual_2col',
    )));
  endif;
  // 見出しを表示する
  $wp_customize->add_setting('main_visual_2col_heading', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_2col_heading', array(
    'settings' => 'main_visual_2col_heading',
    'label' => '見出し',
    'section' => 'main_visual_2col',
    'type' => 'text',
  ));
  // 見出しの文字色
  $wp_customize->add_setting('main_visual_2col_heading_color', array(
    'default' => '#77c0c9',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_2col_heading_color', array(
    'settings' => 'main_visual_2col_heading_color',
    'label' => '見出しの文字色',
    'section' => 'main_visual_2col',
  )));
  // テキストを表示する
  $wp_customize->add_setting('main_visual_2col_text', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'no_sanitize',
  ));
  $wp_customize->add_control('main_visual_2col_text', array(
    'settings' => 'main_visual_2col_text',
    'label' => 'テキスト',
    'section' => 'main_visual_2col',
    'type' => 'textarea',
  ));
  // テキストの文字色
  $wp_customize->add_setting('main_visual_2col_text_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_2col_text_color', array(
    'settings' => 'main_visual_2col_text_color',
    'label' => 'テキストの文字色',
    'section' => 'main_visual_2col',
  )));
  // 背景色
  $wp_customize->add_setting('main_visual_2col_bg_color', array(
    'default' => '#636363',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_visual_2col_bg_color', array(
    'settings' => 'main_visual_2col_bg_color',
    'label' => '背景色',
    'section' => 'main_visual_2col',
  )));
  // グラデーションをかける
  $wp_customize->add_setting('main_visual_2col_gradation_checkbox', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'theme_slug_sanitize_checkbox',
  ));
  $wp_customize->add_control('main_visual_2col_gradation_checkbox', array(
    'settings' => 'main_visual_2col_gradation_checkbox',
    'label' => '画像と背景色の間にグラデーションをかける',
    'section' => 'main_visual_2col',
    'type' => 'checkbox',
  ));
}
