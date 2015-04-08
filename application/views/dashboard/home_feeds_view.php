<ul>
    <?php if(!$feedbacks):echo "Henüz bildirim yok."; endif?>
    <?php foreach($feedbacks as $feed){ 
        $new = "";
        if($feed['read'] == 0): $new = "<span class=\"newFeed\"></span>"; endif;
       echo "<li class=\"feed\" data-feed-url=\"".base_url()."dashboard/thread/".$feed['thread_id']."\"><b>".$feed['email']."</b><br /> ".$feed['message'].$new."</li>"; 
    }?>
</ul>