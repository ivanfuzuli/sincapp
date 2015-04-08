<form class="modal fade" name="socialEditForm" id="socialEditForm" action="#" method="post">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Sosyal Medya</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Mecra</th>
          <th>Durum</th>
          <th>Url</th>
        </tr>
      </thead>
      <tbody>
          <tr>
            <td>Facebook</td>
            <td>      
              <div class="switcher">
                <div class="switch-but switch-social <?php if(!$facebook) echo "switch-off"?>" data-input="facebook" unselectable="on"><span>GÖSTER</span><span class="switch-right">GİZLE</span></div>
                <input type="hidden" name="hidden[]" value="<?php echo ($facebook) ? 1 : 0;?>">
              </div>
            </td>
            <td><input type="text" name="facebook" class="input-large" style="<?php if(!$facebook) echo "display:none"?>" value="<?php echo $facebook?>"></td>
          </tr>
          <tr>
            <td>Twitter</td>
            <td>      
              <div class="switcher">
                <div class="switch-but switch-social <?php if(!$twitter) echo "switch-off"?>" data-input="twitter" unselectable="on"><span>GÖSTER</span><span class="switch-right">GİZLE</span></div>
                <input type="hidden" name="hidden[]" value="<?php echo ($twitter) ? 1 : 0;?>">
              </div>
            </td>
            <td><input type="text" name="twitter" class="input-large" style="<?php if(!$twitter) echo "display:none"?>" value="<?php echo $twitter?>"></td>
          </tr>
          <tr>
            <td>Google+</td>
            <td>      
              <div class="switcher">
                <div class="switch-but switch-social <?php if(!$google) echo "switch-off"?>" data-input="google" unselectable="on"><span>GÖSTER</span><span class="switch-right">GİZLE</span></div>
                <input type="hidden" name="hidden[]" value="<?php echo ($google) ? 1 : 0;?>">
              </div>
            </td>
            <td><input type="text" name="google" class="input-large" style="<?php if(!$google) echo "display:none"?>" value="<?php echo $google?>"></td>
          </tr>             
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="site_id" value="<?php echo $site_id?>">
    <a class="btn" data-dismiss="modal">Kapat</a>      
    <input type="submit" class="btn btn-primary" data-loading-text="Lütfen Bekleyin." data-complete-text="Kaydet" value="Kaydet" />
  </div>
                         
</form>
