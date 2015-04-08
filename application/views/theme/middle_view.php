
<?php //en son ana grid

$lastPar = 0;
foreach ($grids as $grid):
    //eger parentler farkliysa ana grid yarat
    if($lastPar != $grid->parent_sort){
        if($lastPar != 0){
            echo "</div>\n";
        }                 
        echo "<div class=\"container_16\">\n";  
    }
?>              
    <div class="col" style="width: <?php echo $grid->width?>px">
    <?php
    //eklentileri basalim
        if(isset($extensions[$grid->grid_id])){
            foreach($extensions[$grid->grid_id] as $ext){
            $this->load->view('theme/ext_printer', $ext);
            }
        }
    ?>
    </div>
<?php 
$lastPar = $grid->parent_sort;
endforeach;
            //en son ana gridi kapat
echo "</div>\n";
    ?>
