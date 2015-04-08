<form id="add-post">
  <input type="hidden" name="blog_cloud_id" value="<?php echo $cloud_id?>">
  <input type="hidden" id="post_blog_id" name="blog_id" value="<?php echo $blog_id?>">
  <input type="hidden" name="site_id" value="<?php echo $site_id?>">
  <?php if (isset($post)):?>
    <input type="hidden" name="post_id" value="<?php echo $post->id?>">
  <?php endif;?>
  <div class="form-inline">
  <input type="text" name="post-title" id="post-title" placeholder="Yazınızın Başlığı" value="<?php echo isset($post) ? $post->title : "";?>">
  <a href="#" class="btn btn-danger" id="cancel-post">Kapat</a>
  <input type="submit" id="blog-submit" class="btn btn-success" value="Kaydet">
</div>
<textarea name="post-content" id="post-content"><?php echo isset($post) ? $post->content : ""?></textarea>
</form>
