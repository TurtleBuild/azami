    </div><!-- /row -->
  </div><!-- /container -->
  <footer class="site-footer py-4 mt-7">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <?php if( is_active_sidebar('footer_left') ) dynamic_sidebar( 'footer_left' ); ?>
        </div>
        <div class="col-lg-4">
          <?php if( is_active_sidebar('footer_center') ) dynamic_sidebar( 'footer_center' ); ?>
        </div>
        <div class="col-lg-4">
          <?php if( is_active_sidebar('footer_right') ) dynamic_sidebar( 'footer_right' ); ?>
        </div>
      </div>
    </div>
    <div class="copyright text-center pt-7">
      <p><small>
        Copyright &copy; <?php echo date('Y'); ?>
        <?php bloginfo('name'); ?>
        All rights reserved.
      </small></p>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>