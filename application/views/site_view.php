<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title?></title>
<meta name="description" content="<?php echo $page_description?>" />

<link rel="stylesheet" type="text/css" href="<?php echo CDN?>css/build/general.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link rel="stylesheet" type="text/css" href="<?php echo CDN?>themes/<?php echo $css?>/css/default.css?v=<?php echo VERSION?>" />

<?php echo $main_settings['header_code']?>
</head>
<body>
    <?php echo $theme?>
<?php if(!$is_premium):?>
<div id="bottom-bar">
	<div class="bottom-left">Ücretsiz Site Yap</div>
	<div class="bottom-arrow"></div>
	<div class="bottom-right">Sincapp ile yapılmıştır.</div>
</div>
<div id="bottom-content" class="hide">
		<div>Kendi sitenizi hiçbir teknik bilgiye gereksinim duymadan kolayca yapabilirsiniz.</div>
	<a href="https://www.sincapp.com/">Ücretsiz Üye OL!</a>
</div>
<?php endif;?>
<?php echo $main_settings['footer_code']?>
<script type="text/javascript">
    var version = "<?php echo VERSION?>", require = {urlArgs:"js_v="+version }, prefix = "<?php echo $prefix?>";    
</script>
<script data-main="<?php echo CDN?>js/app/site.<?php echo ENVIRONMENT?>.js" src="<?php echo CDN?>js/app/require.js?v=v=<?php echo VERSION?>"></script>
<?php echo $metrica?>    
</body>
</html>