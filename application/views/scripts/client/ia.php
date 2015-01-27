	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		
		<div id="ColRight">
		<?php echo $this->translate('AnnoncePictures'); ?>
		<strong><?php echo utf8_encode($this->titre_annonce)?></strong>
		<div id="divDelMsg">&nbsp;</div>
		<div id="listeImages">
		<?php 
			foreach($this->images as $image): 
			$img = My_Functions::getImg('/public/images/offres/', $image['nom_image']);
			if(strpos( $img ,'defaut') !== false)continue;
		?>
			<div id="img<?php echo $image['id_image'];?>" class="divAImg" >
				<img 	src="<?php echo $img; ?>" 
						width="100px" 
						height="100px" 
				/><br />
				<a href="javascript:void(0);" onclick="supImg(<?php echo $image['id_image'];?>);">supprimer</a>
			</div>
			
		<?php endforeach; ?>
		<div class="clear"></div>
		</div>
		
		<?php echo $this->form; ?>
		
		</div>
	</div>