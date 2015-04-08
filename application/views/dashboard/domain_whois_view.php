			<table class="table table-striped">
	  			<thead>
	  				<tr>
	  					<th>Alan Adı</th>
	  					<th>Durum</th>
	  					<th>Satın Al</th>
	  				</tr>
	  			</thead>
	  			<tbody>
	  			<?php 
	  			foreach ($json as $key => $value):?>
	  				<tr>
	  					<td><?php echo bolder_tdl($key)?></strong></td>
	  					<td>
	  					<?php if($value['status'] == "available"):?>
	  					<span class="label label-success">Uygun</span>
	  						<?php else:?>
	  					<span class="label label-important">Satın Alınmış</span>
	  						<?php endif;?>
	  					</td>
	  					<td>
	  					<?php if($value['status'] == "available"):?>
	  						<a href="<?php echo base_url() ."dashboard/buy/" . $site_id . "/". $key?>" class="btn btn-success">Satın Al</a>
	  					<?php else:?>
	  						<a href="#exist-notify" data-href="<?php echo base_url() ."dashboard/buy/" . $site_id . "/". $key?>/existing" data-name="<?php echo $key?>" class="btn btn-existing-domain">Bu Adres Bende</a>
	  					<?php endif;?>
	  					</td>
	  				</tr>
	  			<?php endforeach?>  				
	  			</tbody>
			</table>