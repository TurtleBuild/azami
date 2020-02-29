<?php
/*-------------------------------------------------
メインビジュアルの表示（Bootstrapを使用）
-------------------------------------------------*/
  if( get_option('main_visual_img_1') ) :
?>
<style>
  .main-visual-1 h2 { color: <?php echo get_theme_mod('main_visual_heading_1_color', '#77c0c9'); ?>; }
  .main-visual-2 h2 { color: <?php echo get_theme_mod('main_visual_heading_2_color', '#77c0c9'); ?>; }
  .main-visual-3 h2 { color: <?php echo get_theme_mod('main_visual_heading_3_color', '#77c0c9'); ?>; }
  .main-visual-1 p  { color: <?php echo get_theme_mod('main_visual_text_1_color', '#fff'); ?>; }
  .main-visual-2 p  { color: <?php echo get_theme_mod('main_visual_text_2_color', '#fff'); ?>; }
  .main-visual-3 p  { color: <?php echo get_theme_mod('main_visual_text_3_color', '#fff'); ?>; }
  @media (min-width: 768px) {
    #main_visual {
      animation-name: up-fade-animation;
      animation-duration: 0.6s;
      animation-delay: 0.6s;
      animation-fill-mode: forwards;
      filter: opacity(0);
    }
  }
  @media (max-width: 767.98px) {
    #main_visual {
      animation-name: pickup-animate;
      animation-duration: 0.6s;
      animation-delay: 0.6s;
      animation-fill-mode: forwards;
      opacity: 0;
      z-index: 4;
    } 
  }
</style>
<div class="mt-5">
  <div class="container px-md-3 px-2">
    <div id="main_visual" class="carousel slide" data-ride="carousel">
      <?php // インジケーターの表示
      if( get_option('main_visual_img_2') || get_option('main_visual_img_3') ): ?>
      <ol class="carousel-indicators">
        <li data-target="#main_visual" data-slide-to="0" class="active"></li>
        <li data-target="#main_visual" data-slide-to="1"></li>
        <?php if( get_option('main_visual_img_2') && get_option('main_visual_img_3') ) : ?>
        <li data-target="#main_visual" data-slide-to="2"></li>
        <?php endif; ?>
      </ol>
      <?php endif; ?>
      <div class="carousel-inner">
        <div class="carousel-item main-visual-1 active">
          <img src="<?php echo esc_url( get_option('main_visual_img_1') );?>" class="img-fluid"/>
          <div class="carousel-caption d-none d-md-block">
          <?php if( get_option('main_visual_heading_1') ): ?>
            <h2><?php echo get_option('main_visual_heading_1'); ?></h2>
          <?php endif; ?>
          <?php if( get_option('main_visual_text_1') ): ?>
            <p><?php echo get_option('main_visual_text_1'); ?></p>
          <?php endif; ?>
          </div>
        </div>
      <?php if( get_option('main_visual_img_2') ): ?>
        <div class="carousel-item main-visual-2">
          <img src="<?php echo esc_url( get_option('main_visual_img_2') );?>" class="img-fluid"/>
          <div class="carousel-caption d-none d-md-block">
          <?php if( get_option('main_visual_heading_2') ): ?>
            <h2><?php echo get_option('main_visual_heading_2'); ?></h2>
          <?php endif; ?>
          <?php if( get_option('main_visual_text_2') ): ?>
            <p><?php echo get_option('main_visual_text_2'); ?></p>
          <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if( get_option('main_visual_img_3') ): ?>
        <div class="carousel-item main-visual-3">
          <img src="<?php echo esc_url( get_option('main_visual_img_3') );?>" class="img-fluid"/>
          <div class="carousel-caption d-none d-md-block">
          <?php if( get_option('main_visual_heading_3') ): ?>
            <h2><?php echo get_option('main_visual_heading_3'); ?></h2>
          <?php endif; ?>
          <?php if( get_option('main_visual_text_3') ): ?>
            <p><?php echo get_option('main_visual_text_3'); ?></p>
          <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
      </div>
      <?php // コントローラーの表示
      if( get_option('main_visual_img_2') || get_option('main_visual_img_3') ): ?>
      <a class="carousel-control-prev" href="#main_visual" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">前に戻る</span> </a>
      <a class="carousel-control-next" href="#main_visual" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">次に進む</span> </a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>