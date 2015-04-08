<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ödeme Tamamlandı! </title>
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
                                    <?php echo $amount?> TL (KDV dahil) / Yıllık</div>
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
                                    <div class="header">Ödeme Başarılı!</div>
                                    <div class="body">
                                      <p>
                                        <strong>Tebrikler.</strong> Kartınızdan başarılı bir şekilde <strong><?php echo $amount?> TL</strong> tahsil edilmiştir ve siparişiniz aktif hale getirilmiştir.
                                      </p>
                                      <p>
                                        Bu işlem kartınızın ekstresinde <strong>Alveal Ltd.</strong> olarak gözükecektir.
                                      </p>
                                      <?php if($existing == TRUE):?>
                                      <p>Sitenizin nameserverlarını <strong>ns1.digitalocean.com</strong> ve <strong>ns2.digitalocean.com</strong> olarak güncellemeniz gerekmektedir.</p>
                                      <?php endif;?>
                                      <p>
                                        Sitenizin tamamen aktif olması için dns sunucularının güncellenmesi gerekmektedir. Bu işlem <strong>24 saat'e</strong> kadar sürebilmektedir.
                                      </p>
                                    </strong>
                                    </div>
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
