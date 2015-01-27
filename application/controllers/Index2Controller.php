<?php

/**
 * Index Controller
 * 
 * @author 
 * @version
 */
class Index2Controller extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout->disableLayout();
        //$this->view->headTitle('Z');
    }
    
    public function indexAction()
    {
		//$this->view->assign('print' , TAbonnement::getLeftByClient('ouardisoft@live.fr'));
    }
    
    public function successAction() {}
}
