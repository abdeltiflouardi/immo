<?php

/**
 * Index Controller
 * 
 * @author 
 * @version
 */
class IndexController extends Zend_Controller_Action
{
	function init()
	{

		$this->view->headMeta()->appendName('keywords', 'immo immobilier achat vente');
		$this->view->headMeta()->appendName('description', 'Déposez une annonce gratuitement ... ');
		$this->view->headMeta()->appendName('revisit-after', '2 days');
		$this->view->headMeta()->appendName('robots', 'index,follow');
		$this->view->headMeta()->appendName('Language', 'fr');
		if(Zend_Auth::getInstance()->hasIdentity()):
			$this->view->username = Zend_Auth::getInstance()->getIdentity()->nom_client;
			$this->view->username .= " ";
			$this->view->username .= Zend_Auth::getInstance()->getIdentity()->prenom_client;
		endif;
	}
	
	function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		$this->view->auth = true;
		if (!$auth->hasIdentity()) {
			$this->view->auth = false;
		}
	}
	
	function indexAction(){
		$this->view->headTitle('titleAccueil');


		$this->view->enabled = false;
		
		$triSQL = "date_insertion_annonce desc";
		
		/*
		 * Urls de trie
		 * */
		
		$triPrixUrl='';
		$triDateUrl='';
		
		if(isset($_GET['tri'])):
		
			preg_match('/([a-z]+)([0|1])/', $_GET['tri'], $out);
			parse_str($_SERVER['QUERY_STRING'], $array_str);
			
			unset($array_str['tri']);
			
			$str = '/recherche/?';
			foreach($array_str as $k=>$v)$str .= $k . '=' . $v . '&';
			
			switch($out[1]):
				case 'prix': 
					$triSQL = 'prix';
					$triSQL .= ($out[2] == 0) ? ' asc' : ' desc' ;
					
					$paramTriPrix = 'tri=prix';
					$paramTriPrix .= ($out[2]==0) ? "1" : "0" ;
					
					$paramTriDate = 'tri=date0';					
					
					;break; 
				case 'date': 
					$triSQL  = 'date_insertion_annonce';
					$triSQL .=  ($out[2] == 0) ? ' asc' : ' desc' ;
					
					$paramTriDate = 'tri=date';
					$paramTriDate .= ($out[2]==0) ? "1" : "0" ;
					
					$paramTriPrix = 'tri=prix0';
					
					;break; 
			endswitch;
			
			$triPrixUrl = $str . $paramTriPrix;
			$triDateUrl = $str . $paramTriDate;			
					
			
		else:
			
			$triPrixUrl = $this->_request->getRequestUri() . '&tri=prix0';
			$triDateUrl = $this->_request->getRequestUri() . '&tri=date0';			
		
		endif;
		
		$this->view->triPrixUrl=$triPrixUrl;
		$this->view->triDateUrl=$triDateUrl;
		
		
		/*
		 * 
		 */
		
		$display = false;
				
		if ( stripos($this->_request->getRequestUri(),'recherche')!==false && (isset($_GET['Categorie']) && !empty($_GET['Categorie'])) ):
			
			$values = $this->_request->getParams();
			$values['TypeBien'] = (int)$_GET['TypeBien'];
			$values['Categorie']= (int)$_GET['Categorie'];
			$display = true;
			
		elseif(	($this->getRequest()->has('offres_location'))||
				($this->getRequest()->has('offres_achat'))):
				
				$values['Categorie'] = ($this->getRequest()->has('offres_achat')) ? 1 : 2 ;
				$display = true;
		endif;

		
		if( $display == true ):
				$annonces = TAnnonces::getAnnonceByCriteres($values, 0, $triSQL);
				$this->view->searchResult = true;
				$this->view->enableJS = true;
				
				if(Zend_Auth::getInstance()->hasIdentity()):
					$em = Zend_Auth::getInstance()->getIdentity()->email_user;
					//exit($em);
					if(TAbonnement::getLeftByClient($em) > 0):
						$this->view->enabled = true;
					endif;
				endif;
				
				
				$page = Zend_Paginator::factory($annonces);
				$page->setPageRange(5);
				$page->setCurrentPageNumber($this->_getParam('page', 1));
				$page->setItemCountPerPage($this->_getParam('par', 5));
				$this->view->paginator = $page;
		else:
				$form = new SearchForm(array('method'=>'get','name'=>'searchForm', 'action'=>'/recherche'));
				$this->view->form = $form;
				$this->view->listeOffres = TAnnonces::getAnnonceByCriteres(1, 3, $triSQL);
		endif;
		
		
	}
}
