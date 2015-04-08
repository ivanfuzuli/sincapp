<?php if($selected == TRUE) {
	$class = ' class="success"';
	$btn_class = 'btn-success';
} else {
	$class = '';
	$btn_class = '';
}
?>
<tr <?php echo $class?> id="file_<?php echo $document_id?>">
	<td contenteditable="true" class="rename-document" data-id="<?php echo $document_id?>"><?php echo $name?></td>
	<td><?php echo $ext?></td>
	<td><?php echo $file_size?> KB</td>
	<td>
		<a href="#" class="btn <?php echo $btn_class?> select-document" data-id="<?php echo $document_id?>">Seç</a>
		<a href="#" class="btn btn-danger remove-document" data-id="<?php echo $document_id?>">Sil</a>
	</td>
</tr>