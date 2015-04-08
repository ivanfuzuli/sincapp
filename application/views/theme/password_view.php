<form class="password-form" method="post" action="<?php echo base_url()?>password.do">
<h3>Lütfen şifre giriniz.</h3>
<?php if($password):?>
	<span class="red-line">Hatalı şifre girdiniz.</span>
<?php endif;?>
<input type="password" name="password"><br>
<input class="btn btn-primary" type="submit" value="Giriş">
<input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">
</form>
