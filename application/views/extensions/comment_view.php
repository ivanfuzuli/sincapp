<div class="comment" id="comment_<?php echo $comment_id?>">
    <div class="commentDel"><div class="commentDelBut"></div></div>
<?php 
if($website){
    $nameWrite = "<a href=\"http://$website\" target=\"_blank\">$name</a>";
}else{
    $nameWrite = $name;
}
echo "<div class=\"commentName\">$nameWrite</div>";
echo "<div class=\"commentDate\">$comment_date</div>";
echo "<div class=\"commentBody\">$comment</div>";
?>
</div>