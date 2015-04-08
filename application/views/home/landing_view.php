<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="tr"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="tr"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="tr"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="tr">
    <head>
        <!-- IE6-8 support of HTML5 elements --> 
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!--[if IE]>
                    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

        <!-- Meta Tags -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>Sincapp - Ücretsiz hazır web sitesi aracı | Site Kur</title>
        <meta name="description" content="Sürükle&Bırak ile kullanılabilen hazır web sitesi aracı. İçerisinde bir çok modül barındırır."/>
        <meta name="keywords" content="hazır web sitesi, site kur, ücretsiz web sitesi, blog, ücretsiz blog"/>    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" >
<?php if(ENVIRONMENT == "production"):?>
        <link href="<?php echo base_url()?>files/home/css/home.min.css" rel="stylesheet" type="text/css" />
<?php else:?>
        <!-- Stylesheets -->
        <link href="<?php echo base_url()?>files/home/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>files/home/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url()?>files/home/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>files/home/css/folio-font.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>files/home/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>files/home/css/project_style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>files/home/css/isotope_animation.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>files/home/css/animation.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>files/home/css/jquery.bxslider.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>files/home/css/responsiveslides.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>files/home/css/magnific-popup.css" rel="stylesheet" type="text/css">

        <!-- Color Scheme Layout -->
        <link href="<?php echo base_url()?>files/home/css/colors/orange.css" rel="stylesheet" type="text/css" id="layout-css" />
