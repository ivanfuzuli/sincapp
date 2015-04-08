<input type="hidden" name="prefix" value="<?php echo $prefix?>">

<?php
echo "<ol class=\"sortable\">";
foreach($pages[0] as $page):
    echo "<li id=\"pg_".$page['page_id']."\">
        <div>
            <span class=\"arrow\"></span><span class=\"s_text\">".$page['title']."</span>";
        if($page['hidden']==true){
            echo "<span class=\"pageHiddenIcon\"></span>";
        } 
        if($page['external']==true){
            echo "<span class=\"pageExternalIcon\"></span>";
        } 
        if($page['seo']==true){
            echo "<span class=\"pageSeoIcon\"></span>";
        } 
        echo "<span class=\"s_check\"><input type=\"checkbox\" name=\"page_ids[]\" value=\"".$page['page_id']."\" /></span>
        </div>";
    
    echo "<ol>";
        if(isset($pages[$page['page_id']])){
    
            foreach($pages[$page['page_id']] as $sub_page){
            echo "<li id=\"pg_".$sub_page['page_id']."\">
                <div>
                    <span class=\"arrow\"></span><span class=\"s_text\">".$sub_page['title']."</span>";
                if($sub_page['hidden']==true){
                    echo "<span class=\"pageHiddenIcon\"></span>";
                } 
                if($sub_page['external']==true){
                    echo "<span class=\"pageExternalIcon\"></span>";
                } 
                if($sub_page['seo']==true){
                    echo "<span class=\"pageSeoIcon\"></span>";
                } 
                echo "<span class=\"s_check\"><input type=\"checkbox\" name=\"page_ids[]\" value=\"".$sub_page['page_id']."\" /></span>
                </div>";               
       
     echo "<ol>";

                if(isset($pages[$sub_page['page_id']])){

                    foreach($pages[$sub_page['page_id']] as $sub_two){
                    echo "<li id=\"pg_".$sub_two['page_id']."\">
                        <div>
                            <span class=\"arrow\"></span><span class=\"s_text\">".$sub_two['title']."</span>";
                        if($sub_two['hidden']==true){
                            echo "<span class=\"pageHiddenIcon\"></span>";
                        } 
                        if($sub_two['external']==true){
                            echo "<span class=\"pageExternalIcon\"></span>";
                        } 
                        if($sub_two['seo']==true){
                            echo "<span class=\"pageSeoIcon\"></span>";
                        } 
                        echo "<span class=\"s_check\"><input type=\"checkbox\" name=\"page_ids[]\" value=\"".$sub_two['page_id']."\" /></span>
                        </div>";  
                echo "</li>";        
                    }    
                }
                echo "</ol></li>";        
            }
        }
    echo "</ol>";
    echo "</li>";
endforeach;
echo "</ol>";
?>
