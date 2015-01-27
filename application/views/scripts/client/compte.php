	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
		<?php if($this->msg == true): ?>
			<div class="noError">
				<?php echo $this->translate('annonceDeleted');?>
			</div>
		<?php endif; ?>
		
		<?php if($this->msg1 == true): ?>
			<div class="noError">
				<?php echo $this->translate('annonceUpdate');?>
			</div>
		<?php endif; ?>
		
		<?php if($this->msg2 == true): ?>
			<div class="noError">
				<?php echo $this->translate('profileUpdated');?>
			</div>
		<?php endif; ?>
		
		<?php if($this->inscrit == true): ?>
			<div class="noError">
				<?php echo $this->translate('profileCreated');?>
			</div>
		<?php endif; ?>
		
<?php


// Container with tabs
$this->tabContainer()->captureStart('tab1', array(), array('style' => 'width:730px;height:850px;'));

    

       $this->contentPane()->captureStart('tabAnnonce', array(), array('title' => 'Mes annonces'));

       foreach($this->listAnnonceClient as $annonce):
       	$annonce = array_map('utf8_encode', $annonce);
       	
       	$title = '[' . $annonce['date_insertion_annonce'] . '] - ' . $annonce['titre_annonce'];
       	
       	$contenu  = '';
       	$contenu .= '<div class="ModifierSupprimer">' . "\n"; 
       	
       	$contenu .= '	<a href="' . $this->url(array('controller'=>'client','action'=>'ma', 'ida'=>$annonce['id_annonce']), 'default', true) . '">';
       	$contenu .= '		Modifier';
       	$contenu .= '	</a>' . "\n";
       	
       	$contenu .= '&nbsp;&nbsp;&nbsp;';
       	
       	$contenu .= '	<a href="' . $this->url(array('controller'=>'client','action'=>'sa', 'ida'=>$annonce['id_annonce']), 'default', true) . '" 
       					onclick="if(confirm(\'' . $this->translate('confirmDelMsg') . '\')) return true; else return false;">';
       	$contenu .= '		Supprimer';
       	$contenu .= '	</a>' . "\n";
       	
       	$contenu .= '&nbsp;&nbsp;&nbsp;';
       	
       	$contenu .= '	<a href="' . $this->url(array('controller'=>'client','action'=>'ia', 'ida'=>$annonce['id_annonce']), 'default', true) . '">';
       	$contenu .= '		Images';
       	$contenu .= '	</a>' . "\n";
       	
       	$contenu .= '</div>' . "\n";
       	$contenu .= $annonce['contenu_annonce'] . "\n";
       	
       	
       	print $this->titlePane(	'annonce'.$annonce['id_annonce'],
       							$contenu,
       							array(
       								'title'=> $title, 
       								'open'=>'false'
       								)
       							);
       endforeach;
       
       
    echo $this->contentPane()->captureEnd('tabAnnonce');

    $this->contentPane()->captureStart('tabProfile', array(), array('title' => 'Mon profile'));
    	
    	echo $this->form;
    
    echo $this->contentPane()->captureEnd('tabProfile');
    
echo $this->tabContainer()->captureEnd('tab1');


?>

		</div>	
	</div>