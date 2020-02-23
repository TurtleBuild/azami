<?php
/*-------------------------------------------------
モバイル用メニュー
-------------------------------------------------*/
  if( wp_is_mobile() && has_nav_menu('mobile-nav') ) {
    echo '<nav class="mobile-nav w-100 text-center">';
    wp_nav_menu( array(
      'container' => false,
      'theme_location' => 'mobile-nav',
      'depth' => 1,
      'fallback_cb' => ''
    ) );
    echo '</nav>';
  }
?>