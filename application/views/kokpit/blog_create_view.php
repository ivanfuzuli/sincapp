<form class="form-horizontal" method="post" action="<?php echo base_url()?>kokpit/blog/post">
      <div class="span6">
      <img src="<?php echo $picPath?>">
    </div>
    <div class="span6">
      <input type="text" name="title" id="inputTitle" class="span6" placeholder="Başlık"><br>
      <textarea name="post" id="inputPost" class="span8" placeholder="Yazı"></textarea><br>
      <input type="hidden" name="photo_path" value="<?php echo $photo_path?>">
      <input type="hidden" name="photo_ext" value="<?php echo $photo_ext?>">

      <button type="submit" class="btn btn-primary">Kaydet</button>
    </div>
</form>