<?php
/*-------------------------------------------------
PC用メニュー
-------------------------------------------------*/
  if( has_nav_menu('pc-nav') ) {
    $header_style = get_option('header_center_checkbox') ? ' pc-nav--center text-center' : '';
    echo '<nav class="pc-nav w-100' . $header_style . '">';
    wp_nav_menu( array(
      'container' => false,
      'theme_location' => 'pc-nav',
      'depth' => 2,
      'fallback_cb' => ''
    ) );
    echo '</nav>';
  }
?>