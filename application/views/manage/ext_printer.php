<?php
//theme klasöründe de benzeri var tikkat tikkat
if($ext_icon_class != false && !is_array($ext_icon_class)){
    $ext_icon = "<div class=\"$ext_icon_class\"></div>";
}else{
    $ext_icon = "";
}

if(is_array($ext_icon_class)) {
	foreach ($ext_icon_class as $value) {
		$ext_icon .= "<div class=\"$value\"></div>";
	}
}
echo "<div class=\"ext\" id=\"ext_$ext_id\">";

    //extension görünmez başlık
    echo "<div class=\"ext_bar\">
            <h2 class=\"ext_title\"><div class=\"ext_icon\"></div> $ext_title</h2>
            <div class=\"ext_delete\"></div>$ext_icon
         </div>";

    print_r( $ext_html);
    echo "</div>";