<?php get_header(); ?>
<main class="main col-lg-8 mt-5">
  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class('border p-3 p-md-5 mb-md-5'); ?>>
      <header class="pb-4">
        <?php insert_breadcrumb(); ?>
        <p class="small">
          <i class="far fa-clock mr-1"></i><time class="registDate" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y/m/d'); ?></time>
          <?php if( get_the_modified_date('Ymd') > get_the_date('Ymd') ): ?>
          <i class="fas fa-sync-alt mx-1"></i><time class="updateDate" datetime="<?php echo get_the_modified_date('Y-m-d'); ?>"><?php echo get_the_modified_date('Y/m/d'); ?></time>
          <?php endif; ?>
        </p>
        <h1><?php the_title(); ?></h1>
        <?php if ( has_post_thumbnail() ) : ?>
        <p><?php the_post_thumbnail( 'large', array('class' => 'webfeedsFeaturedVisual img-thumbnail') );?></p>
        <?php endif; ?>
      </header>

      <section class="article-content">
      <?php
        the_content();
        wp_link_pages( array(
          'before' => '<div class="page-numbers pb-5">',
          'after'  => '</div>'
        ) );
      ?>
      </section>
      
      <footer>
        <aside>
          <?php if( get_the_category() ): ?>
            <p class="categories text-right"><?php echo insert_category_buttons(); ?></p>
          <?php endif; ?>
          <?php if( get_the_tags() ) : ?>
            <p class="tags text-right"><?php insert_tag_buttons();?></p>
          <?php endif; ?>
          <?php insert_social_buttons(); ?>
          <?php insert_author_info(); ?>
          <?php insert_related_posts(); ?>
          <?php get_template_part('library/parts/single-pagenation'); ?>
        </aside>
      </footer>
      <?php
        // アクセス数のカウント（人気記事ウィジェットのため）
        if( !is_bot() && !is_user_logged_in() ) {
          azami_set_post_views( get_the_ID() );
        }
      ?>
      <?php comments_template(); ?>
    </article>
  <?php endwhile; ?>
</main>
<?php get_sidebar();?>
<?php get_footer(); ?>
