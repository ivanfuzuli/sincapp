<form class="form-inline modal fade" id="delete-site-form" action="#" data-action="<?php echo base_url()?>dashboard/delete_confirm" method="post">
   
  <div class="modal-header">
    <a href="#" class="close" data-dismiss="modal">×</a>
    <h3>Site Silme Onayı</h3>
  </div>

  <div class="modal-body">
      <div id="form-alert"></div>
      <h5>Silme işlemini tamamlamak için aşağıdaki kutucuğa şifrenizi girin.</h5>
      <input type="hidden" name="site_id" value="<?php echo $site_id?>" />
      <p>
          <label>Şifre:</label><input class="span2" type="password" name="password"/>
      </p>
  </div>
  <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>
      <input type="submit" href="#" class="btn btn-danger" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="Siteyi Tamamen Sil!" value="Siteyi Tamamen Sil!" />
  </div>
                         

</form>
