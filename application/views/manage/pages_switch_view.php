<select id="page-switcher">
<?php
foreach($pages[0] as $page):
        $selected = false;
        if($page['external']==false){
            if($page['page_id'] == $page_id) $selected = 'selected';
            echo "<option value=\"".$page['url']."\" ".$selected.">".$page['title']."</option>";
        }
        if(isset($pages[$page['page_id']])){
            foreach($pages[$page['page_id']] as $sub_page){
                $selected = false;
                if($sub_page['external']==false){
                    if($sub_page['page_id'] == $page_id) $selected = 'selected';
                    echo "<option value=\"".$sub_page['url']."\" ".$selected.">->".$sub_page['title']."</option>";
                }            
                if(isset($pages[$sub_page['page_id']])){
                    foreach($pages[$sub_page['page_id']] as $sub_two){
                        $selected = false;
                        if($sub_two['external']==false){
                        if($sub_two['page_id'] == $page_id) $selected = 'selected';
                        echo "<option value=\"".$sub_two['page_id']."\" ".$selected.">-->".$sub_two['title']."</span>";
                        }      
                    }    
                }      
            }
        }
endforeach;
?>
</select>