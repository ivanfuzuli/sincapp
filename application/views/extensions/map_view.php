<?php if($mode == "admin"):?>
<div class="mapSettings">
    <div class="mapBubble">
        <div class="input-append">
            <input type="text" name="adressbar" data-map-id="<?php echo $map_id?>" placeholder="<?php echo lang('holder_map_adress')?>" class="input-medium" /><button class="btn btn-primary mapSearchBut"><?php echo lang('but_map_get')?></button><button data-map-id="<?php echo $map_id?>" id="mapSave_<?php echo $map_id?>" class="btn btn-success mapSaveBut"><?php echo lang('but_map_save')?></button>
        </div>
    </div>
</div>
<?php endif;?>

<div class="maps" id="map_<?php echo $map_id?>" data-latitude="<?php echo $latitude?>" data-longitude="<?php echo $longitude?>" data-zoom="<?php echo $zoom?>">

</div>