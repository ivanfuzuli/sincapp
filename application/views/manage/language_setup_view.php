<form class="modal fade" name="langSetupForm" id="langSetupForm" data-action="<?php echo base_url()?>manage/language/setup_do">   
  <div class="modal-header">
    <h3>İngilizce Sayfa Ayarları</h3>
  </div>
  <div class="modal-body">
        <div id="setupAlert"></div>
        <input name="site_id" type="hidden" value="<?php echo $site_id?>" />
        <input name="prefix" type="hidden" value="<?php echo $prefix?>" />
        <input name="theme_id" type="hidden" value="0" />
        <h5>Başlık</h5>
        <input name="title" class="span6" type="text" class="setupTextInput" value="<?php echo $settings->title?>" />
        <h5>Açıklama</h5>
        <textarea name="description" class="span6"><?php echo $settings->site_desc?></textarea>
  </div>
  <div class="modal-footer">
    <input type="submit" id="langSetupSubmit" class="btn btn-primary" data-loading-text="Lütfen bekleyin..." data-complete-text="Kaydet" value="Kaydet"/> 
  </div>     
</form>