<?php endif?>
        <!-- Google fonts -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,300,800,300italic,700italic,800italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- font-family: 'Open Sans', sans-serif; -->

        <!-- jQuery -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery-1.10.2.min.js'></script>

        <!--[if IE]>
                    <link rel="stylesheet" type="text/css"  href="css/ie_style.css"/><![endif]-->
        <script type="text/javascript">
            //For IE 10
            if (Function('/*@cc_on return document.documentMode===10@*/')()) {
                var headHTML = document.getElementsByTagName('head')[0].innerHTML;
                headHTML += '<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>files/home/css/ie_style.css">';
                document.getElementsByTagName('head')[0].innerHTML = headHTML;
            }

            //For IE 11
            if (navigator.userAgent.match(/Trident.*rv:11\./)) {
                var headHTML = document.getElementsByTagName('head')[0].innerHTML;
                headHTML += '<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>files/home/css/ie_style.css">';
                document.getElementsByTagName('head')[0].innerHTML = headHTML;
            }
        </script>

    </head>

    <body>
        <!-- preloader starts -->
        <div id="preloader" >
            <!-- status -->
            <div id="status"><div class="logo-grey"></div>&nbsp;</div><!-- /status -->
        </div>
        <!-- preloader ends -->

        <!-- top-slider -->
        <section id="sec-home">
            <!-- static_banner starts -->
            <div class="static_banner bk_img_form_1 landing_page_header">

                <div class="container">
                    <div class="logo-loader"></div>
                    <?php if(!$logged):?>
                    <a href="<?php echo base_url()?>home/login" class="btn btn-info pull-right btn-large" style="margin-top:10px">Giriş Yap</a>
                    <?php else:?>
                    <a href="<?php echo base_url()?>dashboard/logout" class="btn btn-danger pull-right btn-large" style="margin-top:10px; margin-left: 5px">ÇIKIŞ</a>                    
                    <a href="<?php echo base_url()?>dashboard" class="btn btn-info pull-right btn-large" style="margin-top:10px">Kontrol Paneli</a>
                    <?php endif?>
                    <div class="span_center align_center landing_page_details">
                        <div class="hgroup">
                            <h2>Sürükle&Bırak ile kullanılan </h2>
                            <h3>Ücretsiz hazır web sitesi aracı</h3>
                            <h4>Hemen Deneyin!</h4>

                        </div>
                        <div class="hgroup">
                            <a href="http://vimeo.com/110778875" class="popup-vimeo btn btn-large btn-info">Tanıtım Filmi</a>
                        </div>
                        <?php if(!$logged):?>
                        <div class="free_quote_form free_quote">
                            <form action="#" method="post" name="free_quote_form">
                                <span class="field_single">
                                    <label for="sitename" id="sitename-label">.sincapp.com</label>
                                    <input name="sitename" id="sitename" type="text" maxlength="25" placeholder="Site adresi">
                                </span>
                                <span class="field_single">
                                    <input name="email" type="email" placeholder="E-Posta">
                                </span>
                                <span class="field_single">
                                    <input name="password" type="password" placeholder="Şifre">
                                </span>
                                <?php if($this->session->userdata('captcha_signup') == TRUE):?>
                                <div style="clear:both"></div>
                                <span class="field_single">
                                    <img class="captcha" src="<?php echo base_url()?>form/refresh?<?php echo time()?>"><a data-captcha="<?php echo base_url()?>form/refresh" class="refresh_captcha" href="#">Yenile</a>
                                    <input type="text" name="phrase" placeholder="Güvenlik Kodu">
                                </span>
                                 <div style="clear:both"></div>
                                <?php endif;?>
                                <input name="btn_submit_quote" id="btn_submit_quote" class="button-xlarge button" type="submit" value="ÜCRETSİZ ÜYE OL!">
                                <input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">
                            </form>
                        </div>
                        <?php endif;?>
                    </div>
                </div>

                <!-- next_section starts -->
                <div class="next_section">
                    <a href="javascript:void(0);" class="scroll_next_section animated animate_infinite" data-animdelay="0.2s" data-animspeed="1.4s" data-animrepeat="1" data-animtype="bounce">
                        <i class="fa fa-chevron-down"></i>
                    </a>
                </div>
                <!-- next_section ends -->
            </div>
            <!-- static_banner ends -->
        </section>
        <!-- top-slider ends -->

        <!-- menu-bar starts -->
        <header class="menu-bar sticky-bar">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <!-- logo starts -->
                        <div class="logo">
                            <figure>
                                <img src="<?php echo base_url()?>files/home/images/logo_orange.png" alt="logo" class="main_logo">
                            </figure>
                            <div class="small_menu">
                                <div class="menu_small_btn">
                                    <div class="open_menu toggle_main_menu_btn">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    <div class="close_menu toggle_main_menu_btn">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- logo ends -->

                        <!--main-nav starts-->
                        <nav class="main-nav">
                            <ul id="top-nav" class="top-nav">
                                <li class="current">
                                    <a href="#sec-home">Ana Sayfa</a>
                                </li>
                                <li>
                                    <a href="#sec-services">Servisler</a>
                                </li>
                                <li>
                                    <a href="#sec-portfolio">Temalar</a>
                                </li>
                                <li>
                                    <a href="#sec-about">Hakkımızda</a>
                                </li>
                                <li>
                                    <a href="#sec-blog">Blog</a>
                                </li>
                                <li>
                                    <a href="#sec-contact">İletişim</a>
                                </li>
                            </ul>
                            <span class="back_top">
                                <a href="javascript:void(0);" class="back_to_top"><i class="fa fa-angle-up"></i></a>
                            </span>
                        </nav>
                        <!-- main-nav ends-->
                    </div>
                </div>
            </div>
        </header>
        <!-- menu-bar ends -->

        <!-- sec-services starts -->
        <section id="sec-services" class="section_container">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <article>
                            <div class="hgroup">
                                <div class="heading_cover">
                                    <h2>Özellikler</h2>
                                </div>
                                <div class="heading_cover">
                                    <h3><span>SİNCAPP</span> HAKKINDA GENEL BİLGİLER</h3>
                                </div>
                                <div class="heading_cover span5 span_center">
                                    <h4>Sincapp sürükle bırak ile kurulabilen hazır web sitesi uygulamasıdır. İçerisinden birçok modül barındırır.</h4>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- our_service starts -->
                    <div class="span6 service_single">
                        <div class="row">
                            <a href="#sec-portfolio">
                            <div class="service_block text-center span2">
                                <span class="icon-folio-shape-filled"></span>
                                <span class="icon-folio-shape-stroke"></span>
                                <i class="fa fa-pencil"></i>
                            </div>
                            </a>
                            <div class="service_right span4">
                                <h4>Tasarım</h4>
                                <p>Sincapp ile gelen temalar arasından dilediğiniz seçebilirsiniz. Üstelik istediğiniz zaman temanızı değiştirmekte özgürsünüz.</p>
                            </div>
                        </div>
                    </div>

                    <div class="span6 service_single">
                        <div class="row">
                            <a href="#sec-portfolio">                            
                                <div class="service_block text-center span2">
                                    <span class="icon-folio-shape-filled"></span>
                                    <span class="icon-folio-shape-stroke"></span>
                                    <i class="fa fa-rocket"></i>
                                </div>
                            </a>
                            <div class="service_right span4">
                                <h4>Modüler Yapı</h4>
                                <p>Sincapp içerisinde sürükleyip bırakarak kullanabileceğiniz modüller barındırır. Örneğin harita modülü, fotoğraf albümü modülü gibi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="span6 service_single">
                        <div class="row">
                            <a href="#sec-portfolio">
                                <div class="service_block text-center span2">
                                    <span class="icon-folio-shape-filled"></span>
                                    <span class="icon-folio-shape-stroke"></span>
                                    <i class="fa fa-truck"></i>
                                </div>
                            </a>
                            <div class="service_right span4">
                                <h4>SEO</h4>
                                <p>Sincapp başta Google olmak üzere arama motorlarıyla tam uyumludur. </p>
                            </div>
                        </div>
                    </div>

                    <div class="span6 service_single">
                        <div class="row">
                            <a href="#sec-portfolio">                            
                                <div class="service_block text-center span2">
                                    <span class="icon-folio-shape-filled"></span>
                                    <span class="icon-folio-shape-stroke"></span>
                                    <i class="fa fa-umbrella"></i>
                                </div>
                            </a>
                            <div class="service_right span4">
                                <h4>GÜVENLİK</h4>
                                <p>Sincapp SSL güvenlik sertifikasını kullanır. Şifreleriniz ve kritik bilgileriniz daha güvenli bir şekilde sunucularımıza ulaşır.</p>
                            </div>
                        </div>
                    </div>
                    <!-- company_service ends -->
                </div>
            </div>
        </section>
        <!-- sec-services ends -->

        <!-- sec-quote4 starts -->
        <section id="sec-quote4" class="parallex_wrapper">
            <div class="parallex_folio">

                <div class="container parallax_container">
                    <div class="row">
                        <div class="span10 span_center parallax_text">
                            <div class="heading_cover">
                                <h5>Tüm <span><i class="fa fa-desktop"></i></span> aygıtları düşünerek tasarlarız.</h5>
                            </div>
                            <p>Sitelerimizi tüm aygıtlarda düzgün görüntülenecek şekilde tasarlarız..</p>
                        </div>

                        <!-- features_block starts -->
                        <div class="span5 span_center align_center">
                            <div class="features_block animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInTop" >
                                <img src="<?php echo base_url()?>files/home/images/features_tab_mob.png" alt="features details" >
                                <!-- feature_single starts -->
                                <div class="feature_single animated" data-animdelay="0.3s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInLeftBig">
                                    <div class="feature_bar">
                                        <i class="fa fa-tablet"></i>
                                    </div>
                                    <div class="description">
                                        <h6>Uyumlu Tasarım</h6>
                                        <p>Bir çok platformda düzgün görüntülenecek tasarımlar.</p>
                                    </div>
                                </div>
                                <!-- feature_single ends -->

                                <!-- feature_single starts -->
                                <div class="feature_single animated" data-animdelay="0.4s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInRightBig">
                                    <div class="feature_bar">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <div class="description">
                                        <h6>7/24 Destek</h6>
                                        <p>Kullanıcılarımıza 7/24 teknik destek sağlarız.</p>
                                    </div>
                                </div>
                                <!-- feature_single ends -->

                                <!-- feature_single starts -->
                                <div class="feature_single animated" data-animdelay="0.5s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInLeftBig">
                                    <div class="feature_bar">
                                        <i class="fa fa-table"></i>
                                    </div>
                                    <div class="description">
                                        <h6>Izgara Sistemi</h6>
                                        <p>Tasarımlarımıza norm olmuş ızgara sistemini kullanırız.</p>
                                    </div>
                                </div>
                                <!-- feature_single ends -->

                                <!-- feature_single starts -->
                                <div class="feature_single animated" data-animdelay="0.6s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInRightBig">
                                    <div class="feature_bar">
                                        <i class="fa fa-magic"></i>
                                    </div>
                                    <div class="description">
                                        <h6>Çoklu Tema Seçeneği</h6>
                                        <p>Dilediğiniz zaman değiştirebileceğiniz çoklu tema desteği sağlarız.</p>
                                    </div>
                                </div>
                                <!-- feature_single ends -->
                            </div>
                        </div>
                        <!-- features_block ends -->

                    </div>
                </div>

            </div>
        </section>
        <!-- sec-quote4 ends -->

        <!-- sec-portfolio starts -->
        <section id="sec-portfolio" class="section_container">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <article>
                            <div class="hgroup">
                                <div class="heading_cover">
                                    <h2>Temalar</h2>
                                </div>
                                <div class="heading_cover">
                                    <h3>Kullanabileceğiniz <span>temalar</span>'dan birkaçı</h3>
                                </div>
                                <div class="heading_cover span5 span_center">
                                    <h4>Sincapp'la beraber kullanabileceğiniz temalardan birkaçını aşağıda listedik.</h4>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- ajax_project_wrapper starts -->  
                    <div id="ajax_project_wrapper" class="span10 span_center">     

                        <!-- project_nav starts --> 
                        <div id="project_nav">
                            <ul>
                                <li id="previous_project"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                <li id="next_project"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                            </ul>  
                        </div>
                        <!-- project_nav ends --> 

                        <!-- close_project starts -->
                        <div id="close_project">
                            <a href="#project_loader"><i class="fa fa-times"></i></a>               
                        </div>  
                        <!-- close_project ends -->

                        <!-- project_loader starts -->
                        <div id="project_loader"></div>
                        <!-- project_loader ends -->

                        <!-- project_container_holder starts -->
                        <div id="project_container_holder">
                            <!-- project_container starts -->
                            <div id="project_container">
                            </div>
                            <!-- project_container ends -->
                        </div>
                        <!-- project_container_holder ends -->

                    </div>
                    <!-- ajax_project_wrapper ends -->   

                    <!-- portfolio_nav starts -->
                    <div class="span12">
                        <nav class="portfolio_nav">
                            <ul id="filters">
                                <!--                            <li class="current">
                                                                <a data-filter="*" href="#"><i class="fa fa-th-large"></i> All projects</a>
                                                            </li>-->
                                <li>
                                    <a data-filter=".cat_website" href="#">Temalar</a>
                                </li>
                                <!--                            <li>
                                                                <a data-filter=".cat_mobile" href="#">Mobile Apps</a>
                                                            </li>
                                                            <li>
                                                                <a data-filter=".cat_campaign" href="#"> Ad Campaign </a>
                                                            </li>
                                                            <li>
                                                                <a data-filter=".cat_strategy" href="#">Strategy</a>
                                                            </li>
                                -->
                            </ul>
                        </nav>
                    </div>
                    <!-- portfolio_nav ends-->

                    <!-- Porfolio Listing starts -->
                    <div id="portfolio_wrapper">
                        <div class="portfolio_listing span12" id="container">
 
                            <div class="portfolio_item span3 isotope-item cat_website cat_campaign">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/imdb_siralama_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project1.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                <a target="_blank" href="http://imdb.sincapp.com" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Imdb Sıralamalı</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <!-- single_portfolio ends -->

                            <!-- 4 single_portfolio starts -->
