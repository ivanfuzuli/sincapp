<?php if(!isset($no_parent)):?>
<div class="blog blog_<?php echo $blog_id?>">
	<div class="blog_cloud" id="blogCloud_<?php echo $cloud_id?>"  data-blog-id="<?php echo $blog_id?>" data-blog-cloud-id="<?php echo $cloud_id?>">
<?php endif;?>
		<?php if($mode == 'admin'):?>
		<div>
			<a href="#" class="add-post btn btn-success">Yeni Yazı Ekle</a>
		</div>
		<?php 
		endif;
		if($posts):
		foreach($posts as $post):?>
			<div class="post">
				<?php if(isset($no_parent) || $mode == 'admin'):?>
					<h3><a href="<?php echo base_url() . 'manage/editor/wellcome/' .$site_id. '/article/'. $post->slug . '.html'?>"><?php echo $post->title?></a></h3>
					<div class="btn-blog-group"><a href="#" class="edit-post btn btn-primary btn-small" data-post-id="<?php echo $post->id?>"><i class="fa fa-edit"></i> Düzenle</a> <a data-post-id="<?php echo $post->id?>" href="#" class="delete-post btn btn-small btn-danger"><i class="fa fa-times"></i> Sil</a></div>				
				<?php else:?>
					<h3><a href="<?php echo base_url() . 'article/'. $post->slug . '.html'?>"><?php echo $post->title?></a></h3>
				<?php endif;?>
				<?php 
				$date = date_create($post->post_date);
				echo date_format($date, 'd/m/Y');?>
				<div class="post-content">
					<?php echo $post->content?>
					<?php if($post->read_more):?>
					<?php if($mode == 'admin'):?>
						<a href="<?php echo base_url() . 'manage/editor/wellcome/' .$site_id. '/article/'. $post->slug . '.html'?>">Devamını Oku →</a></h3>
					<?php else:?>
						<a href="<?php echo base_url() . 'article/'. $post->slug . '.html'?>">Devamını Oku →</a>
					<?php endif;?>					
					<?php endif;?>
				</div>
			</div>
			<hr>
		<?php endforeach;
		endif;?>
		<?php if(!$posts):?>
			Bu bloga henüz bir yazı eklenmemiş.
		<?php endif?>
		<?php if($pagination && $pages):?>
		<div class="pagination">
			<ul><?php echo $pages?></ul>
		</div>
		<?php endif;?>
<?php if(!isset($no_parent)):?>
	</div>
</div>
<?php endif;?>
