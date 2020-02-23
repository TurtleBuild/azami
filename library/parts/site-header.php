<div class="container">
  <div class="row">
    <div class="col-12 col-md-4 d-table">
      <?php $title_tag = ( is_home() || is_front_page() ) ? 'h1' : 'p'; ?>
      <<?php echo $title_tag; ?> id="logo" class="site-title h2 d-table-cell align-middle text-center text-md-left">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-decoration-none">
          <?php if( get_option('logo_image_upload') ) : ?>
            <img src="<?php echo esc_url( get_option('logo_image_upload') ); ?>" alt="<?php bloginfo('name'); ?>" class="site-title-img">
          <?php endif; ?>
          <?php if( !get_option('onlylogo_checkbox') ) bloginfo('name'); ?>
        </a>
      </<?php echo $title_tag; ?>>
    </div>
    <div class="col-8 text-right">
      <?php get_template_part('library/parts/pc-nav'); ?>
    </div>
  </div>
</div>
