<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1 ,viewport-fit=cover"/>
  <meta name="msapplication-TileColor" content="<?php echo get_theme_mod('primary_bg', '#77c0c9');?>">
  <meta name="theme-color" content="<?php echo get_theme_mod('primary_bg', '#77c0c9');?>">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
  <script>window.addEventListener("load", function() { hljs.initHighlighting() });</script>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
    <?php
      get_template_part('library/parts/hamburger-menu');
      if(get_option( 'header_center_checkbox') ) {
        get_template_part('library/parts/site-header-center');
      } else {
        get_template_part('library/parts/site-header');
      }
      get_template_part('library/parts/mobile-nav'); ?>
  </header>
  <div class="container">
    <div class="row">