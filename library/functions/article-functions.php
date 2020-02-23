<?php
/*-------------------------------------------------
記事で使用される関数の定義
- パンくずリストの表示
- ボタンの表示
- この記事を書いた人の表示
- 関連記事の表示
- コメント欄の表示
- 記事一覧のページネイション
- カテゴリー名を出力（トップページ記事一覧のサムネイル上に表示）
-------------------------------------------------*/


/*-------------------------------------------------
パンくずリストの表示
schema.orgを使用
SEO的に重視しないページは敢えてパンくず化しない
-------------------------------------------------*/
if ( !function_exists('insert_breadcrumb') ) {
  function insert_breadcrumb()
  {
    global $post;
    $html = '<nav id="breadcrumb"><ul itemscope itemtype="http://schema.org/BreadcrumbList" class="small list-unstyled mb-0">';
    // ホーム（1階層目）
    $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . home_url() . '" itemprop="item"><span itemprop="name">ホーム</span></a><meta itemprop="position" content="1" /></li>';
    // 2階層目以降
    $level = 2;
    if ( is_category() ) {
      // カテゴリーページ
      $cat = get_queried_object();
      $html .= $cat->parent != 0 ? createBreadcrumbCategory($cat, $level) : '';
      $html .= '<li><i class="fas fa-folder"></i> ' . esc_attr($cat->cat_name) . '</li>';
    } elseif ( is_date() ) {
      // 日付ページ
      if ( is_day() ) {
        $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_year_link( get_query_var('year') ) . '" itemprop="item"><span itemprop="name">' . get_query_var('year') . '年</span></a><meta itemprop="position" content="2" /></li>';
        $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_month_link( get_query_var('year'), get_query_var('monthnum') ) . '" itemprop="item"><span itemprop="name">' . get_query_var('monthnum') . '月</span></a><meta itemprop="position" content="3" /></li>';
      } elseif ( is_month() ) {
        $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_year_link( get_query_var('year') ) . '" itemprop="item"><span itemprop="name">' . get_query_var('year') . '年</span></a><meta itemprop="position" content="2" /></li>';
      }
    } elseif ( is_tag() ) {
      // タグページ
      $html .= '<li><i class="fa fa-tag"></i> '. single_tag_title("", false) .'</li>';
    } elseif ( is_author() ) {
      // 著者ページ
      $html .= '<li>著者</li>';
    } elseif ( is_page() ) {
      if ($post->post_parent != 0) {
        $ancestors = array_reverse( get_post_ancestors($post->ID) );
        foreach ($ancestors as $ancestor) {
          $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink($ancestor) ) . '" itemprop="item"><span itemprop="name">' . esc_attr( get_the_title($ancestor) ) . '</span></a><meta itemprop="position" content="' . $level . '" /></li>';
          $level++;
        }
      }
    } elseif ( is_single() ) {
      // 投稿ページ
      $categories = get_the_category($post->ID);
      if (!$categories) {
        return false;
      }
      $cat = $categories[0];
      $html .= $cat->parent != 0 ? createBreadcrumbCategory($cat, $level) : '';
      $html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_category_link($cat->term_id) ) . '" itemprop="item"><i class="fas fa-folder"></i> <span itemprop="name">' . esc_attr($cat->cat_name) . '</span></a><meta itemprop="position" content="' . $level . '" /></li>';
    } else {
      // それ以外のページ
      $html .= '<li>' . wp_title('', false) . '</li>';
    }
    $html .= '</ul></nav>';
    echo $html;
  }
  // カテゴリーのパンくずを作成
  function createBreadcrumbCategory($cat, $level){
    $ancestors = array_reverse( get_ancestors($cat->cat_ID, 'category') );
    foreach ($ancestors as $ancestor) {
      $html = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_category_link($ancestor) ) . '" itemprop="item"><i class="fas fa-folder"></i> <span itemprop="name">' . esc_attr( get_cat_name($ancestor) ) . '</span></a><meta itemprop="position" content="' . $level . '" /></li>';
      $level++;
    }
    return $html;
  }
}


/*-------------------------------------------------
ボタンの表示
-------------------------------------------------*/

