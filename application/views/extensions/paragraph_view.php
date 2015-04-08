<div class="paragragraphArea">
    <div class="paragraphs" id="par_<?php echo $data->paragraph_id?>" <?php if($mode=="admin"):echo "contenteditable=\"true\""; endif;?>>
    <?php if(is_null($data->content) or !$data->content){
        if($mode == "admin")://eger mod adminse goster
            echo "<p><span class=\"par_holder\">".lang('str_click_to_edit')."</span></p>";
        endif;
    }else{
        echo $data->content;
    }
    ?>

    </div>
</div>