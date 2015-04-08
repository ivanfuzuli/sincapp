<?php echo $tour?>
<div id="black_area"></div>    

<div id="contextMenu">
    <a href="#" id="contextCut"><?php echo lang('context_cut')?></a>
    <a href="#" id="contextCopy"><?php echo lang('context_copy')?></a>
    <a href="#" id="contextPaste"><?php echo lang('context_paste')?></a>
</div>
<div id="photoTools" class="btn-group">
    <button id="resizePhoto" title="<?php echo lang('but_resize')?>" class="btn"><i class="icon-resize-full"></i></button>
    <button id="leftPhoto" title="<?php echo lang('but_just_left')?>" class="btn"><i class="icon-align-left"></i></button>
    <button id="rightPhoto" title="<?php echo lang('but_just_right')?>" class="btn"><i class="icon-align-right"></i></button> 
</div>
    <div id="fixed">    
        <div id="bar">
            <ul id="barLeft">
                <li id="paragraph_but" class="dragMe" ext_type="paragraphs"><span><?php echo lang('but_paragraph')?></span></li>
                <li id="photo_but" class="dragMe" ext_type="photo_cloud"><span><?php echo lang('but_photos')?></span></li>
                <li id="slider_but" class="dragMe" ext_type="slider_cloud"><span><?php echo lang('but_slider')?></span></li>
                <li id="form_but" class="dragMe" ext_type="forms"><span><?php echo lang('but_forms')?></span></li>
                <li id="maps_but" class="dragMe" ext_type="maps"><span><?php echo lang('but_maps')?></span></li>
                <li id="html_but" class="dragMe" ext_type="htmls"><span><?php echo lang('but_html')?></span></li>                
<!-- 
                <li id="t_add_but" class="clickMe"><span><?php echo lang('but_entries')?></span>
                    <ul id="e_ul">
                        <li id="entry_but" class="dragMe" ext_type="entries"><span><?php echo lang('but_entry')?></span></li>                
                        <li id="archive_but" class="dragMe" ext_type="blog_archive"><span><?php echo lang('but_archive')?></span></li>                
                        <li id="tag_but" class="dragMe" ext_type="tag_cloud"><span><?php echo lang('but_tag_cloud')?></span></li>                

                    </ul>
                </li>   
-->
            </ul>               
            <div id="barRight">                
                <div class="btn-group">
                          <button class="btn btn-primary" id="pagesBut" data-toggle="button"><?php echo lang('but_pages')?></button>
                          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                          <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo base_url()."manage/theme/index/".$site_id?>"><i class="icon-eye-open"></i><?php echo lang('but_select_thema')?></a></li>
                            <li><a href="#" id="settingsBut"><i class="icon-wrench"></i> <?php echo lang('but_settings')?></a></li>
                            <li><a href="<?php echo base_url()?>dashboard/logout"><i class="icon-off"></i> <?php echo lang('but_log_out')?></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url()?>dashboard/"><i class="icon-home"></i> Panel'e Dön{tr}</a></li>
                          </ul>
                </div> 
            </div>            
        </div>       
        <div id="toolbar" class="hide">
          <div  class="toolbuts"> 
              <div class="btn-group">
                  <button class="btn dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('but_font_type')?>"><i class="icon-font"></i><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                      <li><a id="bar_arial" href="#">Arial</a></li>
                      <li><a id="bar_courior" href="#">Courior</a></li>
                      <li><a id="bar_georgia" href="#">Georgia</a></li>
                      <li><a id="bar_helvetica" href="#">Helvetica</a></li>
                      <li><a id="bar_impact" href="#">Impact</a></li>
                      <li><a id="bar_times" href="#">Times</a></li>
                      <li><a id="bar_verdana" href="#">Verdana</a></li>
                  </ul>
              </div>
              <div class="btn-group">
                  <button class="btn dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('but_font_size')?>"><i class="icon-text-height"></i><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                        <li><a href="#" id="bar_xmini" unselectable="on"><?php echo lang('but_font_xsmall')?></a></li>
                        <li><a href="#" id="bar_mini" unselectable="on"><?php echo lang('but_font_small')?></a></li>
                        <li><a href="#" id="bar_normal" unselectable="on"><?php echo lang('but_font_normal')?></a></li>
                        <li><a href="#" id="bar_max" unselectable="on"><?php echo lang('but_font_large')?></a></li>
                        <li><a href="#" id="bar_xmax" unselectable="on"><?php echo lang('but_font_xlarge')?></a></li>              
                  </ul>
              </div> 
              <div class="btn-group">
                  <button class="btn" id="bar_bold" title="<?php echo lang('but_bold')?>"><i class="icon-bold"></i></button>
                  <button class="btn" id="bar_italic" title="<?php echo lang('but_italic')?>"><i class="icon-italic"></i></button>  
                  <button class="btn" id="bar_underline" title="<?php echo lang('but_underline')?>"><i class="icon-underline"></i></button>                                
              </div>
              <div class="btn-group">
                  <button class="btn" id="bar_left" title="<?php echo lang('but_just_left')?>"><i class="icon-align-left"></i></button>
                  <button class="btn" id="bar_center" title="<?php echo lang('but_just_center')?>"><i class="icon-align-center"></i></button>
                  <button class="btn" id="bar_right" title="<?php echo lang('but_just_right')?>"><i class="icon-align-right"></i></button>
                  <button class="btn" id="bar_full" title="<?php echo lang('but_just_full')?>"><i class="icon-align-justify"></i></button>              
              </div>
              <div class="btn-group">
                  <button class="btn dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('but_add_link')?>"><i class="icon-globe"></i><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                      <li><a id="bar_link" href="#"><?php echo lang('but_add_link')?></a></li>
                      <li><a id="bar_unlink" href="#"><?php echo lang('but_unlink')?></a></li>
                  </ul>
              </div>
              <div class="btn-group">
                  <button class="btn" id="bar_photo" title="<?php echo lang('but_add_photo')?>"><i class="icon-picture"></i></button>
                  <button class="btn" id="bar_list" title="<?php echo lang('but_add_list')?>"><i class="icon-list"></i></button>              
              </div>
              <div class="btn-group">
                  <button class="btn" id="bar_html" title="<?php echo lang('but_edit_html')?>"><i class="icon-edit"></i></button>
                  <button class="btn" id="bar_unstyle" title="<?php echo lang('but_unstyle')?>"><i class="icon-remove"></i></button>                
              </div>
              <div class="btn-group">
                  <a id="bar_cancel" class="btn btn-danger">İptal</a>
                  <a id="bar_save" class="btn btn-success">Kaydet</a>
              </div>
          </div>
        </div>         
        <?php echo $pages_editor?>
        <div id="urlBar"><a href="<?php echo $site_url?>" target="_blank"><?php echo $site_url?></a></div>
    </div>

<?php echo $theme?>
<div id="modal"></div>