/*
カテゴリボタンの表示
-------------------------------------------------*/
if ( !function_exists('insert_category_buttons') ) {
    function insert_category_buttons() {
    $cats = get_the_category();
    foreach($cats as $cat){
      echo '<a href="'.get_category_link($cat->term_id).'" ';
      echo 'class="btn azami-main-color--outline btn-sm ml-2 mb-2" role="button">';
      echo esc_html($cat->name);
      echo '</a>';
    }
  }
}

/*
タグボタンの表示
-------------------------------------------------*/
if ( !function_exists('insert_tag_buttons') ) {
  function insert_tag_buttons() {
    $tags = get_the_tags();
    foreach($tags as $tag){
      echo '<a href="'.get_tag_link($tag->term_id).'" ';
      echo 'class="btn btn-tags btn-sm ml-2 mb-2" role="button">';
      echo esc_html($tag->name);
      echo '</a>';
    }
  }
}

/*
シェアボタンの表示
-------------------------------------------------*/
if ( !function_exists('insert_social_buttons') ) {
  function insert_social_buttons() {
    $share_url = urlencode(
      ( is_home() || is_front_page() )
        ? home_url('/')
        : get_permalink()
    );
    $sitename = urlencode(
      ( is_home() || is_front_page() )
        ? ''
        : '｜' . get_bloginfo('name')
    );
    $article_title = urlencode(
      ( is_home() || is_front_page() )
        ? get_bloginfo('name') . '｜' . get_bloginfo('description')
        : get_the_title()
    );
  ?>
  <div class="pt-7">
    <p class="text-center"><i class="fas fa-share-alt"></i> この記事をシェアする</p>
    <div class="row justify-content-center">
      <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
        <a
          title="Twitter"
          href="http://twitter.com/share?url=<?php echo $share_url; ?>&text=<?php echo $article_title . $sitename; ?>"
          target="_blank"
          class="btn btn-twitter w-100"
          rel="nofollow noopener noreferrer">
          <i class="fab fa-twitter fa-fw lead"></i> <small>ツイート</small>
        </a>
      </div>
      <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
        <a
          title="Facebook"
          href="http://www.facebook.com/share.php?u=<?php echo $share_url; ?>&t=<?php echo $article_title . $sitename; ?>"
          target="_blank"
          class="btn btn-facebook w-100"
          rel="nofollow noopener noreferrer">
          <i class="fab fa-facebook-f lead"></i> <small>シェア</small>
        </a>
      </div>
      <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
        <a
          title="はてなブックマーク"
          href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $share_url; ?>"
          onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;"
          target="_blank"
          class="btn btn-hatebu w-100"
          rel="nofollow noopener noreferrer">
          <i class="fa-hatena"></i> <small>はてブ</small>
        </a>
      </div>
      <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
        <a
          title="LINE"
          href="http://line.me/R/msg/text/?<?php echo $share_url; ?>%0D%0A<?php echo $article_title . $sitename; ?>"
          target="_blank"
          class="btn btn-line w-100"
          rel="nofollow noopener noreferrer">
          <i class="fab fa-line lead"></i> LINE
        </a>
      </div>
    </div>
  </div>
  <?php
  }
}


/*-------------------------------------------------
この記事を書いた人の表示
-------------------------------------------------*/
if ( !function_exists('insert_author_info') ) {
  function insert_author_info()
  {
    $author_descr = get_the_author_meta('description');
    // プロフィール情報が空欄のときは表示しない
    if ( empty($author_descr) ) return;
  ?>
  <div class="container author-info p-4 mt-md-7 mt-5">
    <h5>About me</h5>
    <div class="row pt-3">
      <div class="col-12 col-sm-3 d-flex flex-column align-items-center">
        <div class="avatar text-center">
          <?php
            $iconimg = get_avatar(get_the_author_meta('ID'), 100);
            if($iconimg) echo $iconimg;
          ?>
          <p class="mb-2 m-sm-0">
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>">
              <?php esc_attr( the_author_meta('display_name') ); ?></a>
          </p>
        </div>
      </div>
      <div class="col-12 col-sm-9 d-flex align-items-center">
        <p class="small"><?php the_author_meta('user_description'); ?></p>
      </div>
    </div><!-- row -->
    <div class="row">
      <div class="col-0 col-sm-3"></div>
      <div class="col-0 col-sm-9">
        <div class="follow_btn text-center">
          <?php
            $socials = array(
              'Website'   => esc_url( get_the_author_meta('url') ),
              'Twitter'   => esc_url( get_the_author_meta('twitter') ),
              'Facebook'  => esc_url( get_the_author_meta('facebook') ),
              'Instagram' => esc_url( get_the_author_meta('instagram') ),
              'Feedly'    => esc_url( get_the_author_meta('feedly') ),
              'YouTube'   => esc_url( get_the_author_meta('youtube') ),
              'LINE'      => esc_url( get_the_author_meta('line') ),
              'github'    => esc_url( get_the_author_meta('github') )
            );
            foreach ($socials as $name => $url) {
              if ($url) { ?>
                <a class="<?php echo $name; ?> mx-2" href="<?php echo esc_url($url); ?>" target="_blank" rel="nofollow noopener noreferrer"></a>
          <?php
              }
            } ?>
        </div><!-- follow_btn -->
      </div>
    </div><!-- row -->
  </div><!-- container -->
	<?php }
}


