<h3>Geribildirimler</h3>

<table class="table table-striped">
    <thead>
        <th>Gönderen</th>
        <th>Mesaj</th>
        <th>Tarih</th>
    </thead>
    <tbody>
<?php foreach($feedbacks as $feed):?>
    <tr class="feed <?php if($feed['read'] == false): echo "unread"; endif?>" data-url="<?php echo base_url()."kokpit/feedbacks/read/".$feed['thread_id']?>">
        <td><?php echo $feed['email']?></td>
        <td><?php echo $feed['message']?></td>
        <td><?php echo time_converter($feed['date'])?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>