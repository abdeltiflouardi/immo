	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
			<div class="noError">
<?php echo sprintf($this->translate('successContact'), $this->url(array('controller'=>'','action'=>''), 'default')); ?>
			</div>
		</div>	
	</div>