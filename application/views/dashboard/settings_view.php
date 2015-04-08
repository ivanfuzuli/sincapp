<div class="modal fade">
   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_settings')?></h3>
  </div>

  <div class="modal-body">
      <div class="row">
            <div class="span6" id="dialog_alert"></div>
      </div>
      <div class="row">
          <div class="span2">
              <ul class="nav nav-tabs nav-stacked ">
                  <li class="active"><a href="#emailTab" data-toggle="tab"><?php echo lang('str_change_email')?></a></li>
                  <li><a href="#passTab" data-toggle="tab"><?php echo lang('str_change_password');?></a></li>
              </ul>
          </div>
          <div class="span4 tab-content">         
            <div id="emailTab" class="tab-pane active">
                <form name="email_change" id="email_change" method="post" action="#" data-action="<?php echo base_url()?>dashboard/email_change" class="well">
                    <label for="set_email"><?php echo lang('str_email');?></label><input id="set_email" name="email" type="text" class="log_input" value="<?php echo $email?>"/>
                    <label for="old_password1"><?php echo lang('str_password');?></label><input id="old_password1" type="password" name="password" class="log_input" />
                    <input type="submit" data-loading-text="<?php echo lang('str_please_wait');?>" data-complete-text="<?php echo lang('but_change_email');?>" value="<?php echo lang('but_change_email');?>" class="btn btn-primary" />
                </form>
            </div>
            <div id="passTab" class="tab-pane">
                <form name="pass_change" id="pass_change" method="post" action="#" data-action="<?php echo base_url()?>dashboard/pass_change" class="well">
                    <label for="old_password"><?php echo lang('str_old_pass');?></label><input name="old_password" id="old_password" type="password" class="log_input" />
                    <label for="new_password"><?php echo lang('str_new_pass');?></label><input name="new_password" id="new_password" type="password" class="log_input" />
                    <label for="re_new_password"><?php echo lang('str_re_new_pass');?></label><input name="re_new_password" id="re_new_password" type="password" class="log_input" />
                    <input type="submit" data-loading-text="<?php echo lang('str_please_wait');?>" data-complete-text="<?php echo lang('but_change_pass');?>" value="<?php echo lang('but_change_pass');?>" class="btn btn-primary" />
                </form>
            </div>
          </div>
      </div>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button>
  </div>
                         

</div>
