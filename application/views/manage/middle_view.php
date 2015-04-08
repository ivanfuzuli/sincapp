<table class="grids">
    <tr>
        <td id="firstGrid"></td>
        <td class="dividerTd hideDivider">
            <div class="mergeMe"></div>
            <div class="dividerDrag"><div></div></div>
        </td>
    </tr>
</table>
<?php //en son ana grid
$lastPar = 0;
foreach ($grids as $grid):
    //eger parentler farkliysa ana grid yarat
    if($lastPar != $grid->parent_sort){
        if($lastPar != 0){
            echo "</tr>\n";
        }                 
        echo "<table class=\"grids\"><tr class=\"parent_grid\">\n";  
    }
?>              
    <td class="grid" id="grid_<?php echo $grid->grid_id?>" style="width: <?php echo $grid->width?>px">
    <?php
    //eklentileri basalim
        if(isset($extensions[$grid->grid_id])){
            foreach($extensions[$grid->grid_id] as $ext){
            $this->load->view('manage/ext_printer', $ext);
            }
        }
    ?>
    </td>
    <td class="dividerTd">
        <div class="mergeMe"></div>
        <div class="dividerDrag"><div></div></div>
    </td>
<?php 
$lastPar = $grid->parent_sort;
endforeach;
            //en son ana gridi kapat
echo "</tr></table>\n";
    ?>
<table class="grids">
    <tr>
        <td id="lastGrid"></td>
    </tr>
</table>    