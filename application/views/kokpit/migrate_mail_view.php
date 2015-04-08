<form action="<?php echo base_url()?>kokpit/migrate_mail/add" method="post">
<textarea name="mails" class="add_mail" style="width: 100%; height: 100px">
</textarea>
<input type="hidden" name="_token" value="<?php echo $this->security->get_csrf_hash();?>">
<input type="submit" class="btn btn-primary" value="Ekle">
</form>

<table>
	<thead>
		<th>E-Posta</th>
		<th>Mail At</th>
		<th>Bağlan</th>
		<th>Geçici Şifre</th>
	</thead>
	<tbody>
		<?php foreach($mails as $mail):?>
		<tr>
			<td><?php echo $mail->email?></td>
			<td>
				<?php if($mail->mailed_status == FALSE):?>
				<a href="#" class="btn btn-success send-mail" data-url="<?php echo base_url().'/kokpit/migrate_mail/send/'.$mail->id?>">Mail At</a>
				<?php else:?>
				<?php echo $mail->mailed_date?>
				<?php endif?>
			</td>
			<td>
				<?php if($mail->added_status == FALSE):?>
				<a href="#" class="btn btn-success connect-mail" data-url="<?php echo base_url().'/kokpit/migrate_mail/connect/'.$mail->id?>">Bağlan</a>
				<?php else:?>
				Bağlandı.
				<?php endif;?>
			</td>
			<td><?php echo $mail->password?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>