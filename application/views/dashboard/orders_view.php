<div class="modal fade">
   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Siparişlerim</h3>
  </div>

  <div class="modal-body">
      <div class="row">
            <div class="span6" id="dialog_alert"></div>
      </div>
      <div class="row">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Sipariş No</th>
                  <th>Alanadı</th>
                  <th>Sipariş Tutarı</th>
                  <th>Tarih</th>
                  <th>Durumu</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($orders as $order):
              $bold = null;
              if($order['user_read'] == false) {
                  $bold = "style=font-weight:bold";
              }
              ?>
              <tr <?php echo $bold?>>
                <td><?php echo $order['id']?></td>
                <td><?php echo $order['domain']?></td>
                <td><?php echo $order['price']?> TL</td>
                <td><?php echo $order['date']?>
                <td>
                  <?php 
                $status = $order['status'];
                ?>
                <?php if($status == 0 || $status == 1):?>
                <span class="label">Onay Bekliyor...</span>
                <?php endif;?>
                <?php if($status == 2):?>
                <span class="label label-success">Onaylandı.</span>
                <?php endif;?>
                <?php if($status == 3):?>
                <span class="label label-important">Reddedildi.</span>
                <?php endif;?>
              </td>
              </tr>
              <?php endforeach;?>
            </tbody>
            </table>
      </div>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal"><?php echo lang('but_close')?></button>
  </div>
                         

</div>
