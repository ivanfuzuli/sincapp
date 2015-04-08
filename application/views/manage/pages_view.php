<div class="pop-dialog hide" id="pages-dialog">
    <div class="pop-tri"></div>
    <div class="pop-inner">
        <div class="pop-content">
            <form class="form-inline pages-well" id="pageAddForm">
                <div class="input-append">
                <div class="placeholding-page-add">
                    <input type="text" name="pagename" class="page-add-input" autocomplete="off" />
                    <span class="placeholder-page-add"><?php echo lang('str_new_page_name')?></span>
                </div><input type="submit" class="btn btn-success" id="pageAddBut" value="<?php echo lang('but_create')?>" />
                </div>
            </form>
            <div class="pages-buts">
            <?php echo lang('str_selected')?> <button class="btn btn-mini" id="seoPageBut"><?php echo lang('but_seo')?></button><button class="btn btn-danger btn-mini" id="delPageBut"><?php echo lang('but_delete')?></button><button class="btn btn-primary btn-mini" id="editPageBut"><?php echo lang('but_edit')?></button>
            </div>
            <!-- delete dialog start -->
            <div class="delete-dialog hide" id="deleteDialog">
                <div class="delete-tri"></div>
                <div class="delete-content">
                    <span><?php echo lang('str_delete_sure')?></span>
                    <div class="btn-group">
                        <button class="btn btn-mini" id="delCancelBut"><?php echo lang('but_no')?></button><button class="btn btn-danger btn-mini" id="delDoBut"><?php echo lang('but_yes')?></button>
                    </div>
                </div>
            </div>
            <!-- delete dialog end -->   
            <div class="clearfix"></div>
            <form name="pagesForm" id="pagesForm" action="#" method="post">
            <?php echo $pages_content?>
            </form>         
        </div>
    </div>
</div>