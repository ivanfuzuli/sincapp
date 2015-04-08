<div id="top_hr"></div>

<div class="wrapper">
    <div id="header" class="container_16">
        <?php echo $logo?>
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
    <div id="navigation" class="container_16">
        <ul id="nav_bar">        
        <?php echo $navigation?>
        </ul>
    </div>
</div>
<div class="wrapper">
    <div id="cover-photo" class="container_16">
        <?php if($cover_photo):?>
            <?php echo $cover_photo;?>
        <?php endif;?>
    </div>
    <div id="middle" class="container_16">
       <?php echo $middle?>         
    </div>
    <div id="footer" class="container_16">
        <div id="footerText"><?php echo $footer?></div>    
    </div>
</div>
<div id="bottom"></div>