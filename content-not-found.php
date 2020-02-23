<article <?php post_class('border p-3 p-md-5 mb-5'); ?>>
  <div>
    <p>
      <?php 
      if( is_search() || is_archive() ) {
        echo '記事が見つかりませんでした。';
      } else {
        echo 'お探しのページが見つかりませんでした。';
      }
      ?>
    </p>
    <p>
      <?php
      if( is_search() ) {
        echo '指定されたキーワードでは記事が見つかりませんでした。';
      } elseif( is_archive() ) {
        echo 'まだ記事が投稿されていません。';
      } else {
        echo 'お探しのページは「既に削除されている」、「アクセスしたアドレスが異なっている」などの理由で見つかりませんでした。';
      }
      ?>
    </p>
    <?php get_search_form(); ?>
  </div>
</article>
