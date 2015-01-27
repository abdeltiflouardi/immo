<?php

class ContactController extends Zend_Controller_Action
{
	function init()
	{
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
	
	function indexAction()
	{

		$form = new ContactForm();
		if(	$this->_request->isPost() &&
			$form->isValid($this->_request->getPost())):
			
			$data = $form->getValues();
			$data = array_map('stripslashes', $data);
			$data = array_map('utf8_decode', $data);

			$nc = new TContact;			
			$nc->insertContact($data);
			
			$this->_redirect($this->view->url(array(
												"controller"	=>"contact",
												"action"		=>"succes"
												)
											)
							);
		else:
			$data = array_map('stripslashes', $_POST);
			$form->populate($data);
		endif;		
		$this->view->form = $form;
	}
	
	function succesAction()
	{}
}