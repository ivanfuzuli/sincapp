<form class="modal fade" name="documentForm" id="documentForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Dökümanlar</h3>
  </div>
    <div class="modal-body">
<div class="uploading-area" id="uploadPhoto">
    <div id="swfupload-control">
	<input type="button" id="button" />
    </div>
<span id="upload-tip"><?php echo lang('str_upload_tip')?></span>
<?php echo "<span id=\"upload-quota\">Toplam: ".format_size_units($package->storage * 1024 * 1024)."'lık alanının ".format_size_units($storage_quota * 1024)."'i (%".$storage_percentage.") kullanılıyor.</span>";?>

</div>

<input name="token" type="hidden" id="token" value="<?php echo $token?>" />

<div class="files">
  <table class="table table-striped" id="documentTable">
    <thead>
      <tr>
        <th>İsim</th>
        <th>Uzantı</th>
        <th>Boyut</th>
        <th>İşlem</th>
      </tr>
    </thead>
    <tbody class="table-files">
    <?php if($files):?>
    <?php foreach($files as $file):
      $data = array(
          'document_id' => $file->id,
          'name' => $file->name,
          'ext' => $file->ext,
          'file_size' => $file->file_size,
          'selected' => FALSE
        );
      $this->load->view('manage/single_file_view', $data);
    ?>
    <?php endforeach;?>
    <?php endif;?>
    </tbody>
  </table>
</div>
</div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" id="addDocumentBut" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_add_selected')?>" value="<?php echo lang('but_add_selected')?>" disabled="disabled" />
  </div>    
</form>