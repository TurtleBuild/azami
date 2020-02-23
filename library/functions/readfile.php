<?php
/*-------------------------------------------------
各種ファイルの読み込み
- CSS，JS
- FontAwesome
- ウェブフォント
- エディタースタイル（クラシックエディタ記事編集画面）
-------------------------------------------------*/

/*
CSS，JS
-------------------------------------------------*/
add_action('wp_enqueue_scripts', 'azami_basic_scripts_and_styles', 1 );
if ( !function_exists('azami_basic_scripts_and_styles') ) {
  function azami_basic_scripts_and_styles() {
    if ( !is_admin() ) {
      // Bootstrap Style
      wp_enqueue_style(
        'bootstrap-style',
        get_template_directory_uri() . '/library/bootstrap/css/bootstrap.css',
        array(),
        '',
        'all'
      );
      // highlight.js Style
      wp_enqueue_style(
        'highlight-style',
        get_template_directory_uri() . '/library/css/tomorrow-night-eighties.css',
        array(),
        '',
        'all'
      );
      // Theme Style
      wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/style.css',
        array(),
        '',
        'all'
      );
      // jQuery
      wp_deregister_script('jquery'); // WordPressのjQueryを解除(WordPress標準のjQueryではBootstrapのJSが動かないため)
      wp_enqueue_script(
        'jquery',
        get_template_directory_uri() . '/library/js/jquery-3.4.1.min.js', 
        array(),
        '',
        false
      );
      // Bootstrap Script
      wp_enqueue_script(
        'bootstrap-js',
        get_template_directory_uri() . '/library/bootstrap/js/bootstrap.bundle.min.js', 
        array(),
        '',
        false
      );
      // highlight.js Script
      wp_enqueue_script(
        'highlight-js',
        'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.16.2/build/highlight.min.js', 
        array(),
        '',
        false
      );
      // Comment
      if ( is_singular() and comments_open() ) {
        wp_enqueue_script('comment-reply');
      }
    } // endif isAdmin
  } 
}

/*
FontAwesome
-------------------------------------------------*/
add_action('wp_enqueue_scripts', 'azami_font_awesome', 1 );
if ( !function_exists('azami_font_awesome') ) {
  function azami_font_awesome() {
    wp_enqueue_style(
      'azami-fontawesome5',
      get_template_directory_uri() . '/library/fontawesome5/css/all.min.css?ver5.7.2',
      array()
    );
  }
}

/*
ウェブフォント
-------------------------------------------------*/
add_action('wp_enqueue_scripts', 'azami_google_font', 1 );
if ( !function_exists('azami_google_font') ) {
  function azami_google_font() {
    // Yaku Han JP
    wp_enqueue_style(
      'yakuhanjp',
      'https://cdn.jsdelivr.net/npm/yakuhanjp@3.2.0/dist/css/yakuhanjp.min.css',
      array(),
      '',
      'all'
    );
    // Montserrat
    wp_enqueue_style(
      'montserrat-googlefonts',
      '//fonts.googleapis.com/css?family=Montserrat:400,700',
      array(),
      '',
      'all'
    );
    // Noto Sans JP
    wp_enqueue_style(
      'notosansjp-googlefonts',
      '//fonts.googleapis.com/css?family=Noto+Sans+JP:400,700',
      array(),
      '',
      'all'
    );
  }
}

/*
エディタースタイル（クラシックエディタ記事編集画面）
-------------------------------------------------*/
add_action("admin_head-post.php", "azami_admin_style");
add_action("admin_head-post-new.php", "azami_admin_style");
if ( !function_exists('azami_admin_style') ) {
  function azami_admin_style(){
    add_editor_style(get_template_directory_uri() . '/library/css/editor-style.css');
  }
}