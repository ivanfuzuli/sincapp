<?php if(!isset($noParent)):?>
<div class="documentArea">
    <div class="documents" id="document_<?php echo $document_id?>">
<?php endif;?>
        <?php if($file):?>
        <a href="<?php echo $file->path?><?php echo $file->ext?>"><?php echo $file->name . $file->ext?></a>
        <?php else:?>
            Bu alan henüz hiçbir döküman ile ilişkilendirilmemiş.
        <?php endif;?>
<?php if(!isset($noParent)):?>        
    </div>
</div>
<?php endif;?>
