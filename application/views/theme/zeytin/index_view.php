<div id="header">
    <div id="navigation">
        <div class="wrapper">
            <div class="logo-margin">
                <?php echo $logo?>
            </div>
        </div>
        <ul id="nav_bar">
            <?php echo $navigation?>      
        </ul>
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


