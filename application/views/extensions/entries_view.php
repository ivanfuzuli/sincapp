<?php if($updater == true){?>
<div id="entriesArea">
    <div id="new_entry">
    <input tabindex="1" type="text" class="entryTitleTxt" id="entryTitleTxt" placeholder="<?php echo lang('str_entries_placeholder')?>" />
    <div id="entryContainer">
        <div id="entryBodyTxt" class="entryBodyTxt editing" tabindex="2" contenteditable="true"> </div>
        <ul class="tagsContainer" id="tagsContainer"></ul> 
        <div class="entryButContainer">                       
            <div class="entryLeftContainer">
            <input type="button" class="grey_but entryMore" value="<?php echo lang('but_more_tool')?>"  tabindex="6" />    <input type="text" class="tagVal" tabindex="3" placeholder="<?php echo lang('str_enter_tag')?>" />
            </div>
            <div class="entryRightContainer">
               <input type="button" id="cancelEntry" class="grey_but" value="<?php echo lang('but_cancel')?>"  tabindex="5" /><input type="button" class="green_but" id="addEntry" value="<?php echo lang('but_add')?>"  tabindex="4"/>        
            </div>          
        </div>
    </div>
    </div>
 <?php }?>       
<?php foreach($entries as $entry){
    $entry_data = array('entry' => $entry);
    $this->load->view('extensions/entry_single_view', $entry_data);
 }
 
 if($entries != null){
    echo "<a id=\"entriesMore\" start=\"".$start."\" href=\"#\">".lang('but_more')."</a>";
 }?>
</div>