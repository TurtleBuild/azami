<div class="container site-header--center">
  <div class="row">
    <div class="col-12 text-center">
      <?php $title_tag = ( is_home() || is_front_page() ) ? 'h1' : 'p'; ?>
      <<?php echo $title_tag; ?> class="site-title h1 <?php echo get_bloginfo( 'description', 'display' ) ? 'pt-4' : 'py-4'; ?>">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-decoration-none">
          <?php if( get_option('logo_image_upload') ) : ?>
            <img src="<?php echo esc_url( get_option('logo_image_upload') ); ?>" alt="<?php bloginfo('name'); ?>" class="site-title-img">
          <?php endif; ?>
          <?php if( !get_option('onlylogo_checkbox') ) bloginfo('name'); ?>
        </a>
      </<?php echo $title_tag; ?>>
      <?php
        $description = get_bloginfo( 'description', 'display' );
        if ( $description ) :
      ?>
      <p class="site-description pt-4"><?php echo $description; ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_template_part('library/parts/pc-nav'); ?>