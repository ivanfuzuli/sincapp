<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lang('str_theme_title')?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css" />

</head>

<body>
<div id="themeTopBar">
    
    <ul class="nav nav-tabs">
        <li><a href="<?php echo base_url()?>dashboard/"><?php echo lang('but_home')?></a></li>
        <li><a href="<?php echo base_url()."manage/editor/wellcome/".$site_id?>"><?php echo lang('but_editor')?></a></li>
        <li class="active"><a href="#"><?php echo lang('but_theme')?></a></li>
        <li><a href="<?php echo base_url()?>dashboard/logout"><?php echo lang('but_logout')?></a></li>       
    </ul>
     <ul  class="thumbnails">
        <?php foreach($themes as $theme){
            if($theme->theme_id == $theme_id){
               $themeSelected = "btn-success"; 
            }else{
               $themeSelected = "";
            }
            
           echo "<li>
                    <div class=\"thumbnail\">
                        <img src=\"".CDN."themes/".$theme->theme_css."/screen-mini.jpg\" />
                        <a class=\"btn btn-mini selectBut ".$themeSelected."\" target=\"site-frame\" href=\"".base_url()."manage/theme/select/".$site_id."/".$theme->theme_id."\">".lang('but_select')."</a>
                        <a class=\"btn btn-mini btn-primary glassBut\" href=\"".CDN."themes/".$theme->theme_css."/screen.jpg\">".lang('str_preview')."</a>

                    </div>
                </li>";
        }?>
        </ul>
</div>
    <div id="theme-frame">
        <iframe name="site-frame" id="ifm" border="0" frameborder="0" width="100%" src="<?php echo $site_url?>"></iframe>
    </div>
<script tyle="text/javascript">
var buffer = 20; //scroll bar buffer
var iframe = document.getElementById('ifm');

function pageY(elem) {
    return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
}

function resizeIframe() {
    var height = document.documentElement.clientHeight;
    height -= pageY(document.getElementById('ifm'))+ buffer ;
    height = (height < 0) ? 0 : height;
    document.getElementById('ifm').style.height = height + 'px';
}

// .onload doesn't work with IE8 and older.
if (iframe.attachEvent) {
    iframe.attachEvent("onload", resizeIframe);
} else {
    iframe.onload=resizeIframe;
}
window.onresize = resizeIframe;
</script>
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js"></script>

</body>
</html>