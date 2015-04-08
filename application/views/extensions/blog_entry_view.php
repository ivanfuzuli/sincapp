
<div class="boxLeft">       
        <div class="canBoxPadding">
            <h2 class="hBoxTitle"><?php echo $entry['title']?></h2>
            <?php echo $entry['body'];?>
        </div>
</div>

    <div class="boxRight">
        <div class="canBoxPadding">
         <iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html" style="width:90px; height:20px;"></iframe>
        <iframe src="//www.facebook.com/plugins/like.php?href&amp;send=false&amp;layout=button_count&amp;width=130&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
        
        <form name="commentForm" class="commentForm" method="post" action="#">  
            <div class="boxCommentOverlay">
                <textarea name="comment" class="boxCommentArea required" placeholder="<?php echo lang('str_comment')?>"></textarea>
            </div>
            <ul class="boxHidden">
                <li><input type="text" name="name" class="boxTextInput required" placeholder="<?php echo lang('str_name')?>"/></li>
                <li><input type="text" name="email" class="boxTextInput required" placeholder="<?php echo lang('str_email')?>"/></li>
                <li><label class="boxHttpSpan" for="siteInput">http://</label><input type="text" id="siteInput" name="website" class="boxTextInput boxSiteInput" placeholder="<?php echo lang('str_website')?>"/></li>
                <li><input type="hidden" name="entry_id" value="<?php echo $entry['entry_id']?>" /><input type="submit" class="boxSubmitBut" value="<?php echo lang('str_submit')?>"/></li>

            </ul>
        </form>    
        <div class="comments">
            
            <?php 
            if($comments){
                foreach ($comments as $comment){
                    $this->load->view('extensions/comment_view', $comment);
                }
            }else{
               echo "<span class=\"noComment\">".lang('str_nocomment')."</span>"; 
            }
            ?>
        </div>
    </div>
