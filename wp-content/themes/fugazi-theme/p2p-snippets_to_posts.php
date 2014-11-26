<?php 
	global $post; 
	$postid = $post->ID;
?>

<div class="custom-shortcode">
	<table>
		<tbody><tr>

			<td><?php 
			echo has_post_thumbnail($postid);
			echo get_the_post_thumbnail( $postid, "thumbnail", $attr ); ?></td>
			<td><a href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a></td>
		</tr>
	</tbody></table>  	
  <?php echo $post->post_content; ?>
</div>


