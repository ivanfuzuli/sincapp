<form class="modal fade" name="photoSetForm" id="photoSetForm" data-action="<?php echo base_url()?>manage/photo_cloud/set_settings">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Fotoğraf Albümü Ayarları</h3>
  </div>
  <div class="modal-body">
  <div class="alert alert-info"><strong>İpucu:</strong> Silme, yer değiştirme vb. işlemler yaptıktan sonra ayarların aktif olabilmesi için kayıt etmeyi unutmayınız.</div>
  <input type="hidden" name="site_id" value="<?php echo $site_id?>">
  <input type="hidden" name="cloud_id" value="<?php echo $cloud_id?>">

    <table id="sort-slider">
      <thead>
        <tr>
          <th></th>          
          <th>Fotoğraf</th><th>Başlık</th><th>Sil</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($photos as $photo):?>      
      <tr>
        <td><div class="drag-slider"></div></td>
        <td>
            <img src="<?php echo $photo['path']."/photo_100".$photo['ext']?>">
        </td>
        <td>
          <input type="hidden" name="id[]" value="<?php echo $photo['photo_id']?>">
          <textarea name="title[]" class="span5" placeholder="Başlık yoksa boş bırakın."><?php echo $photo['title']?></textarea>
        </td>
        <td><a href="#" class="btn-remove-slide btn btn-small btn-danger">Sil</a><input type="hidden" name="removed[]" value="0"></td>
      </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal">Kapat</a>    
    <input type="submit" id="photoSetSubmit" class="btn btn-primary" data-loading-text="Lütfen bekleyin..." data-complete-text="Kaydet" value="Kaydet"/> 
  </div>     
</form>
