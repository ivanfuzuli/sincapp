<form class="modal fade pages-modal" name="pageEditForm" id="pageEditForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_page_edit')?></h3>
  </div>
  <div class="modal-body">
<?php if($pages == null){echo lang('error_edit_least');}?>      
<table class="table table-striped">
  <thead>
    <tr>
    <th><?php echo lang('str_name')?></th>
    <th><?php echo lang('str_url')?></th>
    <th></th>    
    <th><?php echo lang('str_hidden')?></th>    
    <th>Şifre</th>
    </tr>
  </thead>
  <tbody>  
  <?php foreach($pages as $page):

       if($page->hidden == 0):$switch_hidden = "switch-off"; else: $switch_hidden = ""; endif;
       if($page->external == 0){
           $switch_external = "switch-off"; 
           $switch_input_ext = "";
           $switch_span = "";
       }else{
           $switch_external = "";
           $switch_input_ext = "page_input_ext";           
           $switch_span = "page_hidden";           
       }
       
      ?>

  <tr>
    <td><input type="hidden" name="id[]" value="<?php echo $page->page_id?>"/><input type="text" name="name[]" class="input-small" value="<?php echo $page->title?>"/></td>
    <td>
        <?php if($page->url != "index"):?>
        <div class="switcher">
            <div class="switch-but switch-external <?php echo $switch_external?>" unselectable="on"><span><?php echo lang('str_extarnal')?></span><span class="switch-right"><?php echo lang('str_internal')?></span></div>
        </div>
        <?php endif;?>
        <input type="hidden" name="external[]" firstval="<?php echo $page->external?>" value="<?php echo $page->external?>" />

    </td>
    <td>
        <div class="pageInputCol">
            <input type="<?php if($page->url == "index"): echo "hidden"; else: echo "text"; endif;?>" class="input-small <?php echo $switch_input_ext?>" name="url[]" value="<?php echo $page->url?>"/><?php if($page->url == "index"): echo "index";endif?><span class="<?php echo $switch_span?>">.html</span>
        </div>
    </td>
    <td>    
        <div class="switcher">
            <div class="switch-but switch-hidden <?php echo $switch_hidden?>"  unselectable="on"><span><?php echo lang('str_hide')?></span><span class="switch-right"><?php echo lang('str_show')?></span></div>
            <input type="hidden" name="hidden[]" value="<?php echo $page->hidden?>" />
        </div>
        
    </td>
    <td>
        <input name="password[]" type="password" class="input-small" value="<?php echo $page->password?>">
    </td>
  </tr>
<?php endforeach;?>
</tbody>
</table>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_edit')?>" value="<?php echo lang('but_edit')?>" />
  </div>
                         
</form>
