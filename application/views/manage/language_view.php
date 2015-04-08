<div class="modal fade" name="fieldsForm" id="fieldsForm">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Çoklu Dil Seçimi</h3>
  </div>
  <div class="modal-body">
      <div>
        <p>Buradan sitenizin çoklu dilde görüntülenmesini ayarlayabilirsiniz. Durumu aktif edin ve düzenlemek için ingilizceyi seçin.</p>

      </div>
      <div id="languageLoading"><div class="hide"><span class="label label-warning">Lütfen bekleyin...</span></div></div>
      <div class="span_half">
        <h3>Çoklu Dil Modu:</h3>
        <div class="switcher">
              <div class="switch-but switch-language <?php if(!$english_status): echo 'switch-off'; endif?>" unselectable="on" data-value="<?php echo ($english_status)? 1 : 0; ?>"><span>AKTİF</span><span class="switch-right">PASİF</span></div>
          </div>
      </div>
      <div class="span_half <?php if(!$english_status): echo 'hide'; endif?>" id="lang-changer">
      <h3>Düzenlenen Site:</h3>
      <div class="switcher">
            <div class="switch-but switch-change-site <?php if($prefix): echo 'switch-off'; endif?>" unselectable="on" data-value="<?php echo (!$prefix)? 1 : 0; ?>"><span>TÜRKÇE</span><span class="switch-right">ENGLISH</span></div>
        </div>   
      </div>  
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal">KAPAT</a>      
  </div>     
</div>
