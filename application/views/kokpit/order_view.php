<h3>Siparişler</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Site ID</th>
            <th>User ID</th>
            <th>Domain</th>
            <th>Paket</th>
            <th>Tarih</th>   
            <td></td>
        </tr>
    </thead>
    <tbody>
<?php foreach($orders as $order): ?>
        
        <tr>
            <td><?php echo $order->id?></td>
            <td><?php echo $order->site_id?></td>
            <td><?php echo $order->user_id?></td>
            <td><?php echo $order->domain?></td>
            <td><?php echo $order->package?></td>
            <td><?php echo $order->created_at?></td>
            <td>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/buy/<?php echo $order->id?>" class="buy-domain btn btn-small btn-success btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Domaini AL</a><br>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/set_domain/<?php echo $order->id?>" class="set-domain btn btn-small btn-success btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Domaini Ayarla</a><br>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/set_dns/<?php echo $order->id?>" class="set-domain btn btn-small btn-success btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Dns'leri Ayarla</a><br>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/set_yandex/<?php echo $order->id?>" class="set-domain btn btn-small btn-success btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Yandex'e Bağla</a><br>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/reject_order/<?php echo $order->id?>" class="close-order btn btn-small btn-danger btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Siparişi İptal Et</a><br>
                <a href="#" data-url="<?php echo base_url()?>kokpit/orders/close_order/<?php echo $order->id?>" class="close-order btn btn-small btn-danger btn-90" data-loading-text="Yükleniyor..." data-complete-text="Tamamlandı!">Sipariş Tamamlandı</a><br>
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