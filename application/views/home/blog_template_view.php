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
        <title><?php echo $title?></title>
        <meta name="description" content="<?php echo $description?>"/>
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
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-home">Ana Sayfa</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-services">Servisler</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-portfolio">Temalar</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-about">Hakkımızda</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-blog">Blog</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>home/landing#sec-contact">İletişim</a>
                                </li>
                            </ul>
                        </nav>
                        <!-- main-nav ends-->
                    </div>
                </div>
            </div>
        </header>
        <!-- menu-bar ends -->
    
    <!-- internal_header starts -->
    <section class="section_container internal_header">
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
            </div>
        </div>
    </section>
    <!-- internal_header ends -->
    
    <!-- sec-blog starts -->
    <section class="content_area">
        <div class="container">
            <div class="row">
                <!-- content_bar starts -->
                <div class="span8 content_bar">

                    <?php echo $content?>
                    
                </div>
                <!-- content_bar ends -->
                
                <!-- side_bar starts -->
                <aside>
                    <div class="side_bar span4">

                        
                        <!-- recent_entries starts-->
                        <div class="widget widget_recent_entries" id="recent-posts-2">
                            <h3 class="widget-title">Son Yazılar</h3>
                            <ul>
                                <?php foreach($last_posts as $post):?>
                                <li>
                                    <a title="<?php echo $post['title']?>" href="<?php echo base_url() . "blog/post/" . $post['id']?>"><?php echo $post['title']?></a>
                                    <span class="post-date"><?php echo $post['day'] . " " . $post['month'] . " " . $post['year'] ?></span>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <!-- recent_entries ends-->
                        
                        <!-- widget_text starts-->
                        <div class="widget widget_text" id="text-2">
                            <h3 class="widget-title">Sincapp Hakkında</h3>
                            <div class="textwidget"> Sincapp Sürükle&Bırak ile kurulabilen hazır web sitesi platformudur. Kullanıcılar hiçbir teknik bilgiye gereksinim duymadan Sincapp kullanarak kendi web sitelerini hazırlayabilir
                                
                            </div>
                        </div>
                        <!-- widget_text ends-->
                        
                        
                    </div>
                </aside>
                <!-- side_bar ends -->
                
            </div>
        </div>
    </section>
    <!-- sec-blog ends -->  
    </body>
</html>