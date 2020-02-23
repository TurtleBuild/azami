<main class="main col-lg-8 mt-5">
  <?php
    if ( !have_posts() ) :
      get_template_part('content', 'not-found');
    endif;
  ?>
  <div class="articles row">
  <?php while ( have_posts() ) : the_post(); ?>
    <div class="col-6 mb-4 px-md-3 px-2">
      <a class="card img-thumbnail p-0" href="<?php the_permalink(); ?>">
        <p class="ratio-16to9"><img src="<?php echo azami_get_the_thumbnail('thumb-640'); ?>" alt="<?php the_title();?>" loading="lazy" class="card-img-top"></p>
        <div class="card-body p-3">
          <h2 class="card-title h3"><?php esc_html( the_title() ); ?></h2>
          <p class="card-text small text-right">
            <i class="far fa-clock mr-1"></i><time class="registDate" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y/m/d'); ?></time>
            <?php if( get_the_modified_date('Ymd') > get_the_date('Ymd') ): ?>
            <i class="fas fa-sync-alt mx-1"></i><time class="updateDate" datetime="<?php echo get_the_modified_date('Y-m-d'); ?>"><?php echo get_the_modified_date('Y/m/d'); ?></time>
            <?php endif; ?>
          </p>
        </div><!-- /.card-body -->
        <?php if ( !is_archive() ) { output_catogry_name(); } ?>
      </a><!-- /.card -->
    </div><!-- /.col-6 -->
    <?php endwhile; ?>
  </div><!-- /.articles -->
  <div class="page-numbers">
    <?php azami_pagination(); ?>
  </div>
  <?php wp_reset_query(); ?>
</main>