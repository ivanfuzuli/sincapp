                    <!-- blog_post starts -->
                    <div class="blog_post"> 
                        <div class="date text-center">
                            <span class="date_day"><?php echo $post['day']?></span>
                            <span class="date_month"><?php echo $post['month'] . " " . $post['year']?></span>
                        </div>
                        <div class="span7 post_content">
                            <div class="featured_image">
                                <img src="<?php echo base_url() . "files/photos/sincapp/blog/" . $post['photo_path'] ."/photo_670" . $post['photo_ext'] ?>" alt="post_img">
                            </div>
                            <div class="title_holder">
                                <div class="post_title">
                                <h1><?php echo $post['title']?></h1>
                                </div>
                                <div class="post_meta">
                                    <span class="post_author">YAZAR: <a href="javascript:void(0);">admin</a> </span>
                                </div>
                            </div>
                            <div><?php echo $post['body']?></div>
                            
                            <!-- social_media starts -->
                            <div class="social_media">
                                <span>Bu hikayeyi paylaş @</span>
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url() . "blog/post/" . $post['id']?>"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/home?status=<?php echo base_url() . "blog/post/" . $post['id']?>"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url() . "blog/post/" . $post['id']?>&title=Sincapp Blog&summary=&source="><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="https://plus.google.com/share?url=<?php echo base_url() . "blog/post/" . $post['id']?>"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                            <!-- social_media starts -->
                        </div>
                    </div>

                    <!-- comments_section starts -->
                    <div id="comments_section" class="span7">
                        <section id="comments">
                            <h3>Yorumlar <i class="fa fa-comment-o"></i></h3>
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/tr_TR/sdk.js#xfbml=1&appId=1477115325853526&version=v2.0";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-comments" data-href="<?php echo base_url()?>blog/post/<?php echo $post['id']?>" data-width="670" data-numposts="5" data-colorscheme="light"></div>
                        <script type="text/javascript">
                        $(window).resize(function(){
                             $(".fb-comments").attr("data-width", $(".comments").width());
                             FB.XFBML.parse($(".comments")[0]);
                            });
                        </script>
                        </section><!-- /#respond -->
                    </div>
                    <!-- comments_section ends -->
                    <!-- blog_post ends -->
                    <!-- page_nav starts -->
                    <div class="page_nav span7">
                        <?php if($next):?>
                        <a class="next-post" href="<?php echo base_url() . "blog/post/" . $next ?>"><i class="fa fa-angle-right"></i></a>
                        <?php endif?>
                        <?php if($prev):?>
                        <a class="previous-post" href="<?php echo base_url() . "blog/post/" . $prev?>"><i class="fa fa-angle-left"></i></a>
                        <?php endif?>
                    </div>
                    <!-- page_nav ends -->