<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('title_dashboard');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link rel="shortcut icon" href="<?php echo base_url()?>/files/css/fav.ico" />
</head>
<body>
<?php echo $header?>
<div class="container">
    <div class="row">
        <div class="span8">
            <div class="well">
                <h4><?php echo lang('str_my_sites');?></h4>
                <a href="#" class="btn btn-success" id="add_site_but"><?php echo lang('but_add_site');?></a>
                <form class="form-inline hide" id="addSiteForm" data-action="<?php echo base_url()?>dashboard/add_site_do">
                    <div class="input-prepend input-append">
                        <span class="add-on">http://</span><div class="placeholding-input"><input class="input-medium" name="sitename" type="text" /><span class="placeholder"><?php echo lang('str_sitename')?></span></div><span class="add-on">.sincapp.com/</span>
                    </div>
                    <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_add_site_do')?>" value="<?php echo lang('but_add_site_do')?>" />
                </form>
                <div id="addSiteAlert"></div>
                <div id="sites_area">
                    <?php echo $sites_view?>
                </div>
            </div>
        </div>
        <div class="span4" id="feedbacks">
            <h4 class="white"><?php echo lang('str_feedback')?></h4>
            <form id="feedbackForm" name="feedbackForm" method="post" data-action="<?php echo base_url()?>dashboard/feedback/" action="#">      
                <div id="feedAlert"></div>
                <span id="feedbackTextareaOverlay">
                    <textarea name="feed" id="feedbackTextarea"></textarea>
                    <input type="submit" id="feedbackSendBut" class="btn"  data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_send_feed')?>" value="<?php echo lang('but_send_feed')?>" />
                </span>
            </form>
        </div>
    </div>        
<?php echo $footer?>
</div>
<script type="text/javascript">
    var version = "<?php echo VERSION?>", require = {urlArgs:"js_v="+version }, _token = "<?php echo $this->security->get_csrf_hash()?>";    
</script>
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js?v=<?php echo VERSION?>"></script>
</body>
</html>
