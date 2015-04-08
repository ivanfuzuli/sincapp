<form class="modal fade" name="editCloudForm" id="editCloudForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Blog Bulutu Ayarlarını Düzenle</h3>
  </div>
  <div class="modal-body">
    <div class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputBlogId">Bağlanacak Blog</label>
        <div class="controls">
            <span id="blog-list"><?php echo form_dropdown('blog_id', $blogs, $blog_cloud->blog_id);?></span> <a href="#" class="btn btn-danger" id="btn-delete-blog">Sil</a>
        <div class="input-append add-blog-container">            
            <input type="text" name="blog-name" id="blog-name" placeholder="Yeni Blog Adı"/> <a href="#" class="btn btn-primary" id="btn-add-blog">Ekle</a>
        </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="">Bir sayfada gösterilecek yazı sayısı:</label>
        <div class="controls">
              <?php echo form_dropdown('limit_count', $limit_counts, $blog_cloud->limit_count);?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="">Sayfalama:</label>
        <div class="controls">
            <?php echo form_dropdown('pagination', array(0 => 'Olmasın', 1 => 'Olsun'), $blog_cloud->pagination);?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="">Bu bloga ait yazıların içerikleri bu alanda görünsün:</label>
        <div class="controls">
           <?php echo form_checkbox('view_here', '1', $blog_cloud->view_here);?>
           <input type="hidden" name="site_id" value="<?php echo $site_id?>">
           <input type="hidden" name="blog_cloud_id" value="<?php echo $blog_cloud->id?>">           
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="">Blog Şablonu:</label>
        <div class="controls">
           <?php echo form_dropdown('layout', array( 'default' => 'Başlık ve Yazı', 'only_title' => 'Sadece Başlık'), $blog_cloud->layout);?>

           <input type="hidden" name="site_id" value="<?php echo $site_id?>">
           <input type="hidden" name="blog_cloud_id" value="<?php echo $blog_cloud->id?>">           
        </div>
      </div>                     
    </div> 
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal">Kapat</a>      
    <input type="submit" class="btn btn-primary" data-loading-text="Lütfen Bekleyin.." data-complete-text="Kaydet" value="Kaydet" />
  </div>     
</form>
