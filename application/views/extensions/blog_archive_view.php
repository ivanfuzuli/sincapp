<?php echo "<h3>".lang('str_blog_archive') ."</h3>";

foreach($data as $dt){
    $month = "month".date("m", strtotime($dt->entry_date));
    $month = lang($month);
    echo $month.' ('.$dt->total.') <br />';
}