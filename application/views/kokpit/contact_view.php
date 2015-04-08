<h3>İletişim Formları</h3>

<?php foreach($contacts as $c):?>
<div class="contact">
    <span class="contact_date"><?php echo $c->send_date?></span>
    <div class="contact_body">
        <b><?php echo $c->name?></b><?php if($c->statu==0):?><span class="newInfo">Yeni</span><?php endif?><br />
        <i><?php echo $c->email?></i><br />
        <quote><?php echo $c->message?></quote>
    </div>
    <div class="contact_footer" data-contact-id="<?php echo $c->contact_id?>">
        <button class="btn btn-mini unreadContact">Okunmadı</button><button class="btn btn-danger btn-mini deleteContact">Sil</button>
    </div>
</div>
<?php endforeach;?>
<div class="pagination">
    <ul>
<?php echo $pages?>
    </ul>
</div>