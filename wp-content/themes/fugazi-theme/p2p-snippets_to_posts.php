<?php global $post; ?>

<div>
  <?php the_post_thumbnail(); ?>
  <a href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a>
  <?php echo $post->post_content; ?>
</div>


