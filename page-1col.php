<?php
/*-------------------------------------------------
Template Name: 1カラム表示（サイドバー無し）
Template Post Type: page
-------------------------------------------------*/
get_header();
if( $post->ID == get_option('main_visual_2col_pageID') ) { get_template_part('library/parts/main-visual-2col'); }
if( $post->ID == get_option('main_visual_1col_pageID') ) { get_template_part('library/parts/main-visual'); }
?>
<main class="main col-12 mt-5">
  <?php while ( have_posts() ) : the_post(); ?>
  <article <?php post_class('border p-3 p-md-5 mb-5'); ?>>
    <header class="pb-4">
      <h1><?php the_title(); ?></h1>
      <?php if ( has_post_thumbnail() ): ?>
        <p><?php the_post_thumbnail( 'medium', array('class' => 'webfeedsFeaturedVisual img-thumbnail') );?></p>
      <?php endif; ?>
    </header>
    <section class="article-content">
      <?php
        the_content();
        wp_link_pages();
      ?>
    </section>
    <?php comments_template(); ?>
  </article>
  <?php endwhile; ?>
</main>
<?php get_footer(); ?>
