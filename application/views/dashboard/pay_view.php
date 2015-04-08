<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Satın Al</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link rel="shortcut icon" href="<?php echo base_url()?>/files/css/fav.ico" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300italic,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

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
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Adım 3</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Alanadı satın almak için gerekli olan bilgileri girin.</div>
                </div>
                
                <div class="col-xs-3 bs-wizard-step active"><!-- active -->
                  <div class="text-center bs-wizard-stepnum">Adım 4</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Ödeme detaylarını girerek satın alma işlemini tamamlayın.</div>
                </div>
            </div>      
	</div>
	<div class="clearfix"></div>
                <div class="alert alert-info">Aşağıda ödeyeceğiniz ücretten başka herhangi bir ekstra ücret yoktur. Satın alma işleminiz tamamlandıktan sonra varolan siteniz otomatik olarak yeni alanadına taşınacaktır.</div>
                <div class="clearfix"></div>
                <div class="pay_container">
                  <div class="pay_info">                
                                <div class="pay">
                                    <div class="header">Alınan Alanadı</div>
                                    <div class="body"><?php echo $domain?></div>
                                </div>
                                <div class="pay">
                                    <div class="header">Ücret</div>
                                    <div class="body">
                                    <?php 
                                    $price = $package->price;
                                    if($existing == TRUE) {
                                       $price -= 20;
                                    }
                                    ?>
                                    <?php echo $price?> TL (KDV dahil) / Yıllık
                                    <?php if($existing == TRUE):?>
                                        <div class="alert alert-info">Alanadı ücreti olan 20 TL indirim yapılmıştır.</div>
                                    <?php endif;?>
                                  </div>
                                </div>
                                <div class="pay">
                                    <div class="header">Bilgiler</div>
                                    <div class="body">
                                      <table class="table table-striped">
                                        <tr>
                                            <td>İsim Soyisim:</td>
                                            <td><?php echo $contact->name?></td>
                                        </tr>
                                        <tr>
                                            <td>Telefon:</td>
                                            <td><?php echo $contact->phone?></td>
                                        </tr>
                                        <tr>
                                            <td>E-Posta:</td>
                                            <td><?php echo $contact->email?></td>
                                        </tr>
                                        <tr>
                                            <td>Adres:</td>
                                            <td><?php echo $contact->address?></td>
                                        </tr>
                                        <tr>
                                            <td>Şehir:</td>
                                            <td><?php echo $contact->city?></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div>                              
                  </div>
                  <div class="pay_pos">
                                <div class="pay">
                                    <div class="header">Kredi Kartı Bilgileri</div>
                                    <div class="body">
                                    <?php if($this->session->flashdata('pos_error')):?>
                                    <div class="alert alert-error">
                                      <button type="button" class="close" data-dismiss="alert">×</button>
                                      <strong>Hata!</strong> <?php echo $this->session->flashdata('pos_error');?>
                                    </div>  
                                  <?php endif;?>
                                    <div class="card_wrapper"></div>
                                    <form id="pay_form" method="post" class="form-horizontal" action="<?php echo base_url() . 'buy/pos'?>" autocomplete="off">
                                        <div class="control-group">
                                          <label class="control-label" for="inputName">İsim Soyisim:</label>
                                          <div class="controls controls-mini">
                                            <input type="text" class="card-input" name="name" id="inputName" placeholder="İsim Soyisim">
                                             <span class="help-inline hide"> Lütfen geçerli bir isim soyisim giriniz.</span>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="inputNumber">Kredi Kartı Numarası:</label>
                                          <div class="controls controls-mini">
                                            <input type="text" class="card-input" name="number" id="inputNumber" placeholder="**** **** **** ****">
                                            <span class="help-inline hide"> Lütfen geçerli bir kart numarası girin.</span>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="inputExpiry">Son Kullanma Tarihi:</label>
                                          <div class="controls controls-mini">
                                            <input type="text"  class="card-input input-small" name="expiry" id="inputExpiry" placeholder="Ay / Yıl">
                                             <span class="help-inline hide"> Son kullanma tarihi hatalı.</span>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="inputCvc">Güvenlik Kodu (Cvc):</label>
                                          <div class="controls controls-mini">
                                            <input type="text" class="card-input input-small" name="cvc" id="inputCvc" placeholder="***">
                                             <span class="help-inline hide"> Lütfen geçerli bir cvc giriniz.</span>                                            
                                          </div>
                                        </div>
                                        <div class="control-group">
                                            <label><input type="checkbox" id="inputAgreement" name="agreement" value="1"> <a href="<?php echo base_url()?>buy/domain_agreement" data-url="<?php echo base_url()?>buy/domain_agreement">Alanadı satış sözleşmesini</a> ve <a href="<?php echo base_url()?>buy/hosting_agreement" data-url="<?php echo base_url()?>buy/hosting_agreement">Hosting satış sözleşmesini</a> okudum ve kabul ediyorum.</label>
                                             <span class="help-inline hide" style="color:#b94a48"> Lütfen sözleşmeyi kabul edin.</span>                                            

                                        </div>
                                        <div class="control-group">
                                            <input type="hidden" name="order_id" value="<?php echo $order_id?>">
                                            <input type="hidden" name="pos_orderid" value="<?php echo $pos_orderid?>">
                                            <input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">
                                            <button type="submit" id="btnPay" class="btn btn-success">Satın AL</button>
                                        </div>
                                    </form>
                                </div> 
                  </div>
                </div>            
            </div>
        </div>
    </div>        
<?php echo $footer?>
</div>
<script type="text/javascript">
    var version = "<?php echo VERSION?>", _token = "<?php echo $this->security->get_csrf_hash();?>", require = {urlArgs:"js_v="+version };    
</script>
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js?v=<?php echo VERSION?>"></script>
</body>
</html>
