<div class="post">
	<h3><?php echo $post->title?></h3>
	<?php 
	$date = date_create($post->post_date);
	echo date_format($date, 'd/m/Y');?>
	<div class="post-content"><?php echo $post->content?></div>
</div>