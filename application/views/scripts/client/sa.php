	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		
		<div id="ColRight">
		<?php 
			if(isset($this->annonce) && isset($this->annonce[0])): 
				$annonce = $this->annonce[0];
				unset($this->annonce);
		?>
			<div class="error">
				<?php echo $this->translate('confirmDelMsg'); ?>
				"<?php echo utf8_encode($annonce->accroche_annonce);?>"
			</div>			
		<?php else: ?>		
			<div class="error">
				<?php echo $this->translate('YouHaveNoAnnonce'); ?>
				<a href="<?php echo $this->url(array('action'=>'compte'));?>">Retour</a>
			</div>
		<?php endif; ?>
		</div>
	</div>