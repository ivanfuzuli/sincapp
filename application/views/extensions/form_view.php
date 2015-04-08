    <form class="formSend" method="post" action="#" data-captcha="<?php echo base_url()?>refresh.captcha" data-action="<?php echo base_url()?>send.app">
        <?php foreach($fields as $field){
            $requiredY = "";
            $requiredC = "";
            
            if($field->required == true){
                $requiredY = "<span class=\"requiredSpan\"> * </span>";
                $requiredC = "required";
            }
            
            echo "<label for=\"field_$field->form_id\">$field->label $requiredY</label>";
            
            if($field->type == "textarea"){
              echo "<textarea id=\"field_$field->form_id\" name=\"field_$field->form_id\" class=\"$requiredC\" rows=\"3\"></textarea>";  
            }else{
              echo "<input type=\"text\" id=\"field_$field->form_id\" class=\"formInputArea $requiredC\" name=\"field_$field->form_id\"/>";  

            }
            ?>
            <div class="clearfix"></div>
        <?php }?>
        <div style="float: left">
        <img class="captcha" src="<?php echo base_url()?>refresh.captcha">
        </div>
        <div style="float:left">
        <a data-captcha="<?php echo base_url()?>refresh.captcha" href="#" class="refresh_captcha"></a>
        </div>
        <label>Güvenlik Kodu:</label>
        <div class="clearfix"></div>
        <input type="text" name="phrase" />
        <div style="clear: both"></div>
        <div class="phraseError hide" style="color: red;">Güvenlk kodu hatalı.</div>
        <div class="formError"><?php echo lang('err_send_form')?></div>
        <input class="submitForm btn btn-primary" type="submit" value="<?php echo lang('but_send_form')?>" />
    </form>