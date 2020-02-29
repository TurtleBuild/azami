<?php
get_header();
if( get_option('main_visual_2col_checkbox') ) { get_template_part('library/parts/main-visual-2col'); }
if( get_option('main_visual_1col_checkbox') ) { get_template_part('library/parts/main-visual'); }
get_template_part('library/parts/post-card');
get_sidebar();
get_footer();
?>