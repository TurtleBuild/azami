<?php
/*-------------------------------------------------
AZAMI 初期設定
- head内不要な読み込み、表記を削除
- スタイルの設定
- 各種テーマ機能のサポート
- ウィジェットの登録
- embedコンテンツの最大幅の指定
-------------------------------------------------*/
function azami_init_setup() {
  // head内不要な読み込み、表記を削除
  add_action('init', 'azami_head_cleanup');

  // スタイルの設定
  add_filter('wp_head', 'azami_remove_wp_widget_recent_comments_style', 1);
  add_action('wp_head', 'azami_remove_recent_comments_style', 1);
  add_filter('use_default_gallery_style', '__return_false');
  add_filter('wp_tag_cloud', 'tagcloud_style_removal');
  add_filter('get_image_tag_class', 'azami_bootstrap_img_class');

  // 各種テーマ機能のサポート
  azami_theme_support();

  // ウィジェットの登録
  add_action('widgets_init', 'azami_register_sidebars');
}
add_action('after_setup_theme', 'azami_init_setup');


/*-------------------------------------------------
head内不要な読み込み、表記を削除
-------------------------------------------------*/
function azami_head_cleanup()
{
  // WordPress初期設定の絵文字を読み込む設定を停止
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  
  // カテゴリ等のフィードを削除
  remove_action('wp_head', 'feed_links_extra', 3);

  // Windows Live Writer用のリンクを削除
  remove_action('wp_head', 'wlwmanifest_link');

  // 前後の記事等へのrel linkを削除
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

  // WPのバージョン表示も削除
  remove_action('wp_head', 'wp_generator');

  // CSSやJSファイルに付与されるバージョン表記を削除
  add_filter('style_loader_src', 'azami_remove_wp_ver_css_js', 9999);
  add_filter('script_loader_src', 'azami_remove_wp_ver_css_js', 9999);
}
function azami_remove_wp_ver_css_js($src)
{
  if ( strpos($src, 'ver=') ) {
      $src = remove_query_arg('ver', $src);
  }
  return $src;
}


/*-------------------------------------------------
スタイルの設定
-------------------------------------------------*/

/*
不要なスタイルを削除
-------------------------------------------------*/

// 最近のコメントに適用されるスタイル
function azami_remove_wp_widget_recent_comments_style()
{
  if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
    remove_filter('wp_head', 'wp_widget_recent_comments_style');
  }
}
function azami_remove_recent_comments_style()
{
  global $wp_widget_factory;
  if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
      remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
  }
}
// タグクラウドに適用されるスタイル
function tagcloud_style_removal( $html ) {
  $html = preg_replace( '/\s*?style="[^"]+?"/i', '', $html);
  return $html;
}

/*
要素にデフォルトのclass属性を追加
-------------------------------------------------*/

// imgタグにBootstrapのimg-thumbnailを自動で追加する
function azami_bootstrap_img_class($class) {
	return $class . ' img-thumbnail';
}

/*-------------------------------------------------
各種テーマ機能のサポート
-------------------------------------------------*/
function azami_theme_support()
{
  // サムネイル画像を使用可能に
  add_theme_support('post-thumbnails');

  // 16:9　縦カード形式で使用
  add_image_size('thumb-640', 640, 360, true);

  // 3:2 横カード形式で使用
  add_image_size('thumb-300', 300, 200, true);

  function azami_custom_image_sizes($sizes)
  {
      return array_merge($sizes, array(
          'thumb-640' => '640 x 360px',
          'thumb-300' => '300 x 200px',
      ));
  }
  add_filter('image_size_names_choose', 'azami_custom_image_sizes');

  // titleタグをhead内に出力
  add_theme_support('title-tag');

  // タイトルのセパレータを変更
  function azami_document_title_separator($sep)
  {
    $sep = '|';
    return $sep;
  }
  // アーカイブとカテゴリーページのタイトルを変更
  function azami_document_title_parts($title_part)
  {
    if ( is_archive() || is_category() ) {
      $title_part['title'] = '「' . $title_part['title'] . '」の記事一覧';
    }
    return $title_part;
  }
  add_filter('document_title_separator', 'azami_document_title_separator');
  add_filter('document_title_parts', 'azami_document_title_parts');

  // rssリンクをhead内に出力
  add_theme_support('automatic-feed-links');

  // メニューを登録
  register_nav_menus(
    array(
      'pc-nav' => 'ヘッダーメニュー（PCでのみ表示）',
      'mobile-nav' => 'スライドメニュー（モバイルのみ）'
    )
  );

  // HTML5マークアップをサポート
  add_theme_support('html5', array(
      'comment-list',
      'search-form',
      'comment-form',
  ));
}

/*-------------------------------------------------
ウィジェットの登録
-------------------------------------------------*/
function azami_register_sidebars()
{
  //メインのサイドバー
  register_sidebar(array(
    'id'            => 'sidebar1',
    'name'          => 'サイドバー',
    'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s border p-4 mb-4">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title pb-1">',
    'after_title'   => '</h4>',
  ));

  // 追尾サイドバー
  register_sidebar(array(
    'id' => 'fixed-sidebar',
    'name' => '追尾サイドバー（PCのみ）',
    'description' => '記事ページでのみ表示される固定サイドバーです',
    'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s border p-4 mb-4">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title pb-1">',
    'after_title' => '</h4>',
  ));

  // ハンバーガーメニュー
  register_sidebar(array(
    'id' => 'hamburger_menu',
    'name' => 'スマホ用ハンバーガーメニュー',
    'description' => 'スマホでのみ表示されるハンバーガーメニューです',
    'before_widget' => '<div id="%1$s" class="hamburger-widget widget %2$s pt-6 pl-7 pr-4">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ));

  // フッターウィジェット左
  register_sidebar(array(
    'id' => 'footer_left',
    'name' => 'フッターウィジェット左',
    'before_widget' => '<div class="footer-widget widget %2$s p-4">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title pb-1">',
    'after_title' => '</h4>',
  ));

  // フッターウィジェット中
  register_sidebar(array(
    'id' => 'footer_center',
    'name' => 'フッターウィジェット中',
    'before_widget' => '<div class="footer-widget widget %2$s p-4">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title pb-1">',
    'after_title' => '</h4>',
  ));

  // フッターウィジェット右
  register_sidebar(array(
    'id' => 'footer_right',
    'name' => 'フッターウィジェット右',
    'before_widget' => '<div class="footer-widget widget %2$s p-4">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title pb-1">',
    'after_title' => '</h4>',
  ));
}


/*-------------------------------------------------
embedコンテンツの最大幅の指定
-------------------------------------------------*/
function azami_content_width()
{
  $GLOBALS['content_width'] = apply_filters('azami_content_width', 800);
}
add_action('after_setup_theme', 'azami_content_width', 0);
