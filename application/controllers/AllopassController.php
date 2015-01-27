<?php
/**
 * Allopass Controller
 * 
 * @author 
 * @version
 */
class AllopassController extends Zend_Controller_Action
{	
	function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity()) :	
				My_Functions::saveUrl($this->_request->getParams());			
				$this->_redirect('client/login/');
		endif;
	}
	
	
	function okAction()
	{
		$values = array();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$values['email'] = Zend_Auth::getInstance()->getIdentity()->email_user;
		$values['nbr_jours'] = 1;
		$values['prix'] = 1;
		
		$nab = new TAbonnement;
		$nab->insertAbonnement($values);
		
		$this->_redirect('/client/abs');
	}
}

?>