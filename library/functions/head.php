<?php
/*-------------------------------------------------
head内にメタタグを出力する
- meta robotsの出力
- OGPタグの出力
- ページ分割した記事でrel next/prevを表示
-------------------------------------------------*/


/*-------------------------------------------------
meta robotsの出力
-------------------------------------------------*/
function azami_meta_robots() {
  $rogots_tags = null;

  if ( is_attachment() || is_search() ) {
    $rogots_tags = 'noindex,nofollow';
  } elseif ( is_paged() || is_tag() || is_date() ) {
    $rogots_tags = 'noindex,follow';
  }
  if ($rogots_tags) echo '<meta name="robots" content="' . $rogots_tags . '" />';
}
add_action('wp_head', 'azami_meta_robots');


/*-------------------------------------------------
OGPタグの出力
-------------------------------------------------*/
function azami_meta_ogp() {
  $insert = '';
  if ( azami_set_meta_description() ) {
    $insert = '<meta name="description" content="' . esc_attr( azami_set_meta_description() ) . '" />';
  }
  $ogp_descr = azami_set_ogp_description();
  $ogp_img = azami_set_ogp_image();
  $ogp_title = azami_set_ogp_title_tag();
  $ogp_url = azami_set_ogp_url();
  $ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';

  // 出力するOGPタグをまとめる
  $insert .= '<meta property="og:title" content="' . esc_attr($ogp_title) . '" />' . "\n";
  $insert .= '<meta property="og:description" content="' . esc_attr($ogp_descr) . '" />' . "\n";
  $insert .= '<meta property="og:type" content="' . $ogp_type . '" />' . "\n";
  $insert .= '<meta property="og:url" content="' . esc_url($ogp_url) . '" />' . "\n";
  $insert .= '<meta property="og:image" content="' . esc_url($ogp_img) . '" />' . "\n";
  $insert .= '<meta name="thumbnail" content="' . esc_url($ogp_img) . '" />' . "\n";
  $insert .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />' . "\n";
  $insert .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";

  // 出力
  if ( is_front_page() || is_home() || is_singular() || is_category() || is_author() || is_tag() ) {
    echo $insert;
  }
}
add_action('wp_head', 'azami_meta_ogp');

/*
og:title
-------------------------------------------------*/
function azami_set_ogp_title_tag() {
  global $post;
  if ($post) {
    return $post->post_title;
  } else if ( is_front_page() || is_home() ) {
    $description = ( get_bloginfo('description') ) ? '｜' . get_bloginfo('description') : "";
    return get_bloginfo('name') . $description;
  } elseif ( is_category() ) {
    return single_cat_title('', false) . 'の記事一覧';
  } elseif ( is_author() ) {
    return get_the_author_meta('display_name') . 'の書いた記事一覧';
  }
}

/*
og:image
-------------------------------------------------*/
function azami_set_ogp_image() {
  if( is_singular() ) return azami_get_the_thumbnail('thumb-640');
  if( get_option('set_home_ogp_image') ) {
    return get_option('set_home_ogp_image');
  } elseif( get_option('thumb_upload') ){
    return get_option('thumb_upload');
  } else {
    return get_template_directory_uri() . '/library/images/default.jpg';
  }
}

/*
og:description
-------------------------------------------------*/
function azami_set_ogp_description() {
  global $post;
  if ( is_singular() ) {
    // 投稿ページ
    if( get_post_meta($post->ID, 'azami_meta_description', true) ){
      return get_post_meta($post->ID, 'azami_meta_description', true);
    }
    setup_postdata($post);
    return get_the_excerpt();
    wp_reset_postdata();
  } elseif ( is_front_page() || is_home() ) {
    // トップページ
    if( get_option('home_description') ) return get_option('home_description');
    if( get_bloginfo('description') ) return get_bloginfo('description');
  } elseif ( is_category() ) {
    // カテゴリーページ
    $cat_term = get_term(get_query_var('cat'), "category");
    $cat_meta = get_option($cat_term->taxonomy . '_' . $cat_term->term_id);
    if ( !empty($cat_meta['category_description']) ) {
      return esc_attr($cat_meta['category_description']);
    } else {
      return get_bloginfo('name') . 'の「' . single_cat_title('', false) . '」についての投稿一覧です。';
    }
  } elseif ( is_tag() ) {
    // タグページ
    return wp_strip_all_tags( term_description() );
  } elseif ( is_author() && get_the_author_meta('description') ) {
    // 著者ページ
    return get_the_author_meta('description');
  }
  return "";
}

/*
og:url
-------------------------------------------------*/
function azami_set_ogp_url() {
  if ( is_front_page() || is_home() ) { // トップページ
    return home_url();
  } elseif ( is_category() ) { // カテゴリーページ
    return get_category_link( get_query_var('cat') );
  } elseif ( is_author() ) { // 著者ページ
    return get_author_posts_url( get_the_author_meta('ID') );
  } else { // 投稿ページ等
    return get_permalink();
  }
}

/*
meta description
-------------------------------------------------*/
function azami_set_meta_description() {
  global $post;
  if( is_singular() && get_post_meta($post->ID, 'azami_meta_description', true) ) {
    // 投稿ページ
    return get_post_meta($post->ID, 'azami_meta_description', true);
  } elseif( is_front_page() || is_home() ) {
    // トップページ
    if( get_option('home_description') ) return get_option('home_description');
    if( get_bloginfo('description') ) return get_bloginfo('description');
  } elseif( is_category() ) {
    // カテゴリページ
    $cat_term = get_term(get_query_var('cat'), "category");
    $cat_meta = get_option($cat_term->taxonomy . '_' . $cat_term->term_id); 
    return $cat_meta['category_description'];
  } elseif ( is_tag() ) {
    return wp_strip_all_tags( term_description() );
  }
  return false;
}


/*-------------------------------------------------
分割した記事でrel next/prevを表示
-------------------------------------------------*/
function rel_next_prev() {
  if ( is_singular() ) {
    global $post;
    global $page;
    $pages = substr_count($post->post_content, '<!--nextpage-->') + 1;
    // 記事が分割されている場合
    if ($pages > 0) {
      if ($page == 1) {
        next_prev_permalink("next", $page);
      } else if ($page == $pages) {
        next_prev_permalink("prev", $page);
      } else {
        next_prev_permalink("prev", $page);
        next_prev_permalink("next", $page);
      }
    }
  }
}
add_action('wp_head', 'rel_next_prev');

// 分割した記事のnext/prevのリンクを出力
function next_prev_permalink($direction, $page) {
  if ($direction == "prev") {
    $num = $page - 1;
  } else if ($direction == "next") {
    $num = $page + 1;
  }
  if (get_option('permalink_structure') == '') {
    $url = add_query_arg( 'page', $num, get_permalink() );
  } else {
    $url = trailingslashit( get_permalink() ) . user_trailingslashit($num, 'single_paged');
  }
  if ($direction == "prev") {
    $output = '<link rel="prev" href="' . $url . '">';
  } else if ($direction == "next") {
    $output = '<link rel="next" href="' . $url . '">';
  }
  echo $output;
}