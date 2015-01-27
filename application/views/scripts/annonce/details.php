	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
		<?php 
			if(count($this->annonce)>0): 
			$ligne = $this->annonce[0];
			unset($this->annonce);
		?>
		
		<div id="a-1" class="divAnnonce">
						<div class="divImgAnnonce">						
						<img 	src="<?php echo My_Functions::getImg("/public/images/offres/",$ligne["liste_images"][0]["nom_image"])?>"
									alt="annonce immobilier" 
									title="annonce immobilier" 
									align="top" 
									width="120px"
									height="120px"
							/>
							<div>
																
								<?php 
									$text = "Agrandir";
									foreach( $ligne['liste_images'] as $val ):
									
									$img = My_Functions::getImg('/public/images/offres/', $val['nom_image']); 
									if(strpos($img,'defaut.png') !== false)continue;
								?>
								
							<a href="<?php echo $img;?>" dojoType="dojox.image.Lightbox" group="group" title=""><?php echo $text;?></a>
								
								<?php
									$text = ""; 
									endforeach; 
								?>	
											
						</div>			 					
					</div>

					<div class="divDetails">
						<div class="divsDetails">
							<h1><?php echo utf8_encode($ligne['titre_annonce']); ?></h1>
													</div>	
						
						<div class="divsDetails">
							<strong>Type Bien:</strong>
							<?php echo $ligne['nameTypeBien']; ?>
												
						</div>	
						
						<div class="divsDetails">
							<strong>Surface:</strong> <?php echo utf8_encode($ligne['surface']); ?>  <em>M²</em>

						</div>
						
						<div class="divsDetails">
							<strong>Pièces:</strong>
							<?php echo utf8_encode($ligne['nbr_pieces']); ?>					
						</div>
						
						<div class="divsDetails">
							<strong>Prix:</strong>
							<?php echo utf8_encode($ligne['prix']); ?>
						</div>
						<div class="divsDetails">

							<strong>Annonce:</strong>
							<p>
							<?php echo utf8_encode($ligne['contenu_annonce']); ?>			
							</p>
						</div>						 					
					</div>
					<div class="clear"></div>
			</div>
		<?php else: ?>
			<div class="error">
			
					<?php echo $this->translate('noSearchResultMsg'); ?>
					<a href="/" title=""><?php echo $this->translate('returnMsg'); ?></a>
			
			</div>
		<?php endif; ?>
		</div>	
	</div>