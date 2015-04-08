                    <?php foreach($posts as $post):?>

                    <!-- blog_post starts  ==>Image Post -->
               		<div class="blog_post">	
                        <div class="date text-center">
                            <span class="date_day"><?php echo $post['day']?></span>
                            <span class="date_month"><?php echo $post['month'] . " " . $post['year']?></span>
                        </div>
                        <div class="span7 post_content">
                            <div class="featured_image">
                                <img src="<?php echo base_url() . "files/photos/sincapp/blog/" . $post['photo_path'] . "/photo_670" . $post['photo_ext']?>" alt="post_img">
                            </div>
                            <div class="title_holder">
                                <div class="post_title">
                                <h2 class=""><a href="<?php echo base_url() . "blog/post/" . $post['id']?>"><?php echo $post['title']?></a></h2>
                                </div>
                                <div class="post_meta">
                                    <span class="post_author">AUTHOR: <a href="javascript:void(0);">admin</a> </span>
                                </div>
                            </div>
                            <div>
                            <?php echo substr($post['body'], 0, 255)?>
                            <a class="folio-link-url" href="<?php echo base_url() . "blog/post/" . $post['id']?>">Devamını Oku <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                        </div>
                    </div>
                    <!-- blog_post ends -->
                    <?php endforeach;?>
                    <!-- pagenavi starts -->
                    <div class="folio_navigation span7">
                        <div class="wp-pagenavi">
                            <ol class="pages-nav">
                            <?php echo $pages?>
                            </ol>
                        </div>
                    </div>
                    <!-- pagenavi ends -->                    