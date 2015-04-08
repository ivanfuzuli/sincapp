<?php header ("Content-Type:text/xml"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach($pages as $page):
    if($page->external == 0)://eger disari gidiyorsa sitemapde olmaz
    ?>
    <url>
    	<?php if(!$page->prefix):?>
        <loc><?php echo base_url().$page->url?>.html</loc>
    	<?php else:?>
        <loc><?php echo base_url(). 'en/' .$page->url?>.html</loc>    	
    	<?php endif;?>
        <lastmod><?php echo date("Y-m-d", $page->lastmod);?></lastmod>
    </url>
<?php 
    endif;
endforeach; ?>
</urlset>     