<!--                            <div class="portfolio_item span3 isotope-item cat_strategy">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/portfolio-img-4.jpg" alt="">
                                        <div class="mask">
                                            <div class="links">
                                                <a href="#!projects/project4.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <span class="divider"></span>
                                                <a href="#" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Athens Digital</h3>
                                                <p>Athens Digital Week TV Spot</p>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>-->
                            <!-- single_portfolio ends -->

                            <!-- 5 single_portfolio starts -->
                            <div class="portfolio_item span3 isotope-item cat_website cat_mobile">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/kuafor_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project5.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                    <a target="_blank" href="http://kuaforcum.sincapp.com" class="info-link">

                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Kuaför - Fotoğraflı</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <!-- single_portfolio ends -->

                            <!-- 6 single_portfolio starts -->
                            <div class="portfolio_item span3 isotope-item cat_website cat_campaign">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/transfer_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project6.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                <a target="_blank" href="http://kuaforcum.sincapp.com" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Transfer Haberi</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <!-- single_portfolio ends -->

                            <!-- 7 single_portfolio starts -->
                            <!--                            <div class="portfolio_item span3 isotope-item cat_mobile">
                                                            <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                                                <figure class="view view-sixth">
                                                                    <img src="<?php echo base_url()?>files/home/images/portfolio/portfolio-img-7.jpg" alt="">
                                                                    <div class="mask">
                                                                        <div class="links">
                                                                            <a href="#!projects/project7.html" title="Cras sit amet seper nisl" class="info">
                                                                                <i class="fa fa-plus"></i>
                                                                            </a>
                                                                            <span class="divider"></span>
                                                                            <a href="#" class="info-link">
                                                                                <i class="fa fa-link"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="port_detail">
                                                                            <h3>Athens Digital</h3>
                                                                            <p>Athens Digital Week TV Spot</p>
                                                                        </div>
                                                                    </div>
                                                                </figure>
                                                            </div>
                                                        </div>-->
                            <!-- single_portfolio ends -->

                            <!-- 8 single_portfolio starts -->
                            <div class="portfolio_item span3 isotope-item cat_website cat_campaign">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/saglik_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project8.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                <a target="_blank" href="http://sagliklibeslenme.sincapp.com" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Sağlıklı İçerik</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <!-- single_portfolio ends -->
                             <div class="portfolio_item span3 isotope-item cat_website">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/oyuncak_muzesi_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project1.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                <a target="_blank" href="http://oyuncakmuzesi.sincapp.com" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Oyuncak Müzesi</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
  <div class="portfolio_item span3 isotope-item cat_website cat_mobile">
                                <div class="single_portfolio animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                                    <figure class="view view-sixth">
                                        <img src="<?php echo base_url()?>files/home/images/portfolio/dunya_kupasi_thumb.png" alt="">
                                        <div class="mask">
                                            <div class="links">
