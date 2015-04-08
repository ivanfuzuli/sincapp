<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Editor - Sincapp</title>
<link rel="shortcut icon" href="<?php echo base_url()?>files/css/fav.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/editor.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link rel="stylesheet" type="text/css" href="<?php echo CDN?>themes/<?php echo $css?>/css/default.css?v=<?php echo VERSION?>" />

</head>
<body>
<div id="loading" class="label label-warning"><?php echo lang('str_loading')?></div>
<div id="black_area"></div>
    <div id="fixed">
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">Sincapp</a>
    <div class="brand">
      <div id="lang-select"><img src="<?php echo base_url() . "files/img/" . $lang_switch_img . ".png"?>"></div>
    </div>
    <div class="brand" id="page-switcher-div">
      <?php echo $pages_switcher;?>
    </div>
    <ul class="nav">
      <li><a href="<?php echo base_url()?>dashboard/">Panel</a></li>
      <li class="active" id="but-editor"><a href="#">Editor</a></li>
      <li><a href="<?php echo base_url()."manage/theme/index/".$site_id?>"><?php echo lang('but_select_thema')?></a></li>    
      <li class="active" id="but-blog" style="display:none"><a href="#">Blog</a></li>
    </ul>
<button class="btn dropdown-toggle pull-right" data-toggle="dropdown" id="extraBut"><i class="icon-cog"></i></button>
    <ul class="dropdown-menu top-right pull-right">
        <li><a href="#" id="settingsBut"><i class="icon-wrench"></i> Ayarlar</a></li>
        <li><a href="#" id="socialBut"><i class="icon-thumbs-up"></i> Sosyal Medya</a></li>
        <li><a href="<?php echo base_url()?>dashboard/logout"><i class="icon-off"></i> Çıkış</a></li>
    </ul>
    <a href="<?php echo $site_url?>" target="_blank" class="btn btn-primary pull-right">Canlı Site</a>
    <a href="#" id="pagesBut" class="btn btn-primary pull-right">Sayfalar</a>
    <?php if(!$is_premium && 1 == 0)://disable buy button?>
    <a href="#" data-action="<?php echo base_url()?>/dashboard/domain/<?php echo $site_id?>" data-loading-text="Lütfen Bekleyin" data-complete-text="Satın Al" class="buy-but btn btn-success pull-right">Satın Al</a>  
    <?php endif;?>
  </div>
</div>
    <?php echo $pages_editor?>
<div id="dragHelp"><span class="label label-info">Lütfen biraz daha aşağıdaki beyaz alana sürükleyip bırakın.</span></div>

    </div>
<div id="scroll-area">
  <div id="scrollnav">
    <div id="scrollnav-content">
    <ul>
      <li class="active-scroll"><a id="btn-basic" href="#basic-menu" data-target="basic" class="scrollto"><i class="fa fa-indent"></i></a></li>
      <li><a id="btn-arch" href="#arch-menu" data-target="arch" class="scrollto"><i class="fa fa-bars"></i></a></li>
      <li><a id="btn-media" href="#media-menu" data-target="media" class="scrollto"><i class="fa fa-file"></i></a></li>
      <li><a id="btn-blog" href="#blog-menu" data-target="blog" class="scrollto"><i class="fa fa-pencil"></i></a></li>

    </ul>
  </div>
  </div>
  <div id="left-area">
  <div id="left-content">
      <div id="basic-menu">
      <div class="left-header">TEMEL</div>
          <ul>
              <li class="dragMe" ext_type="paragraphs"><i class="iconWhite fa fa-indent fa-3x"></i><span>PARAGRAF</span></li>
              <li class="dragMe" ext_type="photo_cloud"><i class="iconWhite fa fa-camera fa-3x"></i><span>F. ALBÜMÜ</span></li>
              <li class="dragMe" ext_type="slider_cloud"><i class="iconWhite fa fa-caret-square-o-right fa-3x"></i><span>SLİDER</span></li>
              <li class="dragMe" ext_type="maps"><i class="iconWhite fa fa-map-marker fa-3x"></i><span>HARİTA</span></li>
              <li class="dragMe" ext_type="forms"><i class="iconWhite fa fa-comments fa-3x"></i><span>FORM</span></li>
              <li class="dragMe" ext_type="htmls"><i class="iconWhite fa fa-file-code-o fa-3x"></i><span>HTML/JS</span></li>
          </ul>
      </div>
      <div class="clearfix"></div>
      <div id="arch-menu">
      <div class="left-header">MİMARİ</div>
          <ul>
              <li class="dragMe" ext_type="menu"><i class="iconWhite fa fa-bars fa-3x"></i><span>YAN MENÜ</span></li>
          </ul>    
      </div>
      <div class="clearfix"></div>      
      <div id="media-menu">
      <div class="left-header">MEDYA</div>
          <ul>
              <li class="dragMe" ext_type="documents"><i class="iconWhite fa fa-file fa-3x"></i><span>DÖKÜMAN</span></li>
          </ul>    
      </div>      
      <div class="clearfix"></div>
      <div id="blog-menu">
      <div class="left-header">BLOG</div>
          <ul>
              <li class="dragMe" ext_type="blog_cloud"><i class="iconWhite fa fa-pencil fa-3x"></i><span>BLOG</span></li>
          </ul>    
      </div>      
      <div class="clearfix"></div>
      <div class="scroll-bottom"></div>    
  </div>
  </div>
</div>

<div id="right-area">
  <?php echo $theme?>
</div>
<div id="modal"></div>
<script type="text/javascript">
var version = "<?php echo VERSION?>", base_url = "<?php echo base_url()?>", site_id = "<?php echo $site_id?>", prefix = "<?php echo $prefix?>", page_id = "<?php echo $page_id?>", language_setup = <?php echo $language_setup?>, tour = "<?php echo $tour?>", _token = "<?php echo $this->security->get_csrf_hash()?>";
var require = {
    urlArgs : "js_v=" + version
};
</script>
<script data-main="<?php echo base_url()?>files/js/app/main.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js?v=<?php echo VERSION?>"></script>
<?php $this->load->view('analytics_view')?>
</body>
</html>
