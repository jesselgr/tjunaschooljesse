	<p><strong>Contactformulier / Aanmelding</strong></p>
		<?=form_open('datahandler/send_mail/'.$currentPage)?>
			<?=form_hidden('contact', true)?>
			<?php echo form_label('Naam:', 'name'); ?>
			<p>
				<?php echo form_input(array('name'=>'name', 'class'=> 'inputField'));?>
			</p>
			<?php echo form_label('Email:', 'mail'); ?>
			<p>
				<?php echo form_input(array('name'=>'mail', 'class'=> 'inputField'));?>
			</p>
			<?php echo form_label('Bericht:', 'message'); ?>
			<p>
				<?php echo form_textarea(array('name'=>'message', 'class'=> 'inputField Large'));?>
			</p>
			
			<p><?= form_label('Ik wil uitnodigingen ontvangen voor tentoonstellingen:','inmenu')?></p>
				<p><?=form_checkbox('subscribe', true, true)?></p>	
			<p>
				<?=form_submit(array('class' => 'buttonContent','value'=>'Versturen'))?>
			</p>
		
		
		<?=form_close();?>
	