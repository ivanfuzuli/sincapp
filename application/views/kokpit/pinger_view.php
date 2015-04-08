<h3>Site Haritaları</h3>
<form method="post" action="<?php echo base_url()?>kokpit/pinger/ping">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Siteid</th>
            <th>Adres</th>
            <th>Son İşlem</th>
            <th>Son Ping</th>   
            <td><input type="checkbox" name="checkall" /></td>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="submit" class="btn btn-primary" value="Pingle"/></td>
        </tr>
    </tfoot>
    <tbody>
<?php foreach($sitemaps as $map): ?>
        
        <tr>
            <td><?php echo $map->site_id?></td>
            <td><a href="http://<?php echo $map->sitename?>.sincapp.com/"><?php echo $map->sitename?></a></td>
            <td><?php echo time_converter($map->lastmod)?></td>
            <td><?php echo time_converter($map->sitemapsend)?></td>
            <td><input type="checkbox" name="ping[]" value="<?php echo $map->site_id?>" /></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
</form>