<?php 
        // $page['class'] Link o anda aktifse class active olur
        foreach ($pages[0] as $page){
            echo "<li ".$page['class']."><a href=\"".$page['url']."\">".$page['title']."</a>"; 
            //varsa alt sayfalar
            if(isset($pages[$page['page_id']])){
              echo "<ul>";    
                foreach($pages[$page['page_id']] as $sub_page){
                        echo "<li ".$sub_page['class']."><a href=\"".$sub_page['url']."\">".$sub_page['title']."</a>";
                if(isset($pages[$sub_page['page_id']])){
                echo "<ul>";
                    foreach($pages[$sub_page['page_id']] as $page_two){    
                            echo "<li ".$page_two['class']."><a href=\"".$page_two['url']."\">".$page_two['title']."</a></li>";                           
                    }
                echo "</ul>";        
                }
              echo "</li>";
                }
              echo "</ul>";
            }
            echo "</li>";
}?>  