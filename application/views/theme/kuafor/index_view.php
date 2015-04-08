<div id="top_hr"></div>
<div id="header">
    <img src="<?php echo CDN?>themes/kuafor/css/hair.jpg">
    <div class="logo-margin">
        <div class="wrapper">
            <?php echo $logo?>
        </div>
    </div>
    <div id="navigation">
        <ul id="nav_bar">
            <?php echo $navigation?>      
        </ul>
    </div>  
        <div id="lang_container">
            <div id="language">
                <?php echo $language_view?>
            </div>
            <div class="clear"></div>
            <div id="social">
                <?php echo $social?>
            </div>  
        </div>
</div>
 
<div class="wrapper">
    <div id="cover-photo">
        <?php if($cover_photo):?>
            <?php echo $cover_photo;?>
        <?php endif;?>
    </div>
</div> 
<div class="wrapper">
    <div id="middle">
       <?php echo $middle?> 
    </div>
</div>

<div id="footer">
    <div class="wrapper">
        <div id="footerText"><?php echo $footer?></div>
    </div>
</div>


