<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Üye Girişi - Sincapp</title>
    <meta name="description" content="Sincapp kullanıcı girişi sayfası.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='//fonts.googleapis.com/css?family=Asap&subset=latin,latin-ext' rel='stylesheet' type='text/css'>       <link href="<?php echo base_url()?>files/home/css/bootstrap.min.css" rel="stylesheet" type="text/css">
       <link href="<?php echo base_url()?>files/home/css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container container-top">
		<img src="<?php echo base_url()?>files/css/images/logo.png">
		<div class="row row-border">
  			<div class="col-md-6">
  				<h2>HOŞGELDİNİZ</h2>
  				<h4>Lütfen giriş yapın.</h4>

                <div class="form-group" style="margin-top:5px">
                    <a href="<?php echo $fb_link?>"><img src="<?php echo base_url()?>files/img/facebook-login.png"></a>
                </div>
				  <?php if($this->session->flashdata('login_error')){ 
            		echo $this->load->view('dashboard/login_error_view', false, true);
        		}	
        		?>
          <?php if($this->session->flashdata('captcha_error')){ 
                echo $this->load->view('dashboard/captcha_error_view', false, true);
            } 
            ?>            	
  				<form role="form" method="post" id="login-form" action="<?php echo base_url()?>home/post_login">
				  <div class="form-group">
				    <label for="exampleInputEmail1">E-Posta Adresi</label>
				    <input type="email" name="email" class="form-control input-large" placeholder="E-posta adresi">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Şifre</label>
				    <input type="password" name="password" class="form-control" placeholder="Şifre">
				  </div>
				  <div class="checkbox">
					  <label>
						<input type="checkbox" name="remember"> Beni Hatırla
					  </label>
					  <a href="#" data-toggle="modal" data-target="#myModal" id="forgot_but">Şifremi Unuttum</a>
				  </div>
          <?php if($this->session->userdata('login_captcha')):
          ?>
          <div class="form-group">
            <label>
            Güvenlik Kodu:<img class="captcha" src="<?php echo base_url()?>form/refresh?<?php echo time()?>"><a href="#" data-captcha="<?php echo base_url()?>form/refresh" class="refresh_captcha">Yenile</a>
            </label>
            <div>
              <input type="text" name="phrase">
            </div>
          </div>
          <?php endif;?>
				  <div class="form-group">
				   	<button type="submit" id="login-submit" class="btn btn-primary btn-lg">Giriş Yap</button>
				  </div>
           <input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>"> 			  
				</form>			
  			</div>
  			<div class="col-md-6">
  				<h2>Üye değil misiniz?</h2>
  				<a href="<?php echo base_url()?>" class="btn btn-danger btn-lg btn-100">ÜYE OL!</a>
  			</div>
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="forgot-form" action="<?php echo base_url()?>forgot/rec" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Şifremi Unuttum</h4>
      </div>
      <div class="modal-body">
      			  <div id="form-alert"></div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">E-Posta Adresi</label>
				    <input type="email" name="email" class="form-control input-large" placeholder="E-posta adresi">
				  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        <input type="submit" id="forgot-submit" type="button" class="btn btn-primary" value="Gönder">
      </div>
    </form>
  </div>
</div>

        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery-1.10.2.min.js'></script>	
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/bootstrap.min.js?v=<?php echo VERSION?>'></script>
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/login.js?v=<?php echo VERSION?>'></script>


</body>
</html>