<?php
/*-------------------------------------------------
カスタマイザーの「色」パネルで定義するスタイル
-------------------------------------------------*/
function azami_customizer_css()
{
  $site_bg = get_theme_mod('site_bg', '#F8F9FA');
  $anchor_color = get_theme_mod('anchor_color', '#f37159');
  $primary_bg = get_theme_mod('primary_bg', '#77c0c9');
  $site_title_color = get_theme_mod('site_title_color', '#77c0c9');
  $header_color = get_theme_mod('header_color', '#fff');
  $header_bg = get_theme_mod('header_bg', '#3f3936');
  $nav_color = get_theme_mod('nav_color', '#fff');
  $nav_bg = get_theme_mod('nav_bg', '#3f3936');
  $footer_color = get_theme_mod('footer_color', '#fff');
  $footer_anchor_color = get_theme_mod('footer_anchor_color', '#fff');
  $footer_bg = get_theme_mod('footer_bg', '#3f4d50');
  ?>
<style type="text/css">

/*
基本スタイル
-------------------------------------------------*/
body {
  background-color: <?php echo $site_bg; ?>;
}
a, a:hover {
  color: <?php echo $anchor_color; ?>;
}

/*
サイトヘッダー
-------------------------------------------------*/

/* ヘッダー */
.site-header,
.hamburger-menu {
  background-color: <?php echo $header_bg; ?>;
}
.site-header,
.hamburger-icon,
.hamburger-menu h4,
.hamburger-menu a {
  color: <?php echo $header_color; ?>;
}
.site-title a,
.site-title a:hover {
  color: <?php echo $site_title_color; ?>;
}

/* メニュー（サイトタイトル左寄せの場合はヘッダーの指定色を反映） */
.pc-nav a,
.pc-nav a:hover {
  color: <?php echo $header_color; ?>;
}
.pc-nav.pc-nav--center a,
.pc-nav.pc-nav--center a:hover,
.mobile-nav a,
.mobile-nav a:hover {
  color: <?php echo $nav_color; ?>;
}
.pc-nav {
  background-color: <?php echo $header_bg; ?>;
}
.pc-nav.pc-nav--center,
.mobile-nav {
  background-color: <?php echo $nav_bg; ?>;
}
.pc-nav li::after {
  background-color: <?php echo $primary_bg; ?>;
}

/*
サイドバー
-------------------------------------------------*/
.sidebar ul li:not(.recentcomments) a:hover {
  background-color: <?php echo $site_bg; ?>;
}

/*
サイトフッター
-------------------------------------------------*/
.site-footer,
.footer-widget,
.site-footer select {
  color: <?php echo $footer_color; ?>;
  background-color: <?php echo $footer_bg; ?>;
}
.footer-widget a,
.footer-widget a:hover {
  color: <?php echo $footer_anchor_color; ?>;
}
.site-footer caption,
.footer-widget h4.widget-title,
.footer-widget .popular-posts__text,
.footer-widget .recent-posts__text {
  color: <?php echo $footer_color; ?>;
}
.footer-widget h4.widget-title::after {
  background-color: <?php echo $primary_bg; ?>;
}

/*
記事中スタイル
-------------------------------------------------*/
.page-numbers a {
  color: #fff;
  background-color: <?php echo $primary_bg; ?>;
}
blockquote:before {
  color: <?php echo $primary_bg; ?>;
}

/*
メインカラー
-------------------------------------------------*/
.azami-main-color,
.azami-main-color:hover,
.azami-main-color--outline:hover {
  color: #fff;
  background-color: <?php echo $primary_bg; ?>;
}
.azami-main-color--outline {
  color: <?php echo $primary_bg; ?>;
  border-color: <?php echo $primary_bg; ?>;
}

/*
ショートコード
-------------------------------------------------*/

/* 見出し */
.article-content .h-bdr-b--changed.border--main-color::after {
  background-color: <?php echo $primary_bg; ?>;
}
.article-content .h-bdr-l--changed.border--main-color {
  border-color: <?php echo $primary_bg; ?>;
}
.article-content .box--main-color {
  border-color: <?php echo $primary_bg; ?>;
}

</style>
<?php
}
add_action('wp_head', 'azami_customizer_css', 101);