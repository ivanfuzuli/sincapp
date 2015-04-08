<?php if(!$ajax):?>
<div class="menuArea" id="menu_<?php echo $menu_id?>">
<?php endif;?>
	<ul class="nav nav-tabs nav-stacked">
<?php if(is_array($pages)):?>
    <?php foreach($pages as $page):
    	if($page->external) {
    		$url = $page->url;
    	} else {
    		if($page->prefix) {
    			$prefix = $page->prefix .'/';
    		} else {
    			$prefix = null;
    		}

    		if($mode == 'admin') {
    			$url = base_url() . 'manage/editor/wellcome/' . $page->site_id . '/' . $prefix . $page->url . '.html';
    		} else {
    			$url = base_url()  . $prefix . $page->url . '.html';
    		}
    	}
    ?>

    	<li id="subPage_<?php echo $page->menu_page_id?>"><a href="<?php echo $url?>"><?php echo $page->title?></a>
            <?php if($mode == 'admin'):?><span class="delete-menu">Sil</span><?php endif?></li>
	<?php endforeach;?>
<?php else:?>
    Bu menü ile ilişkilendirimiş bir sayfa yok.
<?php endif;?>    
	</ul>
<?php if(!$ajax):?>
</div>
<div style="clear: both"></div>
<?php endif;?>