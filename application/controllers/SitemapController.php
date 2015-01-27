<?php
class SitemapController extends Zend_Controller_Action
{
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$liste = TAnnonces::getAnnonceByCriteres();
		$contenu = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$contenu .= '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">' . "\n";
		
		foreach($liste as $ligne):
		
			$titre = My_Functions::getLienTitle(utf8_encode($ligne['titre_annonce']));
			$lien = 'http://' . SERVER_NAME . '/annonce/details/id/' . $ligne['id_annonce'] . '/' . $titre;
			$date = new Zend_Date();
			
			
			$contenu .= '<url>' . "\n";
			$contenu .= '		<loc>' . $lien . '</loc>' . "\n";
			$contenu .= '		<lastmod>' . $date->toString('y-MM-d') . '</lastmod>' . "\n";
			$contenu .= '</url>' . "\n";
			
		endforeach;
		
		$contenu .= '</urlset>' . "\n";
		
		$handle = fopen( 'file.xml' , 'w+');
		fwrite($handle , $contenu);
		fclose($handle);
		
	}
}
?>