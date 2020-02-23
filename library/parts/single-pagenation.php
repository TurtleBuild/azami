<div class="single-pagenation pt-3 row">
  <?php
    $prev_post = get_adjacent_post(false, '', true);
    if($prev_post):
      $prev_id=$prev_post->ID; 
  ?>
  <a href="<?php the_permalink($prev_id); ?>" class="col-12 col-md-6">
  <div class="card prev-card mb-3">
    <div class="row no-gutters align-items-center">
      <div class="col-5">
        <p class="ratio-3to2"><img src="<?php echo azami_get_the_thumbnail('thumb-300', $prev_id); ?>" alt="<?php the_title();?>" loading="lazy"></p>
      </div>
      <div class="col-7">
        <div class="card-body pt-2 pr-2 pb-0">
          <h5 class="card-title"><?php substring_title($prev_id, 31); ?></h5>
        </div>
      </div>
      <p class="card-text p-0 m-0"><small>PREV</small></p>
    </div>
  </div></a>
  <?php endif; ?>
  <?php
    $next_post = get_adjacent_post(false, '', false);
    if($next_post):
      $next_id=$next_post->ID;
  ?>
  <a href="<?php the_permalink($next_id); ?>" class="col-12 col-md-6">
  <div class="card next-card mb-3">
    <div class="row no-gutters align-items-center">
      <div class="col-7">
        <div class="card-body pt-2 pl-2 pb-0">
          <h5 class="card-title"><?php substring_title($next_id, 31); ?></h5>
        </div>
      </div>
      <div class="col-5">
        <p class="ratio-3to2"><img src="<?php echo azami_get_the_thumbnail('thumb-300', $next_id); ?>" alt="<?php the_title();?>" loading="lazy"></p>
      </div>
      <p class="card-text p-0 m-0"><small>NEXT</small></p>
    </div>
  </div></a>
  <?php endif; ?>
</div>