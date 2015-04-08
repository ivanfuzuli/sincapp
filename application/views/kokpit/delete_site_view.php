<h3>Siteler</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Userid</th>
            <th>Adres</th>
            <th>İşlem</th>   
        </tr>
    </thead>
    <tbody>
<?php foreach($sites as $site):?>
        <tr>
            <td><?php echo $site->site_id?></td>
            <td><?php echo $site->user_id?></td>
            <td><a href="<?php echo base_url()?>manage/editor/wellcome/<?php echo $site->site_id?>"><?php echo $site->sitename?></a></td>
            <td>
                <button class="btn btn-danger deleteSite" data-site-id="<?php echo $site->site_id?>">Sil</button>
                <a href="#" class="btn cancelSite" data-site-id="<?php echo $site->site_id?>">İptal</a>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<div class="pagination">
    <ul>
<?php echo $pages?>
    </ul>
</div>