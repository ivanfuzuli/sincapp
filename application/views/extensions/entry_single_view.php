    <div class="entry" id="entry_<?php echo $entry['entry_id']?>">
        <div class="entryDelEdit"><div class="entryEditBut"></div><div class="entryDelBut"></div></div>
        <a href="<?php echo base_url().'post/'.$entry['url']?>.html" class="entryTitle"><?php echo $entry['title']?></a><div class="content_count"><span><?php echo $entry['comment_count']?></span></div>
        <div class="clearfix"></div>
        <div class="e_info">Can tarafından <?php echo $entry['entry_date']?> 'de gönderildi.{tr}</div>        
        <div class="entryBody"><?php echo $entry['body']?></div>
        <?php foreach($entry['tags'] as $tag){
           echo "<a href=\"\">".$tag->tag_name."</a> "; 
        }?>
        <div class="theSocial"></div>

    </div>