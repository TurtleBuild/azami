<?php if( is_active_sidebar('sidebar1') ) : ?>
  <aside class="sidebar col-lg-4 px-md-3 mt-5">
    <?php dynamic_sidebar('sidebar1'); ?>
    <?php if( is_singular() && !wp_is_mobile() && is_active_sidebar( 'fixed-sidebar' ) ) : ?>
      <div id="fixed-sidebar" class="mb-5">
        <?php dynamic_sidebar('fixed-sidebar'); ?>
      </div>
    <?php endif;?>
  </aside>
<?php endif; ?>