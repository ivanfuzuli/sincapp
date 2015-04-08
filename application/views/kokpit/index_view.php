<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kokpit</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/kokpit.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/datatable/css/jquery.dataTables.min.css" />
<link rel="shortcut icon" href="<?php echo base_url()?>/files/css/fav.ico" />

</head>

<body>
    <div class="container">

        <div class="row">
            <div class="span3">
                <ul class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo base_url()?>kokpit/">Anasayfa</a></li>
                    <li><a href="<?php echo base_url()?>kokpit/users">Kullanıcılar</a></li>
                    <li><a href="<?php echo base_url()?>kokpit/sites">Siteler</a></li>
                    <li>
                       <?php if($feedback_statu):?>
                        <div class="ibox"><?php echo $feedback_statu?></div>
                        <?php endif;?>
                        <a href="<?php echo base_url()?>kokpit/feedbacks">Geribildirimler</a>
                    </li>
                    <li>
                        <?php if($contact_statu):?>
                        <div class="ibox"><?php echo $contact_statu?></div>
                        <?php endif;?>
                        <a href="<?php echo base_url()?>kokpit/contacts">İletişim</a>
                    </li>                    
                    <li>
                        <?php if($delete_statu):?>
                            <div class="ibox"><?php echo $delete_statu?></div>
                        <?php endif;?>
                        <a href="<?php echo base_url()?>kokpit/delete_sites">Site Silme Talepleri</a>
                    </li>
                    <li><a href="<?php echo base_url()?>kokpit/pinger">Google Pinger</a></li>
                    <li>
                        <?php if($order_statu):?>
                            <div class="ibox"><?php echo $order_statu?></div>
                        <?php endif;?>
                    <a href="<?php echo base_url()?>kokpit/orders">Siparişler</a></li>                    
                    <li><a href="<?php echo base_url()?>kokpit/logins">Girişler</a></li>
                    <li><a href="<?php echo base_url()?>kokpit/blog">Blog</a></li>
                    <li><a href="<?php echo base_url()?>kokpit/migrate_mail">E-Posta Taşı</a></li>
                </ul>
            </div>
            <div class="span8">
                    <?php echo $middle?>
            </div>
        </div>
    </div>
<script type="text/javascript">
//<![CDATA[ 
var base_url = "<?php echo base_url()?>", _token = "<?php echo $this->security->get_csrf_hash()?>";
//]]> 
</script>
<script data-main="<?php echo base_url()?>files/js/app/kokpit.js" src="<?php echo base_url()?>files/js/app/require.js"></script>

</body>
</html>