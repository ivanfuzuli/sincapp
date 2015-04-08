<div class="modal fade">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Geribildirimler</h3>
  </div>

  <div class="modal-body">
    <?php echo $feeds ?>
<form id="reply" data-action="<?php echo base_url()?>dashboard/reply" action="#" method="post">
    <input type="hidden" name="thread_id" value="<?php echo $thread_id?>" />
    <textarea name="message" class="span6"></textarea><input type="submit" class="btn btn-primary" value="Cevapla"/>
</form>
</div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Kapat</button>
    </div>
</div>