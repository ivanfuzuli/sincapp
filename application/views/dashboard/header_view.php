<div id="loading"></div>
<div id="hover">
    <div class="hoverTri"></div>
        <div id="hoverContent">
            <?php echo lang('str_loading')?>
        </div>
</div>
<div class="header_wrap">
    <div class="container">
        <div class="row">
            <div class="span4">
                <img id="logo" src="<?php echo base_url()?>/files/css/images/logo.png" width="180" height="63" />        
            </div>
            <div class="span8">
                <div class="topright">
                    <ul class="nav nav-pills">
                        <li><span><?php echo $email?></span></li>
                      <li>
                        <a href="<?php echo base_url()?>home/landing">Ana Sayfa</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url()?>dashboard">Panel</a>
                      </li>
                        <li class="position-relative">
                            <?php if($unread!=false): echo "<span id=\"unread\" class=\"unread\">".$unread."</span>"; endif;?>
                            <a href="#" data-action="<?php echo base_url()?>dashboard/last_feeds" id="messages_but">Bildirimler</a>
                        </li>
                      <li class="position-relative">
                        <?php if($unread_order!=0): echo "<span id=\"unread_orders\" class=\"unread\">".$unread_order."</span>"; endif;?>                        
                        <a href="#" data-url="<?php echo base_url()?>dashboard/orders" id="orders_but"><?php echo lang('but_orders');?></a></li>                        
                      <li><a href="#" data-url="<?php echo base_url()?>dashboard/setting" id="setting_but"><?php echo lang('but_settings');?></a></li>
                      <li><a href="<?php echo base_url()?>dashboard/logout"><?php echo lang('but_log_out');?></a></li>
                    </ul>                            
                </div>
            </div>
        </div>
    </div>
</div>