<!--                                                <a href="#!projects/project2.html" title="Cras sit amet seper nisl" class="info">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                --><span class="divider"></span>
                                                <a target="_blank" href="http://dunyakupasi.sincapp.com" class="info-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                            </div>
                                            <div class="port_detail">
                                                <h3>Demo Dünya Kupası</h3>
                                                <!--<p>Athens Digital Week TV Spot</p>-->
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Porfolio Listing ends -->				

                </div>
            </div>
        </section>
        <!-- sec-portfolio ends -->

        <!-- sec-quote1 starts -->
        <section id="sec-quote1" class="parallex_wrapper">
            <div class="parallex_folio">

                <div class="container parallax_container">
                    <div class="row">
                        <div class="span10 span_center parallax_text">
                            <div class="heading_cover">
                                <h5>SİNCAPP HAKKINDA EĞLENCELİ <span><i class="fa fa-magic"></i></span> BİLGİLER</h5>
                            </div>
                            <p>Ne var ne yok?</p>
                        </div>

                        <!-- folio_stats starts -->
                        <div class="folio_stats">
                            <!-- stats_single starts -->
                            <div class="span3 stats_single">
                                <div class="stats_icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="stats_hgroup">
                                    <h2 class="countPercentage animated" data-percentageto="<?php echo $user_count?>" data-animdelay="35"><span><?php echo $user_count_start?></span></h2>
                                    <br>
                                    <h3>TOPLAM ÜYE</h3>
                                </div>
                            </div>
                            <!-- stats_single ends -->

                            <!-- stats_single starts -->
                            <div class="span3 stats_single">
                                <div class="stats_icon">
                                    <i class="fa fa-sitemap"></i>
                                </div>
                                <div class="stats_hgroup">
                                    <h2 class="countPercentage animated" data-percentageto="<?php echo $site_count?>" data-animdelay="35"><span><?php echo $site_count_start?></span></h2>
                                    <br>
                                    <h3>TOPLAM SİTE</h3>
                                </div>
                            </div>
                            <!-- stats_single ends -->

                            <!-- stats_single starts -->
                            <div class="span3 stats_single">
                                <div class="stats_icon">
                                    <i class="fa fa-tumblr"></i>
                                </div>
                                <div class="stats_hgroup">
                                    <h2 class="countPercentage animated" data-percentageto="<?php echo $theme_count?>" data-animdelay="35"><span>0</span></h2>
                                    <br>
                                    <h3>TEMA SAYISI</h3>
                                </div>
                            </div>
                            <!-- stats_single ends -->

                            <!-- stats_single starts -->
                            <div class="span3 stats_single">
                                <div class="stats_icon">
                                    <i class="fa fa-facebook"></i>
                                </div>
                                <div class="stats_hgroup">
                                    <h2 class="countPercentage animated" data-percentageto="<?php echo $like_count?>" data-animdelay="35"><span><?php echo $like_count_start?></span></h2>
                                    <br>
                                    <h3>FACEBOOK BEĞENİ</h3>
                                </div>
                            </div>
                            <!-- stats_single ends -->

                        </div>
                        <!-- folio_stats ends -->

                    </div>
                </div>

            </div>
        </section>
        <!-- sec-quote1 ends -->

        <!-- sec-about starts -->
        <section id="sec-about" class="section_container">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <article>
                            <div class="hgroup">
                                <div class="heading_cover">
                                    <h2>Bİz KİMİZ?</h2>
                                </div>
                                <div class="heading_cover">
                                    <h3>HEDEFİMİZ HERKESE WEB SİTESİ SAĞLAMAK</h3>
                                </div>
                                <div class="heading_cover span5 span_center">
                                    <h4>Web sitesi kurulumunda kullanıcıları detaylarla uğraştırmadan en kolay şekilde sitelerini tasarlamalarını sağlamaya yardım etmeye çalışıyoruz.</h4>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- team_tab start -->
                    <div class="span12 team_block">
                        <div id="bx-pager" class="team_thumbs">
                            <a data-slide-index="0" href=""><img src="<?php echo base_url()?>files/home/images/team_members/team_member_1.jpg" alt="CAN KÜÇÜKYILMAZ" /></a>
                            <a data-slide-index="1" href=""><img src="<?php echo base_url()?>files/home/images/team_members/team_member_2.jpg" alt="OKAN İMAMOĞLU" /></a>
                            <a data-slide-index="2" href=""><img src="<?php echo base_url()?>files/home/images/team_members/team_member_3.jpg" alt="SAADETTİN SİVAZ" /></a>
                            <a data-slide-index="3" href=""><img src="<?php echo base_url()?>files/home/images/team_members/team_member_4.jpg" alt="Siz Olabilirsiniz" /></a>
                        </div>
                        <ul class="teamslider">
                            <li class="member_1">
                                <div class="team_detail span5">
                                    <h2>CAN </h2>
                                    <h2>KÜÇÜKYILMAZ</h2>
                                    <h3>KURUCU, ÖNYÜZ GELİŞTİRİCİ</h3>
                                    <p>Çocukluğundan beri javascript'e hayran olan Can, Çanakkale Onsekiz Mart Üniversitesi mezunudur. Sincapp'ı da Üniversite 4. Sınıfta kurmuştur. Hali hazırda Sincapp'ın önyüz geliştirmesini yapmaktadır.</p>
                                    <ul class="team_social">
                                        <li><a rel="nofollow" href="https://www.facebook.com/cannkucukyilmaz" target="blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a rel="nofollow" href="https://twitter.com/cankucukyilmaz" target="blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a rel="nofollow" href="https://plus.google.com/103712634225020685276/posts" target="blank"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="member_2">
                                <div class="team_detail span5">
                                    <h2>OKAN</h2>
                                    <h2>İMAMOĞLU</h2>
                                    <h3>PAZARLAMA SORUMLUSU</h3>
                                    <p>Aslında Bilgisayar ve Öğretim Teknolojileri Eğitimi Bölümü mezunu olan Okan, programlama yapmanın yanında pazarlama yapmayı da çok sever. Hali hazırda Sincapp'ın pazarlama ayağını üstelenmiş bulunmaktadır.</p>
                                    <ul class="team_social">
                                        <li><a rel="nofollow" href="https://www.facebook.com/okan.imamoglu" target="blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a rel="nofollow" href="jhttps://plus.google.com/u/0/102213228720658324761/posts" target="blank"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="member_3">
                                <div class="team_detail span5">
                                    <h2>SAADETTİN</h2>
                                    <h2>SİVAZ</h2>
                                    <h3>BACKEND GELİŞTİRİCİ</h3>
                                    <p>Uygulama arkaplan tasarımları yapmayı çok seven Saadettin, Sincapp'ın arkaplan tasarımcısıdır.Php sever, Laravel'e bayılır. Hali hazırda Sincapp'ın backend sorumlusudur.</p>
                                    <ul class="team_social">
                                        <li><a rel="nofollow" href="https://www.facebook.com/saadettin" target="blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a rel="nofollow" href="https://twitter.com/memfis61" target="blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a rel="nofollow" href="https://plus.google.com/u/0/107893030350002372776/posts" target="blank"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="member_4">
                                <div class="team_detail span5">
                                    <h2>Siz</h2>
                                    <h2>Olabilirsiniz!</h2>
                                    <h3>Yetenekli programcılar arıyoruz.</h3>
                                    <p>Eğer javascriptte iyiyseniz ve binlerce kullanıcıya web sitesi yapma fikri size cazip geliyorsa sizi de aramızda görmekten mutluluk duyarız.</p>
                                    <ul class="team_social">
                                        <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-youtube"></i></a></li>
                                        <li><a href="javascript:void(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>


                    </div>
                    <!-- team_tab end -->


                    <!-- custom_text_widget starts -->					
                    <div class="span6">
                        <div class="custom_text_widget">
                            <div class="row">
                                <div class="span2">
                                    <h4>HAKKIMIZDA BİRKAÇ SÖZ</h4>
                                </div>
                            </div>

                            <p>Yaptığımız işi eğlenerek yapmaya çalışan küçük bir ekibiz. Programlama bizim için bir eğlence kaynağıdır. </p>
                            <p>Bizim eğlenmemizin yanında kullanıcılarımızın da eğlenmesi ana prensiplerimizden birisi. Eğer kullanıcılar aşırı detaylarla boğuşuyor, sistemi kullanamıyorlarsa bu hem kullanıcılarımızı hem de bizi üzer.</p>
                        </div>
                    </div>
                    <!-- custom_text_widget ends -->


                    <!-- widget_kraft_custom_video ends -->
                    <div class="span6">
                        <div class="responsive_video">
                        <iframe src="//player.vimeo.com/video/45170208" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    </div>
                    <!-- widget_kraft_custom_video ends -->

                    <div class="clear"></div>
                </div>
            </div>
        </section>
        <!-- sec-about ends -->
    <!-- sec-blog starts -->
    <section id="sec-blog" class="section_container">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <article>
                        <div class="hgroup">
                            <div class="heading_cover">
                                <h2>Blog'da Son Durum</h2>
                            </div>
                            <div class="heading_cover">
                                <h3>YENİ FİKİRLER <span>HİÇ</span> BİTMEZ</h3>
                            </div>
                            <div class="heading_cover span5 span_center">
                                <h4>Sincapp hakkında son gelişmeler, duyurular ve fazlası.</h4>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- blog_post starts -->
                <div class="span12 hm_blog_post content_bar">
                    <div class="row">
               <?php foreach($posts as $post):?>

                      <div class="span6 post">
                        <div class="featured_holder">
                            <div class="date text-center">
                                  <span class="date_day"><?php echo $post['day']?></span>
                                  <span class="date_month"><?php echo $post['month']?></span>
                              </div>
                              <div class="featured_image">
                                <a href="<?php echo base_url() . "blog/post/". $post['id'];?>">
                                    <img src="<?php echo base_url() . "files/photos/sincapp/blog/" . $post['photo_path'] . "/photo_430" . $post['photo_ext'] ?>" alt="featured_images">
                                  </a>
                              </div>
                          </div>
                          <div class="title_holder">
                            <div class="post_title">
                            <h2>  <a href="<?php echo base_url() . "blog/post/". $post['id'];?>"><?php echo $post['title']?></a></h2>
                              </div>
                          </div>
                          <div>
                                <?php echo substr($post['body'], 0, 255)?>
                          </div>
                          <a class="folio-link-url" href="<?php echo base_url() . "blog/post/". $post['id']?>">Devamını Oku <i class="fa fa-long-arrow-right"></i></a>
                      </div>
                        
                <?php endforeach;?>
                    </div>
                </div>
                <!-- blog_post ends-->
            </div>
        </div>
    </section>
    <!-- sec-blog ends -->                     
        <!-- sec-quote3 starts -->
        <section id="sec-quote3" class="parallex_wrapper">
            <div class="parallex_folio">
                <div class="container parallax_container">
                    <div class="row">
                        <div class="span8 span_center animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInUp">
                            <div id="dg-container" class="dg-container">
                                <div class="dg-wrapper">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url()?>files/home/images/3D_slider/slider_img_1.png" alt="image01">
                                        <div>
                                            <blockquote class="qoute">
                                                <p>Joomla'da 5 dk'da yaptığım şeyi Sincapp'la 5 sn'de yaptım. Gerçekten kolay kullanımlı bir araç. Son kullanıcı için böyle şeylere gerek var diye düşünüyorum. Tebrikler Sincapp.</p>
                                                <strong>-  Serkan Aygün, BİLGİ İŞLEM SORUMLUSU</strong>
                                            </blockquote>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);"><img src="<?php echo base_url()?>files/home/images/3D_slider/slider_img_2.png" alt="image02">
                                        <div>
                                            <blockquote class="qoute">
                                                <p>Yıllardır amatör olarak websitesi yapmaktayım. Ama her şeyi sürükle&bırakla yapmak büyük konfor. Kodlarla hiç uğraşmadan sitelerimi artık Sincapp'la yapıyorum.</p>
                                                <strong>-  Mesut Yılmaz, GİRİŞİMCİ</strong>
                                            </blockquote>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);"><img src="<?php echo base_url()?>files/home/images/3D_slider/slider_img_3.png" alt="image03">
                                        <div>
                                            <blockquote class="qoute">
                                                <p>Uygulama gayet güzel ve bir o kadar da kullanışlı. Taşıyarak düzenleme özelliği çok kullanışlı. Kullanılmaya değer bir uygulama. </p>
                                                <strong>Ediz Süleyman - Bilgisayar Mühendisi</strong>
                                            </blockquote>
                                        </div>
                                    </a>
                                </div>
                                <nav>	
                                    <span class="dg-prev"><a href="#"><i class="fa fa-angle-left"></i></a></span>
                                    <span class="dg-next"><a href="#"><i class="fa fa-angle-right"></i></a></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- sec-quote3 ends -->

        <!-- sec-contact starts -->
        <section id="sec-contact" class="section_container section_contact">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <article>
                            <div class="hgroup">
                                <div class="heading_cover">
                                    <h2>İLETİŞİM</h2>
                                </div>
                                <div class="heading_cover">
                                    <h3> BİZİMLE <span>İLETİŞİME</span> GEÇİN.</h3>
                                </div>
                                <div class="heading_cover span5 span_center">
                                    <h4>Her türlü soru, görüş ve öneriniz için aşağıdaki formu kullanabilirsiniz.</h4>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!-- contact_area starts -->
                    <div class="span10 span_center contact_area">
                        <div class="row">
                            <!-- contact_info starts -->
                            <div class="span4 contact_info animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInLeft">
                                <!-- info_single info_address starts -->
                                <div class="row info_single info_address">
                                    <div class="span1">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="span3">
                                        <p class="address_street">Alveal Ltd. Şti.</p>
                                        <p class="address_city">Ufuktepe Mah. Sevenler Sk. No:2/17</p>
                                        <p class="address_country">Keçiören / Ankara</p>
                                    </div>
                                </div>
                                <!-- info_single info_address ends -->

                                <!-- info_single info_tel starts -->
                                <div class="row info_single info_tel">
                                    <div class="span1">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="span3">
                                        <p class="tel_1">0312 580 37 47</p>
                                     </div>
                                </div>
                                <!-- info_single info_tel ends -->
                            </div>
                            <!-- contact_info ends -->

                            <!-- contact_form starts -->
                            <div class="span6 contact_form animated" data-animdelay="0.2s" data-animspeed="1s" data-animrepeat="0" data-animtype="fadeInRight">
                                <form novalidate  method="post" action="index.html">
                                    <span class="field_single">
                                        <input type="text" placeholder="İsim Soyisim" value="" name="full_name">
                                    </span>
                                    <span class="field_single">
                                        <input type="email" placeholder="E-Posta" value="" name="email">
                                    </span>
                                    <span class="field_single">
                                        <textarea placeholder="Mesaj" name="message"></textarea>
                                    </span>
                                    <input id="btn_submit_contact" type="submit" value="Gönder">
                                    <input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">

                                </form>
                            </div>
                            <!-- contact_form ends -->
                        </div>

                    </div>
                    <!-- contact_area ends -->
                </div>

            </div>
        </section>
        <!-- sec-contact ends -->

        <!-- sec-map starts 
        <section class="sec-map">
            <div class="container">
                <a class="toggle_section_button toggle_map_btn" href="#map_contact"><i class="fa fa-map-marker"></i> Harita</a>
            </div>
            <div id="map_contact" class="google_map">
            </div>
        </section>
        sec-map ends -->

        <?php $this->load->view('footer_view');?>
