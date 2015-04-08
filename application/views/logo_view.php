<?php if($ajax == false){?>
<div id="logo" <?php echo $logo_style?>>
<?php }?>
   <?php if($admin == true):?> 
    <ul id="logoButs">
        <li id="logoMoveBut"><span></span></li>
        <li id="logoTextBut"><span></span></li>
        <li id="logoPhotoBut"><span></span></li>
    </ul>
    <?php 
    endif;
    if($ratio == null){?>
    <span id="logoText"><?php echo $logo?></span>
    <?php
    }else{
      echo "<img id=\"logoImg\" src=\"$logo\" ratio=\"$ratio\"/>";      
 }
 
 
if($ajax == false){  
 ?>
</div>
<?php }?>
