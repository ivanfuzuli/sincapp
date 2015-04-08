<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lang('str_reset_title')?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/static/forgot.css" />

</head>
<body>
    <div class="forgot-div"> 
        <div id="logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>/files/css/images/logo.png" border="0"/></a></div>        
    <div class="span4">  
        <?php echo $alert?>
        <form method="post" id="pass-change-form" class="well" action="<?php echo base_url()?>forgot/send">
            <h4><?php echo lang('str_reset_title')?></h4>
            <label><?php echo lang('str_validate_code')?></label><input type="text" name="token" value="<?php echo $token?>" /><br />
            <div class="placeholding-input"><input type="password" name="password" /><span class="placeholder"><?php echo lang('str_new_pass')?></span></div>
            <br />
            <div class="placeholding-input"><input type="password" name="repassword" /><span class="placeholder"><?php echo lang('str_re_new_pass')?></span></div>
            <br />
            <input type="submit" class="btn btn-primary" value="<?php echo lang('but_change')?>" />
        </form>
    </div>    
    </div>        
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js"></script>

</body>
</html>