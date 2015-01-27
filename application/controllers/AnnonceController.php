<?php

/**
 * Index Controller
 * 
 * @author 
 * @version
 */
class AnnonceController extends Zend_Controller_Action
{
	function init()
	{

		$this->view->headMeta()->appendName('keywords', 'immo immobilier achat vente');
		$this->view->headMeta()->appendName('description', 'Déposez une annonce gratuitement ... ');
		$this->view->headMeta()->appendName('revisit-after', '2 days');
		$this->view->headMeta()->appendName('robots', 'index,follow');
		$this->view->headMeta()->appendName('Language', 'fr');
		
		if(!defined('ROBOT')):
			if(Zend_Auth::getInstance()->hasIdentity()):
				$this->view->username = Zend_Auth::getInstance()->getIdentity()->nom_client;
				$this->view->username .= " ";
				$this->view->username .= Zend_Auth::getInstance()->getIdentity()->prenom_client;
			endif;
		endif;
	}
	
	function preDispatch()
	{
		$this->view->auth = false;
		if(!defined('ROBOT')):
			$this->view->auth = true;
			$auth = Zend_Auth::getInstance();
			if (!$auth->hasIdentity()) :
				$this->view->auth = false;
				if(!in_array($this->_request->getActionName(), array('details'))):		
					My_Functions::saveUrl($this->_request->getParams());			
					$this->_redirect('client/login/');
				endif;
			endif;
		endif;
	}
	
	function detailsAction()
	{
		$values['idAnnonce']  =  $this->_request->getParam('id');
		$this->view->annonce = TAnnonces::getAnnonceByCriteres($values);
		$this->view->headTitle(utf8_encode($this->view->annonce[0]['titre_annonce']));
		$this->view->enableJS = true;
	}
	
	function deposerAction(){
		$auth = Zend_Auth::getInstance();
		
		$this->view->headTitle('Créer votre annonce');
		$this->view->headMeta()->appendName('keywords', '');
		
		$form = new DeposerForm(array('method'=>'post','name'=>'deposerForm', 'action'=>''));
	
		if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) :
			$values = $form->getValues();
			
			$values['user'] = $auth->getIdentity()->email_user;
			$values['tel_aux'] = $auth->getIdentity()->tel_client;
					
			$images = $values['Images'];
			unset($values['Images']);
			
			$values = array_map('utf8_decode'	,$values);
			$values = array_map('stripslashes'	,$values);
			$nAnnonce = new TAnnonces;
			$idA = (int)$nAnnonce->insertAnnonce($values);

			
						 			
 			$options = My_Functions::getPostedOptions($values);
 			$iOptions = new TPossedePropBien();
			$iOptions->insertAnnonceOptions( $idA , $options );
			
			
			if($images !== NULL):
					My_Functions::renameUploads($images,'public/images/offres/', $idA);
					foreach($images as $nomI):
						$nI = new TImagesBien;
						$nI->insertImages($idA , $nomI);
					endforeach;
			endif;
			
			$this->_redirect($this->view->url(array(
												"controller"=>"annonce",
												"action"=>"succes"
												)
											)
							);
		else:
			$data = array_map('stripslashes', $_POST);
			$form->populate($data);
		endif;

		$this->view->form = $form;	
		
	}
	
	function succesAction(){
	
	}
}
