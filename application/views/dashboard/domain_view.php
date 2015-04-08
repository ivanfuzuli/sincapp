<div class="modal fade">      
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Alan Adı Seç</h3>
  </div>
    <div class="modal-body">
		<form class="form-inline" data-submit="<?php echo base_url()?>dashboard/whois/<?php echo $site_id?>" id="domainSearch">
		  Adres: www.<input type="text" id="domain" name="domain" class="input-medium" placeholder="siteadi">
		  <label class="checkbox">
		    <input type="checkbox" name="tdl[]" value="com" checked> .Com
		  </label>
		    <input type="checkbox" name="tdl[]" value="net" checked> .Net
		    <input type="checkbox" name="tdl[]" value="org" checked> .Org
		    <input type="checkbox" name="tdl[]" value="biz" checked> .Biz
		  <button type="submit" class="btn btn-primary" id="btn-search" data-loading-text="Yükleniyor..." data-complete-text="Sorgula" disabled>Sorgula</button>
		</form>
    	<div class="alert alert-info hide" id="exist-notify">
    		<p><strong>www.<span id="spanName">siteadi.com</span></strong> alanadını daha önce başka bir servis ile kayıt ettiyseniz bu adresi sincapp ile birlikte kullanabilirsiniz.</p>
    		<p> Bunun için alanadı sağlayıcınızda bulunan nameserver'ları <strong>ns1.digitalocean.com</strong> ve <strong>ns2.digitalocean.com</strong> olarak güncellemeniz gerekmektedir.</p>
    		<p> Daha önce alanadına sahip olduğunuz için size <strong>20 TL</strong> indirim uygulanacaktır.</p>
    		<p><a href="#" class="btn btn-primary" id="btnContinue">Devam Et</a></p>
    	</div>		
		<div id="domainList">

		</div>
    </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button>
      
  </div>
</div>
                         
