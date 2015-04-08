<?php foreach($messages as $message):
    $this->load->view('kokpit/read_single_view', array('message' => $message));
 endforeach; ?>

<form id="reply" class="well" action="#" method="post">
    <input type="hidden" name="user_id" value="0" />
    <input type="hidden" name="thread_id" value="<?php echo $thread_id?>" />
    <div class="controls">
        <textarea name="message" class="span7"></textarea>
    </div>
    <div class="controls">
        <input type="submit" class="btn btn-primary" value="Cevapla" />        
    </div>
</form>