<script type="text/javascript">
    var base_url = "<?php echo base_url()?>";
</script>
<?php if(ENVIRONMENT == "production"):?>
        <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>    
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/home.min.js'></script>
<?php else:?>
        <!-- Modernizr -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/modernizr.custom.53451.js'></script>
        <!-- placeholder -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.placeholder.js'></script>
        <!-- Sticky JS file -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.sticky.js'></script>

        <!-- Navigation Scroll TO JS file -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.scrollTo.js'></script>
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.nav.js'></script>
        <!-- jquery.magnific-popup -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.magnific-popup.js'></script>
        <!-- Masonary Isotope -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.isotope.js'></script>

        <!-- Parallax JS Flie -->
        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.parallax-1.1.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.localscroll-1.2.7-min.js"></script>

        <!-- 3D slider JS File -->
        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.3dgallery.js"></script>

        <!-- BX slider file -->
        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.bxslider.js"></script>

        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.easing.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/responsiveslides.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>files/home/js/jquery.fitvids.js"></script>

        <!-- Google Maps Library -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/gmap3.js'></script>

        <!-- Main and Project Loading JSfiles -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/main_home.js'></script>
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/project_script.js'></script>

        <!-- form scripts -->
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/jquery.validate.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url()?>files/home/js/script_mail.js'></script>

        <!-- Animation Jquery -->
        <script src="<?php echo base_url()?>files/home/js/animation.js"></script>
        <!-- General Script -->
        <script src="<?php echo base_url()?>files/home/js/script_general.js"></script>

<?php endif?>
<?php $this->load->view('analytics_view')?>

    </body>
</html>