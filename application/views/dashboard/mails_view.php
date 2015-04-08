<script type="text/javascript">
  var base_url = "<?php echo base_url()?>";
  var site_id = <?php echo $site_id?>;
</script>
<div class="modal fade">      
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>E-Posta Yönetimi</h3>
  </div>
    <div class="modal-body">
        <span class="alert alert-info">E-posta adresinize <a href="http://mail.<?php echo $domain?>">http://mail.<?php echo $domain?></a> adresinden giriş yapabilirsiniz.</span>
        <br><br><div id="mailAlert"></div>
		<form id="addMail" data-action="<?php echo base_url()?>dashboard/add_mail" method="POST" class="form-inline">
			<div class="input-append">
			  <input type="text" name="email" class="input-small" placeholder="E-Posta Adresi">
			  <span class="add-on">@<?php echo $domain?></span>
			  <input type="password" name="password" placeholder="Şifre" class="input-small">			  
			  <input type="hidden" name="site_id" value="<?php echo $site_id?>">			  
			  <button type="submit" id="addMailBut" data-loading-text="Lütfen Bekleyin.." data-complete-text="Kaydet" class="btn btn-primary">Kaydet</button>
			</div>
		</form>        
        <table class="table table-striped">
        	<thead>
        		<th>Mail Adresi</th>
        		<th>İşlem</th>
        	</thead>
        	<tbody id="tbody">
        	<?php foreach($mails as $mail):?>
        		<tr>
        			<td><?php echo $mail->name?>@<?php echo $domain?></td>
        			<td><a href="#" data-id="<?php echo $mail->id?>" data-loading-text="Lütfen Bekleyin.." data-complete-text="Sil!" class="delete-mail btn btn-danger">Sil!</a></td>
        		</tr>
        	<?php endforeach;?>
        	</tbody>
        </table>
    </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button> 
  </div>
</form>
                         
    