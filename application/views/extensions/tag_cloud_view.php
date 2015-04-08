<?php
echo "<h3>".lang('str_tag_cloud')."</h3>";
echo "<div class=\"tagCloud\">";

$maximum = $data['max_size'];

foreach($data['tags'] as $tag){
    $percent = floor(($tag->tag_count / $maximum) * 100);    //yüzdelik dilimi
    
 // determine the class for this term based on the percentage
 if ($percent < 20):
   $class = 'smallest';
 elseif ($percent >= 20 and $percent < 40):
   $class = 'small';
 elseif ($percent >= 40 and $percent < 60):
   $class = 'medium';
 elseif ($percent >= 60 and $percent < 80):
   $class = 'large';
 else:
 $class = 'largest';
 endif;
 
    echo "<span class=\"".$class."\"><a href=\"\">".$tag->tag_name."</a> </span>";
}

echo "</div>";