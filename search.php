<?php get_header(); ?>
<h2 class="search-heading col-12 mt-5">「<?php echo esc_attr( get_search_query() ); ?>」の検索結果一覧</h2>
<?php get_template_part('library/parts/post-card'); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