/*-------------------------------------------------
関連記事の表示
-------------------------------------------------*/
if ( !function_exists('insert_related_posts') ) {
  function insert_related_posts()
  {
    global $post;
    $categories = get_the_category();
    if (!$categories) return;

    $catid = ( get_option('related_add_parent') ) ?  get_parent_and_siblings_cat_ids($categories[0]) : $categories[0]->cat_ID;
    $num = ( get_option('num_related_posts') ) ? esc_attr( get_option('num_related_posts') ) : 6;

    $related_posts = get_posts( array(
      'category__in' => $catid,
      'exclude'      => $post->ID,
      'numberposts'  => $num,
      'orderby'      => 'rand',
    ) );
    if(!$related_posts) return;

    echo '<h3 id="related-posts__title" class="pb-2 mt-7">関連記事</h3>';
    echo '<div class="container"><ul class="row p-0">';
    foreach ($related_posts as $related_post) :
      $src = azami_get_the_thumbnail('thumb-640', $related_post->ID);
      $title = $related_post->post_title;
  ?>
  <div class="col-6 col-md-4 mb-4 px-1">
    <a class="card img-thumbnail p-0" href="<?php echo get_permalink($related_post->ID); ?>">
      <p class="ratio-16to9"><img src="<?php echo $src; ?>" alt="<?php echo esc_html($title); ?>" loading="lazy" class="card-img-top"></p>
      <div class="card-body p-2">
        <h6><?php echo $title; ?></h6>
      </div><!-- /.card-body -->
    </a><!-- /.card -->
  </div><!-- /.col-md-6 -->
  <?php
    endforeach;
    wp_reset_postdata();
    echo '</ul></div>';
  }
}
// 親カテゴリーとその子カテゴリーを取得する関数
if ( !function_exists('get_parent_and_siblings_cat_ids') ) {
  function get_parent_and_siblings_cat_ids($category) {
    $ids = array();
    $parent_id = $category->category_parent;
    if(!$parent_id) return $category->cat_ID;
    
    $child_catids = get_term_children($parent_id, 'category');
    foreach ($child_catids as $id) {
      $ids[] .= $id;
    }
    $ids[] .= $parent_id;
    return $ids;
  }
}


/*-------------------------------------------------
コメント欄の表示
-------------------------------------------------*/

