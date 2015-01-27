	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
		<div class="information">
			<?php echo sprintf($this->translate('dejaInscritMsg'), $this->url(array('controller'=>'client','action'=>'login'))); ?>
		</div>
		<?php echo $this->form; ?>
		</div>	
	</div>