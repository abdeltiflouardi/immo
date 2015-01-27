<div id="content">
	<div id="ColLeft">
		<?php echo $this->render("menu.phtml"); ?>
	</div>
	<div id="ColRight">
			<?php
			if(isset($this->searchResult) and ($this->searchResult === true)):
			$i=0;
			
			if(count($this->paginator)>0):
			?>
			
			<div class="noError">
					<?php echo $this->translate('searchResultMsg') . "\n"; ?>
					<a href="/" title=""><?php echo $this->translate('returnMsg'); ?></a>
			</div>

			<div style="text-align: right;">
				<?php echo $this->translate('triPar') . "\n"; ?>
				<a href="<?php echo $this->triPrixUrl; ?>">Prix</a> 
				/
				<a href="<?php echo $this->triDateUrl; ?>">Date</a> 
			</div>
			<?php
			foreach($this->paginator as $ligne):
			$i++;
			$text = '<span>Agrandir -' . My_Functions::countImg('/public/images/offres/', $ligne['liste_images']) . '-</span>';
			?>
			<div id="a-<?php echo $i;?>" class="divAnnonce">
					<div class="divImgAnnonce">						
						<img 	src="<?php echo My_Functions::getImg('/public/images/offres/', $ligne['liste_images'][0]['nom_image']);?>"
									alt="" 
									title="" 
									align="top" 
									width="120px"
									height="120px"
							/>
							<div>
								<?php 
									foreach( $ligne['liste_images'] as $val ):
									
									$img = My_Functions::getImg('/public/images/offres/', $val['nom_image']);
									
									if(strpos($img,'defaut') !== false)continue;
								?>
								
							<a href="<?php echo $img;?>" dojoType="dojox.image.Lightbox" group="group<?php echo $i;?>" title="" style="color: green; text-decoration: none;"><?php echo $text;?></a>
								
								<?php
									$text = ""; 
									endforeach; 
								?>			
						</div>			 					
					</div>
					<div class="divDetails">
					
					<?php if(isset($ligne['titre_annonce']) and !empty($ligne['titre_annonce'])): ?>
						<div class="divsDetails">
							<strong>Titre de l'annonce:</strong>
							<?php echo utf8_encode($ligne['titre_annonce']); ?>
						</div>
					<?php endif; ?>
					
						<div class="divsDetails">
							<strong>Type Bien:</strong> 
							<?php echo $this->escape($ligne['nameTypeBien']); ?>
						</div>	
						
						<div class="divsDetails">
							<strong>Surface:</strong> 
							<?php echo utf8_encode($ligne['surface']); ?> <em>M²</em>
						</div>
						
						<div class="divsDetails">
							<strong>Pièces:</strong> 
							<?php echo utf8_encode($ligne['nbr_pieces']); ?>
						</div>
						
						<div class="divsDetails">
							<strong>Prix:</strong> 
							<?php echo utf8_encode($ligne['prix']); ?> €
						</div>
						<div class="divsDetails">
							<div style="width: 100px; float: left;">
								<strong>Annonce 
								<span style="font-size: xx-small;color: gray;">
								<?php echo utf8_encode($ligne['id_annonce']); ?>
								</span> :
								</strong>
							</div>
							<div style="text-align: right;width: 400px; float: right; padding-right: 10px;">
								<strong>
								<?php echo $this->translate('paruLe');?>
								<span style="font-size: xx-small;color: gray;">
								<?php echo utf8_encode($ligne['date_insertion_annonce']); ?>
								</span>
								</strong>
							</div>					
							<div class="clear"></div>
							<p>
							<?php echo utf8_encode($ligne['contenu_annonce']); ?>
							</p>
						</div>		
						
						<?php if( $this->enabled == true): ?>
						<div class="divsDetails">
							<strong>Contactez: </strong> <br />
							Email: <?php echo utf8_encode($ligne['email_contact']); ?><br />
							Tèl: <?php echo utf8_encode($ligne['tel_contact']); ?>
						</div>	
						<?php endif; ?>			 					
					</div>
					<div class="clear"></div>
			</div>
		<?php 
				endforeach;
				echo $this->paginationControl($this->paginator, 'Sliding', 'paginator.phtml');
				
			else:
			
		?>
			<div class="error">
					<?php echo $this->translate('noSearchResultMsg'); ?>
					<a href="/" title=""><?php echo $this->translate('returnMsg'); ?></a>
			</div>
		<?php 	
			
			endif;	
 
			else:
		?>
		
			<div id="zoneSearch">
				<?php echo $this->form; ?>
			</div>
			<div id="zoneInfoSite">
				<a id="annonceImgBtn" href="<?php echo $this->url(array('action' => 'deposer', 'controller'=>'annonce'), 'default');?>">
					<img alt="" src="/public/images/bouton_annonce.gif" />
				</a>
				<div dojoType="dijit.Tooltip" connectId="annonceImgBtn" position="above,below" toggle="explode" toggleDuration="250">
				<?php echo $this->translate("deposerBtntt") . "\n"; ?>
				</div>
				<img alt="" src="/public/images/desc.jpg" />
			</div>
		<?php  
			endif;
		?>
	</div>	
</div>
