<?php 
class ErrorController extends Zend_Controller_Action 
{ 
	function init()
	{
		if(Zend_Auth::getInstance()->hasIdentity()):
			$this->view->username = Zend_Auth::getInstance()->getIdentity()->nom_client;
			$this->view->username .= " ";
			$this->view->username .= Zend_Auth::getInstance()->getIdentity()->prenom_client;
		endif;
	}
	
    public function errorAction() 
    { 

        $errors = $this->_getParam('error_handler'); 

        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER: 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION: 

                $this->getResponse()->setHttpResponseCode(404); 
                $this->view->message = 'Page not found'; 
                break;
                 
            default: 
                $this->getResponse()->setHttpResponseCode(500); 
                $this->view->message = 'Application error'; 
                break; 
        } 

        $this->view->env       = $this->getInvokeArg('env'); 
        
		$this->view->exception = $errors->exception; 
		
		$this->view->request   = $errors->request; 
    } 
}
