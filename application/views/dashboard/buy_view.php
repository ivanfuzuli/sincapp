<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('str_buy_package');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300italic,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
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
                
                <div class="col-xs-3 bs-wizard-step active"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Adım 2</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Paketler arasından size uygun olan paketi seçin.</div>
                </div>
                
                <div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
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
            <?php echo $priceTable ?>
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
