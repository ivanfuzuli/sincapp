<div class="hfeed site page">
    <header id="header" role="banner" class="site-header masthead">
        <hgroup>
            <h1 class="site-title">
                <?php echo $logo?>
            </h1>
        </hgroup>
        <nav id="navigation" class="site-navigation main-navigation" role="navigation">
            <h1 class="assistive-text">Menu</h1>
            <div class="assistive-text skip-link">
                <a title="Skip to content" href="#content">
                    Skip to content
                </a>
            </div>
            <div class="menu-menu-1-container">
                <ul  id="nav_bar" class="menu menu-menu-1">
                    <?php echo $navigation?>           
                </ul>
            </div>      
        </nav>
    </header>

    <div class="site-main" id="main">
        <div class="content-area" id="primary">
            <div role="main" class="site-content" id="content">
                <article class="post type-post status-publish format-standard hentry category-uncategorized">
                    <div id="cover-photo" class="entry-content">
                        <?php if($cover_photo):?>
                        <?php echo $cover_photo;?>
                        <?php endif;?>              
                    </div>
                    <div class="wrapper">
                        <div id="middle">
                            <?php echo $middle?> 
                        </div>
                    </div>
                    <footer  id="footer"  class="entry-meta">
                        <div  id="footerText" class="site-info">
                            <?php echo $footer?>
                        </div>
                    </footer>
                </article>
            </div>
        </div>
    </div>
</div>