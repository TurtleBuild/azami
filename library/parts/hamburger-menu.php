<?php
/*-------------------------------------------------
ハンバーガーメニュー（モバイルのみ）
-------------------------------------------------*/
  if( wp_is_mobile() && is_active_sidebar( 'hamburger_menu' ) ):
?>
  <input type="checkbox" name="menu" id="menu" class="checkbox--hidden" >
  <label for="menu" class="hamburger-icon"><i class="fas fa-bars"></i></label>
  <nav class="hamburger-menu">
    <?php dynamic_sidebar('hamburger_menu'); ?>
  </nav>
<?php endif; ?>