<div class="entry" id="entry_edit_<?php echo $entry['entry_id']?>"> 
    <input type="text" class="entryTitleTxt" value="<?php echo $entry['title']?>" />
    <div class="entryContainer">
        <div class="entryBodyTxt editing" id="entryBodyTxt_<?php echo $entry['entry_id']?>" contenteditable="true"> <?php echo $entry['body']?> </div>
        <ul class="tagsContainer">
            <?php foreach($entry['tags'] as $tag){
               echo "<li title=\"".$tag->tag_name."\" id=\"tag_".$tag->tag_id."\">".$tag->tag_name."<span class=\"del_tag\"></span></li>"; 
            }?>
        </ul> 
        <div class="entryButContainer">                       
            <div class="entryLeftContainer">
            <input type="button" class="grey_but entryMore" value="Dev..."  />    <input type="text" class="tagVal" placeholder="Etiket girin..." />
            </div>
            <div class="entryRightContainer">
               <input type="hidden" name="entry_id" class="entry_id" value="<?php echo $entry['entry_id']?>" /><input type="button" class="grey_but entryEditingCancelBut" value="İptal"  /><input type="button" class="red_but entryEditingDelBut" value="Sil"  /><input type="button" class="green_but entryEditingSubmitBut" value="Düzenle"/>        
            </div>          
        </div>
    </div>
</div>