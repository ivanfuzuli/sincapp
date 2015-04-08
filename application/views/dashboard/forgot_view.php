<form class="form-inline modal fade" id="forgot-form" action="#" data-action="<?php echo base_url()?>forgot/rec" method="post">
   
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3><?php echo lang('str_form_title')?></h3>
  </div>

  <div class="modal-body">
      <div id="form-alert"></div>
      <p>
          <label><?php echo lang('str_email_placeholder')?>:</label><input type="text" name="email"/>
      </p>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button>
      <input type="submit" href="#" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_send')?>" value="<?php echo lang('but_send')?>" />
  </div>
                         

</form>
