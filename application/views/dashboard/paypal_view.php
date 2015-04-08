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
                <div class="pay">
                    <div class="header">Alınan Alanadı</div>
                    <div class="body"><?php echo $domain?></div>
                </div>
                <div class="pay">
                    <div class="header">Ücret</div>
                    <div class="body">
                    <?php 
                    switch ($package) {
                      case 'personal':
                          echo "69";
                        break;
                      
                      case 'business':
                          echo "89";
                          break;
                      case 'big':
                          echo '149';
                      default:
                        # code...
                        break;
                    }
                    ?> TL / Yıllık</div>
                </div>
                <div class="pay">
                    <div class="header">Satın Al</div>
                    <div class="body">
                    <?php if($package == "personal"):?>
                      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                      <input type="hidden" name="cmd" value="_s-xclick">
                      <input type="hidden" name="hosted_button_id" value="V98U8ZKJAS5TA">
                      <input type="image" src="https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - Online ödeme yapmanın daha güvenli ve kolay yolu!">
                      <img alt="" border="0" src="https://www.paypalobjects.com/tr_TR/i/scr/pixel.gif" width="1" height="1">
                      </form>
                    <?php endif?>
                    <?php if($package == 'business'):?>
                      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                      <input type="hidden" name="item_name" value="Sincapp Isletme#<?php echo $order_id?>">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="HZMALBQZZHAZ6">
                        <input type="image" src="https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - Online ödeme yapmanın daha güvenli ve kolay yolu!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/tr_TR/i/scr/pixel.gif" width="1" height="1">
                      </form>
                    <?php endif?>
                    <?php if($package == "big"):?>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="item_name" value="Sincapp Buyuk#<?php echo $order_id?>">

                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="BZQNCJ7MAQ56G">
                        <input type="image" src="https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - Online ödeme yapmanın daha güvenli ve kolay yolu!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/tr_TR/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    <?php endif?>

                    </div>
                </div>              
              </div>
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
