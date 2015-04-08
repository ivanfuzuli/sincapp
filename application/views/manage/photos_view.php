<form class="modal fade" name="photoForm" id="photoForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_photos_title')?></h3>
  </div>
    <div class="modal-body">
<div class="uploading-area" id="uploadPhoto">
    <div id="swfupload-control">
	<input type="button" id="button" />
    </div>
  <div class="fileupload-area">
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Fotoğraf Yükle</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" accept="image/*" name="files[]" multiple>
    </span>
  </div>
  <div id="progressbar" class="progress-bar hide">
      <div style="width: 0%;">0%</div>
  </div>

<span id="upload-tip"><?php echo lang('str_upload_tip')?></span>
<?php echo "<span id=\"upload-quota\">Toplam: ".format_size_units($package->storage * 1024 * 1024)."'lık alanının ".format_size_units($storage_quota * 1024)."'i (%".$storage_percentage.") kullanılıyor.</span>";?>

</div>

<input name="token" type="hidden" id="token" value="<?php echo $token?>" />

<div class="pictures">
    <?php 
    foreach($pictures as $pic){
        $picdata['pic_id'] = $pic['pic_id'];
        $picdata['picPath'] = $pic['path']."/photo_100".$pic['ext'];
        $picdata['statu'] = null;
        $this->load->view('manage/single_photo_view', $picdata);
        
    }
    ?>
</div>
</div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" id="addPhotoBut" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_add_selected')?>" value="<?php echo lang('but_add_selected')?>" disabled="disabled" />
  </div>    
</form>