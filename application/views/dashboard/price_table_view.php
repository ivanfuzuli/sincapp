<!--First Container!-->
<div class="firstcontainer">

<!--Table 1 Skin1!-->
<div class="planbg button float"><!--planbg div begins here!-->
<div class="topbar skinonebg"></div>
<div class="plantype">
<h5>BAŞLANGIÇ</h5>
<span class="skinonecolor">Ücretsiz</span>
<p>/yıllık</p>
</div>
<!--Features List Begins here!-->
<div class="features">
            <li><i class="fa fa-check green"></i> 512 MB Alan </li>
            <li class="plancolor"><i class="fa fa-check green"></i> 1 Gb Bant Genişliği</li>
            <li><i class="fa fa-times red"></i> 0 Adet E-Posta</li>
            <li class="plancolor"><i class="fa fa-times red"></i> Bedava Alan Adı</li>
            <li><i class="fa fa-times red"></i> 7/24 E-Posta Desteği</li>
            <li class="plancolor"><i class="fa fa-times red"></i> Reklam Yok</li>
            <li><i class="fa fa-times red"></i> Sincapp İmzası Kaldırma</li>
</div>
<!--Features List Ends here!-->
<?php if(!$no_buy_link):?>

<?php endif?>
</div><!--planbg div ends here!-->
<!--Table 2 Skin1!-->
<div class="planbg planborder float"><!--planbg div begins here!-->
<div class="topbar skinonebg"></div>
<div class="plantype <?php echo !$existing ? ""  : "plantype-through"?>">
<h5>KİŞİSEL</h5>
<?php if(!$existing):?>
<span class="skinonecolor">69 TL</span>
<?php else:?>
<p><span class="skinonecolor line-through">69 TL</span></p>
<span class="skinonecolor">49 TL</span>
<?php endif;?>
<p>/yıllık</p>
</div>
<!--Features List Begins here!-->
<div class="features">
            <li><i class="fa fa-check green"></i> 1 GB Alan </li>
            <li class="plancolor"><i class="fa fa-check green"></i> 2 GB Bant Genişliği</li>
            <li><i class="fa fa-check green"></i> 2 Adet E-Posta</li>
            <li class="plancolor"><i class="fa <?php echo !$existing ? "fa-check green"  : "fa-times red"?>"></i> Bedava Alan Adı</li>
            <li><i class="fa fa-check green"></i> 7/24 E-Posta Desteği</li>
            <li class="plancolor"><i class="fa fa-check green"></i> Reklam Yok</li>
            <li><i class="fa fa-times red"></i> Sincapp İmzası Kaldırma</li>
</div>
<!--Features List Ends here!-->
<?php if(!$no_buy_link):?>
<div class="requestbg skinonerequest">
<?php 
$url = base_url() . "dashboard/details/" . $site_id . "/". $domain . "/personal";
      if($existing) {
            $url .= "/existing";
      } else {
            $url .= "/new";
      }
?>
<li><a href="<?php echo $url?>">Bu Paketi Seç !</a></li>
</div>
<?php endif?>
</div><!--planbg div ends here!-->
<!--Table 3 Skin1!-->
<div class="planbg planborder skinonebg float"><!--planbg div begins here!-->
<div class="topbar skinonebg"></div>
<div class="plantype <?php echo !$existing ? ""  : "plantype-through"?>">
<h5 class="featuredcolor">İŞLETME</h5>
<?php if(!$existing):?>
<span class="featuredcolor">89TL</span>
<?php else:?>
<p><span class="featuredcolor line-through">89 TL</span></p>
<span class="featuredcolor">69 TL</span>
<?php endif;?>
<p class="featuredcolor">/yıllık</p>
</div>
<!--Features List Begins here!-->
<div class="features skinonefeatures">
            <li><i class="fa fa-check skinonecheck"></i> 5 GB Alan </li>
            <li class="skinoneplancolor"><i class="fa fa-check skinonecheck"></i>10 GB Bant Genişliği</li>
            <li><i class="fa fa-check skinonecheck"></i> 10 Adet E-Posta</li>
            <li class="skinoneplancolor"><i class="fa <?php echo !$existing ? "fa-check green"  : "fa-times red"?>"></i>Bedava Alan Adı</li>
            <li><i class="fa fa-check skinonecheck"></i>7/24 E-Posta Desteği</li>
            <li class="skinoneplancolor"><i class="fa fa-check skinonecheck"></i> Reklam Yok</li>
            <li><i class="fa fa-check skinonecheck"></i> Sincapp İmzası Kaldırma</li>
</div>
<?php if(!$no_buy_link):?>
<!--Features List Ends here!-->
<div class="requestbg skinonerequest skinonefeaturedreq">
<?php
      $url =  base_url() . "dashboard/details/" . $site_id . "/". $domain . "/business";
      if($existing) {
            $url .= "/existing";
      } else {
            $url .= "/new";
      }
?>
<li><a href="<?php echo  $url?>">Bu Paketi Seç !</a></li>
</div>
<?php endif?>
</div><!--planbg div ends here!-->
<!--Table 4 Skin1!-->
<div class="planbg planborder float"><!--planbg div begins here!-->
<div class="topbar skinonebg"></div>
<div class="plantype <?php echo !$existing ? ""  : "plantype-through"?>">
<h5>BÜYÜK</h5>
<?php if(!$existing):?>
<span class="skinonecolor">149 TL</span>
<?php else:?>
<p><span class="skinonecolor line-through">149 TL</span></p>
<span class="skinonecolor">129 TL</span>
<?php endif;?>
<p>/yıllık</p>
</div>
<!--Features List Begins here!-->
<div class="features">
            <li><i class="fa fa-check green"></i> 10 GB Alan </li>
            <li class="plancolor"><i class="fa fa-check green"></i> 20 GB Bant Genişliği</li>
            <li><i class="fa fa-check green"></i> 30 Adet E-Posta</li>
            <li class="plancolor"><i class="fa <?php echo !$existing ? "fa-check green"  : "fa-times red"?>"></i> Bedava Alan Adı</li>
            <li><i class="fa fa-check green"></i> 7/24 E-Posta Desteği</li>
            <li class="plancolor"><i class="fa fa-check green"></i> Reklam Yok</li>
            <li><i class="fa fa-check green"></i> Sincapp İmzası Kaldırma</li>
</div>
<?php if(!$no_buy_link):?>
<!--Features List Ends here!-->
<div class="requestbg skinonerequest">
<?php 
$url = base_url() . "dashboard/details/" . $site_id . "/". $domain . "/big";
      if($existing) {
            $url .= "/existing";
      } else {
            $url .= "/new";
      }
?>
<li><a href="<?php echo $url?>">Bu Paketi Seç !</a></li>
</div>
<?php endif?>
</div><!--planbg div ends here!-->

<div class="clear"></div>
</div><!--First Container Ends!-->