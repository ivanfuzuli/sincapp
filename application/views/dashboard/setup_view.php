<form method="post" action="#" class="modal fade" id="themeForm" data-action="<?php echo base_url()?>dashboard/setup_do">      
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3><?php echo lang('str_setup_wizard')?></h3>
  </div>
    <div class="modal-body">
        <div id="setupAlert"></div>
        <input name="site_id" type="hidden" value="<?php echo $site_id?>" />
        <input name="theme_id" type="hidden" value="0" />
        <h5><?php echo lang('str_site_title')?></h5>
        <input name="title" class="span6" type="text" class="setupTextInput" />
        <h5><?php echo lang('str_site_desc')?></h5>
        <textarea name="description"  class="span6"></textarea>
        <h5><?php echo lang('str_select_theme')?></h5>
        <ul class="thumbnails">
        <?php foreach($themes as $theme):
            echo "<li class=\"thumbnail\">
                            <img src=\"".CDN."themes/".$theme->theme_css."/screen-mini.jpg\" />
                            <div class=\"caption\">
                            <h5>".$theme->theme_name."</h5>
                            <p id=\"themes\">
                                <a class=\"themeSelectBut btn\" data-themeid=\"".$theme->theme_id."\" href=\"#\">".lang('but_select')."</a>
                                <a class=\"themeGlassBut btn btn-info\" href=\"".CDN."themes/".$theme->theme_css."/screen.jpg\"> ".lang('but_preview_theme')."</a>
                            </p>
                            </div>
            </li>";    

        endforeach;
        ?>
        </ul>
    </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button>
      <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_finish_setup')?>" value="<?php echo lang('but_finish_setup')?>"/> 
      
  </div>
</form>
                         
    