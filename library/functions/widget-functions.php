<?php
/*-------------------------------------------------
ウィジェットで使用される関数の定義
- 最新記事ウィジェット
- 人気記事ウィジェット
- 投稿数表示時のリンク文字列修正
-------------------------------------------------*/


/*-------------------------------------------------
最新記事ウィジェットにサムネイル画像を追加
-------------------------------------------------*/
class AZAMI_Recent_Posts_Widget extends WP_Widget_Recent_Posts {
  public function widget($args, $instance) {
    if ( !isset($args['widget_id']) ) {
      $args['widget_id'] = $this->id;
    }
    $title = ( !empty($instance['title']) ) ? $instance['title'] : 'Recent Posts';
    $title = apply_filters('widget_title', $title, $instance, $this->id_base);
    $number = ( !empty($instance['number']) ) ? absint($instance['number']) : 5;
    if (!$number) {
      $number = 5;
    }
    $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
    $getposts = new WP_Query(apply_filters('widget_posts_args', array(
      'posts_per_page'      => $number,
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true,
    )));
    if ( $getposts->have_posts() ) {
      echo $args['before_widget'];
      if ($title) {
        echo $args['before_title'] . $title . $args['after_title'];
      }
    ?>
    <ul class="recent-posts">
    <?php while ( $getposts->have_posts() ): $getposts->the_post();?>
      <li>
        <a href="<?php the_permalink();?>" class="align-items-center">
          <figure class="recent-posts__img col-4 px-1">
            <p class="ratio-3to2"><img src="<?php echo azami_get_the_thumbnail('thumb-300', $getposts->ID); ?>" alt="<?php the_title();?>" loading="lazy"></p>
          </figure>
          <p class="recent-posts__text col-8 px-1"><?php substring_title(get_the_ID(), 41); ?>
          <?php if ($show_date): ?>
            <span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
          <?php endif;?>
          </p>
        </a>
      </li>
    <?php endwhile;?>
    </ul>
    <?php echo $args['after_widget']; ?>
    <?php 
    wp_reset_postdata();
    }
  } // END public function widget
}
function azami_add_img_to_recent_posts()
{
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('AZAMI_Recent_Posts_Widget');
}
add_action('widgets_init', 'azami_add_img_to_recent_posts');


/*-------------------------------------------------
人気記事ウィジェット
-------------------------------------------------*/
class AZAMI_Popular_Posts_Widget extends WP_Widget {
  
  public function __construct() {
    parent::__construct(false, $name = '人気記事');
  }

  public function widget($args, $instance) {
    extract($args);
    $title = ( !empty($instance['title']) ) ? $instance['title'] : 'Popular Posts';
    $title = apply_filters('widget_title', $title, $instance, $this->id_base);
    $entry_num = apply_filters('widget_body', $instance['count']);
    $show_views = apply_filters('widget_checkbox', $instance['show_views']);
    $posts = get_posts( array(
      'post_type'   => 'any',
      'numberposts' => $entry_num,
      'meta_key'    => 'post_views_count',
      'orderby'     => 'meta_value_num',
      'order'       => 'DESC',
    ) );
    if (!$posts) return;
    echo $args['before_widget'];
    if ($title) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
  ?>
    <ul class="popular-posts">
    <?php foreach ($posts as $post): ?>
      <li>
        <a href="<?php echo get_permalink($post->ID); ?>" class="align-items-center">
          <figure class="popular-posts__img col-4 px-1">
            <p class="ratio-3to2"><img src="<?php echo azami_get_the_thumbnail('thumb-300', $post->ID); ?>" alt="<?php the_title();?>" loading="lazy"></p>
          </figure>
          <p class="popular-posts__text col-8 px-1">
            <?php substring_title($post->ID, 41); ?>
            <?php if ($show_views) echo '<span class="views">' . get_post_meta($post->ID, 'post_views_count', true) . ' views</span>'; ?>
          </p>
        </a>
      </li>
      <?php endforeach;?>
      <?php wp_reset_postdata();?>
    </ul>
    <?php echo $args['after_widget']; ?>
  <?php 
    } // END public function widget

    public function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['count'] = $new_instance['count'];
      $instance['show_views'] = $new_instance['show_views'];
      return $instance;
    } // END public function update

    public function form($instance) {
      $title      = isset($instance['title']) ? esc_attr($instance['title']) : '';
      $entry_num  = isset($instance['count']) ? $instance['count'] : '';
      $show_views = isset($instance['show_views']) ? $instance['show_views'] : '';
    ?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">タイトル:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('count'); ?>">表示する記事数</label>
        <input class="tiny-text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" step="1" min="1" value="<?php echo $entry_num; ?>" size="3">
      </p>
      <p>
        <input id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" type="checkbox" value="1" <?php checked($show_views, 1);?>/>
        <label for="<?php echo $this->get_field_id('show_views'); ?>">累計閲覧数を表示</label>
      </p>
    <?php
  } // END public function form
}
add_action('widgets_init', function () {
  register_widget('AZAMI_Popular_Posts_Widget');
});

/*
アクセス数を保存（single.phpで呼び出し）
-------------------------------------------------*/
if ( !function_exists('azami_set_post_views') ) {
  function azami_set_post_views($postID)
  {
    $count_key = 'post_views_count';
    $num = get_post_meta($postID, $count_key, true);
    if ($num == '') {
      $num = 0;
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '1');
    } else {
      $num++;
      update_post_meta($postID, $count_key, $num);
    }
  }
}

/*
アクセスがBOTかどうか判断（single.phpで呼び出し）
-------------------------------------------------*/
if ( !function_exists('is_bot') ) {
  function is_bot() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $bots = array(
      'Googlebot',
      'Yahoo! Slurp',
      'Mediapartners-Google',
      'msnbot',
      'bingbot',
      'MJ12bot',
      'Ezooms',
      'pirst; MSIE 8.0;',
      'Google Web Preview',
      'ia_archiver',
      'Sogou web spider',
      'Googlebot-Mobile',
      'AhrefsBot',
      'YandexBot',
      'Purebot',
      'Baiduspider',
      'UnwindFetchor',
      'TweetmemeBot',
      'MetaURI',
      'PaperLiBot',
      'Showyoubot',
      'JS-Kit',
      'PostRank',
      'Crowsnest',
      'PycURL',
      'bitlybot',
      'Hatena',
      'facebookexternalhit',
      'NINJA bot',
      'YahooCacheSystem',
    );
    foreach ($bots as $bot) {
      if (stripos($ua, $bot) !== false) { return true; }
    }
    return false;
  }
}


/*-------------------------------------------------
投稿数表示時のリンク文字列修正
例： <a href="">カテゴリー 1</a> (1)
　⇒ <a href="">カテゴリー 1 (1)</a>
-------------------------------------------------*/

/*
アーカイブウィジェット
-------------------------------------------------*/
function azami_archives_link($output) {
  $output = preg_replace('/<\/a>\s*(&nbsp;)\((\d+)\)/',' ($2)</a>',$output);
  return $output;
}
add_filter('get_archives_link', 'azami_archives_link');

/*
カテゴリーウィジェット
-------------------------------------------------*/
function azami_list_categories($output) {    
  $output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
  return $output;
}
add_filter('wp_list_categories', 'azami_list_categories');