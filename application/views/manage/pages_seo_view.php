<form class="modal fade" name="pageSeoForm" id="pageSeoForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo lang('str_page_edit')?></h3>
  </div>
  <div class="modal-body">
<table class="table table-striped">
  <thead>
  <tr>
    <th><?php echo lang('str_name')?></th>
    <th><?php echo lang('str_seo')?></th>
    <th width="110"><?php echo lang('str_title')?></th>    
    <th width="160"><?php echo lang('str_description')?></th>        
  </tr>
  </thead>
    <tbody>
<?php foreach($pages as $page):
    
           if($page['seo'] == 0):$switch_hidden = "switch-off"; else: $switch_hidden = ""; endif;
           if($page['seo'] == 0):$input_hidden = "style=\"display:none;\""; else: $input_hidden = ""; endif;
           if($page['seo'] == 0):$seo = "0"; else: $seo = "1"; endif;

    ?>  
  <tr>
    <td><?php echo $page['title']?><input type="hidden" name="id[]" value="<?php echo $page['page_id']?>" /></td>
    <td>
        <div class="switcher">
            <div class="switch-but switch-seo <?php echo $switch_hidden?>" unselectable="on"><span><?php echo lang('str_manuel')?></span><span class="switch-right"><?php echo lang('str_auto')?></span></div>
            <input type="hidden" name="seo[]" value="<?php echo $seo?>" />
        </div>
    </td>
    <td><input type="text" name="title[]" class="input-small" <?php echo $input_hidden?> value="<?php echo $page['seo_title']?>"/></td>    
    <td><textarea  name="description[]" class="input-medium" <?php echo $input_hidden?>><?php echo $page['seo_description']?></textarea></td>    
    
  </tr>
<?php endforeach;?>
    </tbody>
</table>
</div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?php echo lang('but_close')?></a>      
    <input type="submit" class="btn btn-primary" data-loading-text="<?php echo lang('str_please_wait')?>" data-complete-text="<?php echo lang('but_seo_do')?>" value="<?php echo lang('but_seo_do')?>" />
  </div>    
</form>