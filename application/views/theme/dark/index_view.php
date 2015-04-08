<div id="top_hr"></div>
<div id="header">  
    <div class="wrapper">
        <?php echo $logo?>
    </div>
    <div class="wrapper">
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
</div>
<div class="wrapper"> 
    <div id="navigation">
        <ul id="nav_bar">
            <?php echo $navigation?>      
        </ul>
    </div>      
        <div id="cover-photo">
            <?php if($cover_photo):?>
                <?php echo $cover_photo;?>
            <?php endif;?>
        </div>

        <div id="middle">
           <?php echo $middle?> 
        </div>
</div>
<div id="footer">
    <div class="wrapper">
        <div id="footerText"><?php echo $footer?></div>
    </div>
</div>


