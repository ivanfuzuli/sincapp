<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kullanıcı Bilgileri</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link rel="shortcut icon" href="<?php echo base_url()?>/files/css/fav.ico" />
</head>
<body>
<?php echo $header?>
<div class="container">
    <div class="row">
        <div class="span12">       
            <div class="well">
	<div class="step_container">
            <div class="row bs-wizard" style="border-bottom:0;">     
                <div class="col-xs-3 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">Adım 1</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Sitenizde kullanmak istediğiniz alan adını seçin.</div>
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Adım 2</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Paketler arasından size uygun olan paketi seçin.</div>
                </div>
                
                <div class="col-xs-3 bs-wizard-step active"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Adım 3</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Alanadı satın almak için gerekli olan bilgileri girin.</div>
                </div>
                
                <div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
                  <div class="text-center bs-wizard-stepnum">Adım 4</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Ödeme detaylarını girerek satın alma işlemini tamamlayın.</div>
                </div>
            </div>      
	</div>
	<div class="clearfix"></div>
            	<?php if($error):?>
            		<div class="alert alert-error">
				    <button class="close" data-dismiss="alert">×</button>
				    <strong>Opps!</strong> Lütfen tüm alanları doldurunuz.
				    </div>
            	<?php endif?>
            	<form action="<?php echo base_url()?>dashboard/details_do/<?php echo $site_id?>/<?php echo $domain?>/<?php echo $package?>" method="post">
            		<table class="table table-striped">
            			<tr>
            				<td><span class="line-height-28">İsim Soyisim <i class="required">*</i></span></td>
            				<td><input type="text" name="name" value="<?php if($details) echo $details->name?>"></td>
            				<td><span class="line-height-28">Telefon <i class="required">*</i></span></td>
            				<td>
                      <div class="input-prepend">
                        <span class="add-on">+90</span>
                        <input type="text" class="span-phone" id="phone" name="phone" value="<?php if($details) echo substr($details->phone, 1);?>">
                      </div>
                    </td>
            			</tr>
            			<tr>
            				<td><span class="line-height-28">Email <i class="required">*</i></span></td>
            				<td><input type="text" name="email" value="<?php echo $email?>" ></td>
            				<td><span class="line-height-28">Şehir <i class="required">*</i></span></td>
            				<td><input type="text" name="city" value="<?php if($details) echo $details->city?>"></td>
            			</tr>
            			<tr>
            				<td><span class="line-height-28">Posta Kodu <i class="required">*</i></span></td>
            				<td><input type="text" name="zipcode" value="<?php if($details) echo $details->zipcode?>"></td>
            				<td><span class="line-height-28">Adres <i class="required">*</i></span></td>
            				<td><textarea name="address"><?php if($details) echo $details->address?></textarea></td>
            			</tr>
            			<tr>
            				<td><input type="submit" class="btn btn-success" value="Devam Et"></td>
            				<td>
                      <input type="hidden" name="existing" value="<?php echo $existing;?>">
                      <input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">
                    </td>
            				<td></td>
            				<td></td>
            			</tr>              			            			
            		</table>
            	</form>
            </div>
        </div>
    </div>        
<?php echo $footer?>
</div>
<script type="text/javascript">
    var version = "<?php echo VERSION?>", require = {urlArgs:"js_v="+version };    
</script>
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js?v=<?php echo VERSION?>"></script>
</body>
</html>
