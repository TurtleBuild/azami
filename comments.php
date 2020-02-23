<?php
if ( post_password_required() ) {
  return;
}
?>
<div class="article-comments pt-5">
  <?php if ( have_comments() ) : ?>
  <?php
  $all_comments = get_comments('post_id=' . $id);
  $sep_comments = separate_comments($all_comments);
  ?>
    <?php if ( ! empty($sep_comments['comment']) ) : ?>
    <h3 class="pt-7 pb-2"><i class="fas fa-comment-dots mr-2"></i>コメント</h3>
    <div class="comment-list">
      <?php
        wp_list_comments( array(
          'max_depth'  => 5,
          'style'      => 'div',
          'callback'   => 'azami_comment',
          'short_ping' => true,
          'avatar_size'=> 48,
          'type' => 'comment'
        ) );
      ?>
    </div>
    <?php endif; ?>
    <?php if ( ! empty($sep_comments['pings']) ) : ?>
    <h3 class="pt-7 pb-2"><i class="fas fa-link mr-2"></i>ピンバック</h3>
    <div class="pings-list">
      <?php
        wp_list_comments( array(
          'style'      => 'div',
          'callback'   => 'azami_ping',
          'short_ping' => true,
          'type'       => 'pings'
        ) );
      ?>
    </div>
    <?php endif; ?>
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
      <nav role="navigation">
        <div><?php previous_comments_link('<i class="fa fa-chevron-left"></i> 過去のコメントを表示'); ?></div>
        <div><?php next_comments_link('新しいコメントを表示 <i class="fa fa-chevron-right"></i> '); ?></div>
      </nav>
    <?php endif; ?>
  <?php endif; ?>
  <?php comment_form(); ?>
</div>
