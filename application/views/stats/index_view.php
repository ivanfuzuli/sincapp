<div class="modal fade">      
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>İstatistikler</h3>
  </div>
    <div class="modal-body">
        <?php if(!$is_exist):?>
        <div class="alert alert-info alert-block"><strong>Bilgi</strong><br>Henüz siteniz Yandex.Metrica ile entegre edilmemiştir. Entegre etmek için aşağıdaki yandex ile giriş yap tuşuna basın.</div>
        <?php endif;?>
        <div  style="margin:0 auto; width: 150px">
        <a href="https://oauth.yandex.com.tr/authorize?response_type=code&client_id=2c6374f6da474cc1ac2df2e3a0cd2a7d&state=<?php echo $site_id?>" target="blank" class="btn"><span style="color: red">Y</span>andex ile Giriş Yap</a>
        </div>
    </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal">Kapat</button> 
  </div>
</form>