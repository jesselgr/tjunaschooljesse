		<?php
		$ac_cms_message 		= (!empty($ac_cms_message)) ? $ac_cms_message : $this->session->flashdata('ac_cms_message');
		$ac_cms_error_message 	= (!empty($ac_cms_error_message)) ? $ac_cms_error_message : $this->session->flashdata('ac_cms_error_message');
		?>	
			<p class="changeMessage">
				<span><?=$ac_cms_message?></span>
			</p>
		
			
			
			<p class="errorMessage">
				<span><?=$ac_cms_error_message?></span>
			</p>
				<?php if($ac_cms_message) : ?>
			<script>$('.changeMessage').show().delay(3000).fadeOut();</script>
			<?endif;
			if($ac_cms_error_message) :?>
			<script>$('.errorMessage').show().delay(3000).fadeOut();</script>
			<?php endif;?>				