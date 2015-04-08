<form class="modal fade" name="pageEditForm" id="pageEditForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_settings_title')?></h3>
  </div>
  <div class="modal-body">
    <div id="settingsLog"></div>
    <label><?php echo lang('str_site_title')?></label>
    <input type="text" class="span6" name="title" maxlength="255" value="<?php echo $title?>"/>    
    <label><?php echo lang('str_site_desc')?></label>    
        <textarea class="span6" name="site_desc"><?php echo $site_desc?></textarea>    
    <hr />
    <label><?php echo lang('str_header_code')?></label>
    <textarea class="span6" name="header_code"><?php echo $header_code?></textarea>    
    <label><?php echo lang('str_footer_code')?></label>
    <textarea class="span6" name="footer_code"><?php echo $footer_code?></textarea>
    <input type="hidden" name="site_id" value="<?php echo $site_id?>"/>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_save')?>" value="<?php echo lang('but_save')?>" />
  </div>
                         
</form>
