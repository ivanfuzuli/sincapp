<h3>Blog</h3>
<?php if($this->session->flashdata('error')):?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>hata!</strong> <?php echo $this->session->flashdata('error')?>
</div>

<?php endif;?>
<form action="<?php echo base_url()?>kokpit/blog/create" method="post" enctype="multipart/form-data">
    <input type="file" name="filename">
    <input type="submit" class="btn btn-primary" value="EKLE">
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Başlık</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($posts as $post): ?>
        
        <tr>
            <td><?php echo $post['id']?></td>
            <td><?php echo $post['title']?></td>
            <td><a class="btn btn-danger" href="<?php echo base_url()?>kokpit/blog/delete/<?php echo $post['id']?>">Sil</a></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<div class="pagination">
    <ul>
<?php echo $pages?>
    </ul>
</div>