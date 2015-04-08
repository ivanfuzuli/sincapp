<?php
if(!$photos){
    echo lang('str_no_photo_in_cloud');
    return false;
}
foreach($photos as $photo){
	if($photo['title']) {
		$title = "title=\"".$photo['title']."\"";
	} else {
		$title = "";
	}
    echo "<li class=\"thumbPhoto\" id=\"photo_".$photo['photo_id']."\">
            <div class=\"remove_photo\"></div>
            <a href=\"".$photo['path']."/photo_800".$photo['ext']."\" data-lightbox=\"group-1\" $title>
                <img src=\"".$photo['path']."/photo_100".$photo['ext']."\"></img>
            </a>
        </li>";
}