<form class="modal fade" name="fieldsForm" id="fieldsForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_form_title')?></h3>
  </div>
  <div class="modal-body">
    
<ul class="nav nav-tabs">
    <li class="active"><a href="#formEditBasic" data-toggle="tab"><?php echo lang('but_basic_tab')?></a></li>
    <li><a href="#formEditAdvanced" data-toggle="tab"><?php echo lang('but_advanced_tab')?></a></li>
</ul>

<div class="tab-content">
<div id="formEditBasic" class="tab-pane active">
    <div class="formEditLeft">
        <strong><?php echo lang('str_tools')?></strong>
        <ul class="nav nav-tabs nav-stacked" id="formEditDragList">
            <li class="dragForm" data-item-type="input"><a href="#"><?php echo lang('but_input_drag')?></a></li>
            <li class="dragForm" data-item-type="textarea"><a href="#"><?php echo lang('but_textarea_drag')?></a></li>
        </ul>
    </div>
        <div class="formEditRight">
            <ul id="formEditDropList">
                <?php foreach($fields as $field){
                    $checked = "";
                    if($field->required == true){
                        $checked = "checked";
                    }
                 ?>
                <li>
                    <input type="text" name="label[]" class="formEditLabel" value="<?php echo $field->label?>"/>
                    <?php if($field->type == "input"):?>
                    <input type="text" type="text" name="type[]" class="span2" disabled="disabled"/>
                    <?php endif;
                     if($field->type == "textarea"):
                    ?>
                     <textarea class="span2" rows="2" name="type[]" disabled="disabled"></textarea>
                    <?php endif;?>
                     <label class="form-label label label-important"><input name="checkbox[]" class="name-checkbox" type="checkbox" value="1" <?php echo $checked?>/> Gerekli</label>
                     <a href="#" class="btn btn-danger btn-mini delete-field"><i class="icon-trash"></i></a>
                     <input type="hidden" name="field_id[]" value="<?php echo $field->form_id?>" />
                     <input type="hidden" class="name-statu" name="statu[]" value="update" />
                     <input type="hidden" class="name-required" name="required[]" value="<?php echo $field->required?>" />
                </li>
                <?php
                }?>
            </ul>
        </div>

</div>
<div id="formEditAdvanced" class="tab-pane">
    <div class="span3">
        <label><?php echo lang('label_email_to')?></label>
        <input type="hidden" name="site_id" value="<?php echo $site_id?>" />        
        <input type="hidden" name="form_id" value="<?php echo $form_cloud_id?>" />
        <input type="text" name="email" value="<?php echo $form_settings->email?>" />
        <label><?php echo lang('label_subject_to')?></label>
        <input type="text" name="subject" value="<?php echo $form_settings->subject?>" />
    </div>
    <div class="span3">    
        <label><?php echo lang('label_str_send')?></label>
        <textarea name="str_send"><?php echo $form_settings->str_send?></textarea>
    </div>
</div>
</div>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_save')?>" value="<?php echo lang('but_save')?>" />
  </div>     
</form>
