<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sincapp - Ücretsiz hazır web sitesi aracı | Site kur</title>
    <meta name="description" content="Sürükle ve Bırak ile kullanılabilen hazır web sitesi aracı. İçerisinde bir çok modül barındırır."/>
    <meta name="keywords" content="hazır web sitesi, site kur, ücretsiz web sitesi"/>    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>files/css/build/index.<?php echo ENVIRONMENT?>.css?v=<?php echo VERSION?>" />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300italic,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url()?>/files/css/fav.ico" />
</head>
<body>
<div id="loading"></div>
<div class="header_wrap">    
    <div class="container" id="header">

        <?php if($this->session->flashdata('login_error')){ 
            echo $this->load->view('dashboard/login_error_view', false, true);
        }
        ?>
        <div class="row">
            <div class="span7">
                <img id="logo" src="<?php echo base_url()?>/files/css/images/logo.png" width="180" height="63" />
            </div>
            <div class="span5">
                <form class="well form-inline" id="login-form" method="post" action="<?php echo base_url()?>home/login">
                    <div class="controls">
                        <div class="placeholding-input">
                            <input class="input-small" name="email" type="text" />
                            <span class="placeholder">E-posta</span>
                        </div>
                        <div class="input-append">
                            <div class="placeholding-input">
                            <input class="input-small" type="password" name="password" /><span class="placeholder">Şifre</span></div><input type="submit" value="Giriş" class="btn btn-primary" />
                        </div>
                        <label class="checkbox">
                            <input type="checkbox" name="remember" /> Beni Hatırla
                        </label>
                    </div>
                    <div class="controls" style="margin-top:5px">
                        <a href="#" data-url="<?php echo base_url()?>forgot/" id="forgot_but">Şifremi Unuttum</a>
                        <a href="<?php echo $fb_link?>"><img src="<?php echo base_url()?>files/img/facebook-login.png"></a>
                    </div>
                </form>               
            </div>
        </div>   
    </div> 
</div>
<div class="container">
    <div class="row">
        <div class="span12">

        </div>
    </div>
    <div class="row">
        <div class="span7">
            <div class="well">
                <h4>Sincapp; Ücretsiz, Sürükle Bırak İnternet Sitesi Oluşturma Aracı</h4>
            </div>
                    <div id="sliderMe" class="carousel slide">
                      <!-- Carousel items -->
                      <div class="carousel-inner">
                        <div class="active item">
                            <img src="<?php echo base_url()?>files/css/images/home/hand.jpg"  alt="" />
                            <div class="carousel-caption">
                                <h6>Modüler Yapı</h6>
                                <p>Sincapp, sürükle bırak ile kurulabilen modüler yapıya sahiptir.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo base_url()?>files/css/images/home/f1.jpg"  alt="" />
                            <div class="carousel-caption">
                                <h6>3 Kat Daha Hızlı</h6>
                                <p>Sincapp ile oluşturulan siteler ortalama bir internet sitesine göre 3 kat daha hızlıdır.</p>
                            </div>                            
                        </div>
                        <div class="item">
                            <img src="<?php echo base_url()?>files/css/images/home/google.jpg"  alt="" />
                            <div class="carousel-caption">
                                <h6>Arama Motoru Dostu</h6>
                                <p>Sincapp ile oluşturulan siteler başta google olmak üzere arama motorlarıyla tam uyumludur.</p>
                            </div>                        
                        </div>
                      </div>
                      <!-- Carousel nav -->
                      <a class="carousel-control left" href="#sliderMe" data-slide="prev">&lsaquo;</a>
                      <a class="carousel-control right" href="#sliderMe" data-slide="next">&rsaquo;</a>
                    </div> 
            <div class="well">
                <h4>Kısa Bakış</h4>
<iframe src="//player.vimeo.com/video/45170208" id="sincappVideo" width="500" height="326" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>            </div>           
        </div>
        <div class="span5">
            <div id="errors"></div>            
            <form class="well form-special" method="post" id="signup-form" data-action="<?php echo base_url()?>home/signup" action="#">
            <h4>Üye Ol</h4>
            <h6>Tamamen Ücretsiz</h6>
                <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">http://</span><div class="placeholding-input"><input id="sitename" class="input-small-special" required name="sitename" type="text" /><span class="placeholder">siteadresi</span></div><span class="add-on">.sincapp.com/</span>
                  </div>
                  <div class="placeholding-input">  
                    <input id="email" class="input-special" required type="text" name="email" autocomplete="off"/>
                    <span class="placeholder">E-Posta</span>
                  </div>
                  <div class="placeholding-input">  
                    <input id="password" class="input-special" required type="password" name="password" autocomplete="off" />  
                    <span class="placeholder">Şifre</span>
                  </div>
                    <div>
                    Sincapp'a üye olarak <a href="#" data-url="<?php echo base_url()?>/pages/sozlesme">kullanıcı sözleşmesini</a> kabul etmiş sayılırsınız.
                    </div>
                    <input type="submit" disabled="disabled" id="signup-but" value="Ücretsiz Üye Ol" class="btn btn-danger btn-large" data-loading-text="Lütfen bekleyin..." data-complete-text="Ücretsiz Üye Ol"/>
                </div>            
            </form>
           <div class="well">
                <h4>Sincapp Nedir?</h4>
                Sincapp üyelerine ücretsiz hazır web sitesi kurma imkanı veren bir platformdur. <br><br>
                Kullanıcıların Sincapp'ı kullanabilmek için hiçbir teknik bilgiye gereksinimleri yoktur.
                <br><br>Sincapp'ı kullanmanın ne kadar kolay olduğunu görmek için lütfen tanıtım videosunu izleyiniz.                                    
            </div>                
        </div>
    </div>
        <div class="row">
            <div class="well"><?php echo $priceTable?></div>
        </div>
<?php echo $footer_view?>
</div> 
<script type="text/javascript">
    var version = "<?php echo VERSION?>", require = {urlArgs:"js_v="+version };    
</script>
<script data-main="<?php echo base_url()?>files/js/app/home.<?php echo ENVIRONMENT?>.js" src="<?php echo base_url()?>files/js/app/require.js?v=<?php echo VERSION?>"></script>
</body>
</html>