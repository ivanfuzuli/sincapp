<form class="modal fade" id="contact-form" action="#" data-action="<?php echo base_url()?>pages/form_do" method="post">
   
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>İletişim Formu</h3>
  </div>

  <div class="modal-body">
      <div id="contact-alert"></div>
      <label>İsim Soyisim: <span class="required">*</span></label><input type="text" name="name" class="span5"/>
     <label>E-Posta: <span class="required">*</span></label><input type="text" name="email" class="span5"/>
     <label>Mesaj: <span class="required">*</span></label><textarea name="message" class="span6" rows="5"></textarea>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal">Kapat</button><input type="submit" href="#" class="btn btn-primary" data-loading-text="Lütfen bekleyin..." data-complete-text="Gönder" value="Gönder" />
  </div>
</form>
