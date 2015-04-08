<?php
if($photos):?>
    <ul class="slides">
    <?php foreach($photos as $photo):?>
        <li id="slide_<?php echo $photo['slider_id']?>">
    	<?php if($photo['link']):?>
    		<a href="<?php echo $photo['link']?>">
    	<?php endif;
        echo "<img src=\"".$photo['path']."/photo_960".$photo['ext']."\" />";
    	if($photo['link']):?>
    		</a>
    	<?php endif;
        if($photo['title']) {
        	echo "<p class=\"flex-caption\">".$photo['title']."</p>";
        	}?>
        </li>
    <?php endforeach;?>
    </ul>

<?php endif?>