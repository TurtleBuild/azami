<?php
/*-------------------------------------------------
メインビジュアルの表示（2カラム）
-------------------------------------------------*/
  if( get_option('main_visual_2col_img') ) :
    $imgurl = esc_url( get_option('main_visual_2col_img') );
    $main_visual_h = get_option('main_visual_2col_heading');
    $main_visual_d = get_option('main_visual_2col_text');
    $main_visual_heading_color = get_theme_mod('main_visual_2col_heading_color', '#77c0c9');
    $main_visual_desc_color = get_theme_mod('main_visual_2col_text_color', '#fff');
    $main_visual_bg_color = get_theme_mod('main_visual_2col_bg_color', '#636363');
    $rgb = change_RGB($main_visual_bg_color);
?>
<style>
  .main-visual__left-col {
    width: 100%;
    height: 0;
    padding-top: 400px;
    <?php if( get_option('main_visual_2col_gradation_checkbox') ): ?>
    background: linear-gradient(90deg, rgba(255,255,255,0) 60%, <?php echo $rgb; ?>), url(<?php echo $imgurl; ?>) center center / cover no-repeat;
    <?php else: ?>
    background: url(<?php echo $imgurl; ?>) center center / cover no-repeat;
    <?php endif; ?>
  }
  .main-visual__right-col {
    background-color: <?php echo $main_visual_bg_color; ?>;
  }
  .main-visual__right-inner {
    height: 400px;
  }
  .main-visual__right-inner h2 {
    color: <?php echo $main_visual_heading_color; ?>;
  }
  .main-visual__right-inner p {
    color: <?php echo $main_visual_desc_color; ?>;
  }
  @media (min-width: 768px) {
    .main-visual-2col {
      animation-name: up-fade-animation;
      animation-duration: 0.6s;
      animation-delay: 0.6s;
      animation-fill-mode: forwards;
      filter: opacity(0);
    }
  }
  @media (max-width: 767.98px) {
    .main-visual__left-col {
      padding-top: 300px;
      <?php if( get_option('main_visual_2col_gradation_checkbox') ): ?>
      background: linear-gradient(rgba(255,255,255,0) 60%, <?php echo $rgb; ?>), url(<?php echo $imgurl; ?>) center center / cover no-repeat;
      <?php else: ?>
      background: url(<?php echo $imgurl; ?>) center center / cover no-repeat;
      <?php endif; ?>
    }
    .main-visual__right-inner {
      height: 200px;
    }
    .main-visual-2col {
      animation-name: pickup-animate;
      animation-duration: 0.6s;
      animation-delay: 0.6s;
      animation-fill-mode: forwards;
      opacity: 0;
      z-index: 4;
    } 
  }
</style>
<div class="main-visual-2col container px-md-5 mt-md-5">
  <div class="row">
    <div class="main-visual__left-col col-12 col-md-7 px-0"></div>
    <div class="main-visual__right-col col-12 col-md-5">
      <div class="main-visual__right-inner d-table">
        <div class="d-table-cell align-middle">
          <?php if($main_visual_h) : ?>
          <h2><?php echo $main_visual_h ?></h2>
          <?php endif; ?>
          <?php if($main_visual_d) : ?>
          <p><?php echo $main_visual_d ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>