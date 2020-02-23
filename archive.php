<?php get_header(); ?>
<div class="archive-header col-12 mt-5">
  <h2><?php echo '「'; the_archive_title(); echo '」の記事一覧'; ?></h2>
  <?php insert_breadcrumb(); ?>
</div>
<?php get_template_part('library/parts/post-card'); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>