/*
コメントレイアウト（comments.phpで呼び出し）
-------------------------------------------------*/
if ( !function_exists('azami_comment') ) {
  function azami_comment($comment, $args, $depth) {
    ?>
    <div <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
      <div id="div-comment-<?php comment_ID() ?>" class="row small mb-4">
      <?php // 管理人コメント用HTMLを出力（メールアドレスで判別）
        if ( $comment->comment_author_email == get_the_author_meta('email') ): ?>
        <div class="col-9 col-md-10">
          <div class="comment-content ml-auto">
            <div class="comment-balloon comment-balloon--left">
              <?php comment_text(); ?>
            </div>
            <div class="comment-reply small">
              <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php
                /* translators: 1: date, 2: time */
                printf( '%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link('（Edit）', '  ', '' );
                comment_reply_link( array_merge( $args, array( 'reply_text' => '　<i class="fas fa-reply"></i> 返信','add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
          </div><!-- comment-content -->
        </div><!-- col-10 -->
        <div class="col-3 col-md-2 text-center">
          <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', '', array('class' => 'd-block m-auto align-top rounded-circle') ); ?>
          <?php printf( '<cite class="comment-user">%s</cite>', get_comment_author_link() ); ?>
        </div><!-- col-2 -->
      <?php // ゲストコメント用のHTMLを出力
        else: ?>
        <div class="col-3 col-md-2 text-center">
          <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', '', array('class' => 'd-block m-auto align-top rounded-circle') ); ?>
          <?php printf( '<cite class="comment-user">%s</cite>', get_comment_author_link() ); ?>
        </div><!-- col-2 -->
        <div class="col-9 col-md-10">
          <div class="comment-content">
            <div class="comment-balloon comment-balloon--right">
              <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php echo 'あなたのコメントは承認待ちです。'; ?></em>
                <br />
              <?php endif; ?>
              <?php comment_text(); ?>
            </div>
            <div class="comment-reply small">
              <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php
                /* translators: 1: date, 2: time */
                printf('%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link('（Edit）', '  ', '' );
                comment_reply_link( array_merge( $args, array( 'reply_text' => '　<i class="fas fa-reply"></i> 返信','add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                ?>
            </div>
          </div><!-- comment-content -->
        </div><!-- col-10 -->
      <?php endif; ?>
      </div><!-- row -->
    <?php
  }
}

/*
ピンバックレイアウト（comments.phpで呼び出し）
-------------------------------------------------*/
if ( !function_exists('azami_ping') ) {
  function azami_ping($comment, $args, $depth)
  {
    $GLOBALS['comment'] = $comment;?>
    <div id="comment-<?php comment_ID();?>">
      <article>
        <header>
          <?php printf( '<cite class="comment-user">%1$s</cite> %2$s', get_comment_author_link(), edit_comment_link('（Edit）', '  ', '') )?>
          <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link($comment->comment_ID) ) ?>" rel="nofollow"><?php comment_time( get_option( 'date_format' ) );?></a></time>
        </header>
        <?php if ($comment->comment_approved == '0'): ?>
          <em class="comment-awaiting-moderation"><?php echo 'あなたのトラックバックは承認待ちです。'; ?></em>
          <br />
        <?php endif;?>
        <?php comment_text()?>
      </article>
  <?php
  }
}

/*
コメント送信ボタンの表示
-------------------------------------------------*/
if ( !function_exists('azami_comment_form_submit_button') ) {
  function azami_comment_form_submit_button($submit_button, $args){
    return '<button name="'.esc_attr($args['name_submit']).'" id="'.esc_attr($args['id_submit']).'" class="'.esc_attr($args['class_submit']).' btn azami-main-color">'.esc_attr($args['label_submit']).'</button>';
  }
  add_filter('comment_form_submit_button', 'azami_comment_form_submit_button', 10, 2);
}


/*-------------------------------------------------
記事一覧のページネイション
-------------------------------------------------*/
if ( !function_exists('azami_pagination') ) {
  function azami_pagination()
  {
    $max_num_pages = $GLOBALS['wp_query']->max_num_pages;
    if ($max_num_pages < 2) {
      return;
    }
    
    $paged = get_query_var('paged') ? intval( get_query_var('paged') ) : 1;
    
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);
    if ( isset($url_parts[1]) ) {
      wp_parse_str($url_parts[1], $query_args);
    }
    $pagenum_link = remove_query_arg( array_keys($query_args), $pagenum_link );
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

    echo paginate_links( array(
      'base'      => $pagenum_link,
      'format'    => $format,
      'total'     => $max_num_pages,
      'current'   => $paged,
      'add_args'  => array_map('urlencode', $query_args),
      'prev_next' => false,
      'type'      => 'plain',
    ) );
  }
}

/*-------------------------------------------------
カテゴリー名を出力（トップページ記事一覧のサムネイル上に表示）
-------------------------------------------------*/
if ( !function_exists('output_catogry_name') ) {
  function output_catogry_name()
  {
    $cat = get_the_category();
    if (!$cat) return false;

    $cat = $cat[0];
    $catId = $cat->cat_ID;
    $catName = esc_attr($cat->cat_name);
    if ($catName) {
      echo '<span class="cat-name azami-main-color">' . $catName . '</span>';
    }
  }
}
