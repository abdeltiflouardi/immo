<?php

class ClientController extends Zend_Controller_Action
{	
	
	/*
	 * Initialisation de de l'action
	 */
	function init()
	{
            //var_dump($_POST);
            //exit;
		/*
		 * initialisation des la variable allow par true
		 * L'utilisateur par defaut autoriser d'utiliser tous les actions
		 */
		
		$this->Allowed = true;  
		
		/*
		 * initialisation de la variable inscrit par false
		 * si la referer de la page est la page inscription
		 * mettre true à inscrit pour afficher dans la vue un message
		 */
		$this->view->inscrit = false;
		if($this->_request->has('s')):
			$this->view->inscrit = true;
		endif;
		
		/*
		 * Tester si déja inscrit si oui
		 * initialiser la variable username par le nom est le prénom du client connecté
		 */
		if(Zend_Auth::getInstance()->hasIdentity()):
			$this->view->username = Zend_Auth::getInstance()->getIdentity()->nom_client;
			$this->view->username .= " ";
			$this->view->username .= Zend_Auth::getInstance()->getIdentity()->prenom_client;
		endif;
	}
	
	/*
	 * Les actions avant d'afficher la page
	 */
	function preDispatch()
	{
			
		/*
		 * Appel à l'instance de Zend_Auth
		 */
		$auth = Zend_Auth::getInstance();
		
		/*
		 * Déclaration d'une variable auth pour dire à la vue que l'utilisateur est connecté ou pas en cours
		 * par defaut auth initialisé par true
		 */
		$this->view->auth = true;
		
		/*
		 * si l'utilisateur n'est pas connecté mettre false à auth
		 * et vérifier est ce que l'utilisateur est autorisé pour accéder à l'action ou pas
		 * si n'est pas autorisé redireger le à la page client/login
		 * 
		 */
		if (!$auth->hasIdentity()):
			$this->view->auth = false;
			if(in_array($this->_request->getActionName(), array('compte','sa','ma', 'ia', 'delimg', 'abonner'))):				
				My_Functions::saveUrl($this->_request->getParams());			
				$this->_redirect('/client/login/');
			endif;
		else:
		
				if( $this->_request->has('idImg') ):
					$idi = $this->_request->getParam('idImg');
					
					
					$testI = new TImagesBien;
					$where = $testI->getAdapter()->quoteInto('id_image = ?' , $idi );
					$result = $testI->fetchRow($where);
					$c = count($result);
					if($c>0):
						$this->_request->setParam('ida', $result->id_annonce);
					endif;
					unset($where);
				endif;
				
				if($this->_request->has('ida')):
					$ida = $this->_request->getParam('ida');
					$email = Zend_Auth::getInstance()->getIdentity()->email_user;
					
					$testA = new TAnnonces;
					$where[] = $testA->getAdapter()->quoteInto('id_annonce = ?' , $ida );
					$where[] = $testA->getAdapter()->quoteInto('email_user = ?' , $email );
					$result  = $testA->fetchRow($where);
					if( !$result ):
							
							$this->Allowed = false;
					
							$this->_request->setParam('idImg', NULL);
							$this->_helper->viewRenderer->setNoRender(true);
							echo '<div class="error">';
							echo sprintf($this->view->translate('NotAllowed'), '/client/compte');
							echo '</div>';
					endif;
				endif;
		endif;	
	}
	
	/*
	 * Inscription des clients
	 */
	function inscriptionAction()
	{
		$form = new InscriptionClientForm(array('method'=>'post','action'=>''));
		
		if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) :
			$values = $form->getValues();
		
			$NClient = new TClients;
			$NClient->insertClient($values);
			
			$_POST['login'] = $values['Login'];
			$_POST['pwd'] 	= $values['Password'];
			$this->_forward("login", "client", NULL, array('s'=>'insc'));
		else:
			$data = array_map('stripslashes', $_POST);
			$form->populate($data);
		endif;
		
		$this->view->form = $form;
	} 
	
	/*
	 * Gestion des images des annonces
	 */
	
	function iaAction()
	{
		
		$form = new AnnonceImagesForm(array('method'=>'post'));
		
		if ($this->_request->isPost()) :
		
			if($form->isValid($this->_request->getPost())):
				$data = $form->getValues();
				$images = $data['Images'];
				My_Functions::renameImages( $images , 'public/images/offres/' , $data['id']);
				
				foreach($images as $nom):
					$ni = new TImagesBien;
					$ni->insertImages($data['id'], $nom);
				endforeach;
				$this->_redirect('/client/ia/ida/' . $data['id']);
				exit;
			endif;
			
		endif;
		
			$id = $this->_request->getParam('ida',0);

			if( 0 !== $id):
				
				$annonce = new TAnnonces;
				$annonce = $annonce->find($id)->current();
				if($annonce):
					
					$images = $annonce->findDependentRowset('TImagesBien');
					if($images):
						$images = $images->toArray();
					endif;
					$count = ($images) ? count($images) : 0 ;
					$count = 4 - $count;
					
					$this->view->images = $images;
					
					$form->getElement('id')->setValue($id);
					
					if($count>0):
						$form->getElement('Images')	->setMultiFile($count)
													->setIsArray(true);
					else:
						$form->getElement('Images')->setAttribs(array('style'=>'display:none'));
					endif;
										
					$annonce = $annonce->toArray();
					$this->view->titre_annonce = $annonce['titre_annonce'];
					unset($annonce);	
					
				endif;
			endif;

			
			$this->view->form = $form;
	}
	
	function delimgAction(){
			$id = $this->_request->getParam('idImg');
			if( NULL !== $id ):
			
				$this->_helper->layout->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				
				$table 	= new TImagesBien();
				$where 	= $table->getAdapter()->quoteInto('id_image = ?', $id);
				$row 	= $table->fetchRow( $where );
				
				if($row):
					@unlink('public/images/offres/' . $row->nom_image);
					$c 		= $row->delete();
				endif;
				
				if(!isset($c)):
					echo 0;
				else:
					echo 1;
				endif;
			endif;
	} 
	
	/*
	 * Modification des annonces
	 */
	function maAction(){
		$id = (int)$this->_request->getParam('ida');
		$auth = Zend_Auth::getInstance()->getIdentity();

		$action = $this->view->url(array('controller'=>'client','action'=>'ma'),'default',true);
		
		
		$form = new DeposerForm(array('method'=>'post','name'=>'deposerForm', 'action'=>$action));
		
		
		$form->removeDisplayGroup('G5');
		$form->removeElement('Images');
		$form->addElement('hidden', 'id', array('value'=>$id));
		$form->getElement('submit')->setLabel('Modifier');
		
		if ($this->_request->isPost()) :
			 if($form->isValid($this->_request->getPost())):
			 			$values = $form->getValues();
			 			
			 			$options = My_Functions::getPostedOptions($values);
			 			$iOptions = new TPossedePropBien();
						$iOptions->insertAnnonceOptions( $values['id'] , $options );
			 			
						$values['user'] = $auth->email_user;
						$values = array_map('utf8_decode'	,$values);
						$values = array_map('stripslashes'	,$values);
						
						$updateAnnonce 	= new TAnnonces;
						$retour 		= (int)$updateAnnonce->updateAnnonce($values);
						
						$url['msg1'] = 'succes';
						if(!$retour):
							$url['msg1'] = 'erreur';
						endif;
						
						$url['controller'] 	= 'client';
						$url['action']		= 'compte';
						
						$this->_redirect($this->view->url($url, 'default', true));
			 else:
			 	$data = array_map('stripslashes', $_POST);
				$form->populate($data);
			 endif;
		else:
			$elems = array_merge(TAnnonces::getElementsForm($id), TPossedePropBien::getElementsForm($id));
			$form->populate($elems);		
		endif;
		
		$this->view->form = $form;
	}
	
	/*
	 * Désactivation de l'annonce
	 */
	function saAction(){
		
		$id = (int)$this->_request->getParam('ida');
		$auth = Zend_Auth::getInstance()->getIdentity();
		
		$table = new TAnnonces();
		
		$data = array(
		    'active'      => '1', //active0 desactive1
		);
		
		$where[] = $table->getAdapter()->quoteInto('id_annonce = ?', $id);
		$where[] = $table->getAdapter()->quoteInto('email_user = ?', $auth->email_user);
		
		$retour = $table->update($data, $where);
		
		$param['controller'] 	= 'client';
		$param['action']		= 'compte';
		$param['msg']			= 'succes';
		
		if( !$retour ):
			$param['msg']		= 'erreur';
		endif;
		
		if(  $this->Allowed == true ):
			$this->_redirect($this->view->url($param, 'default', true));
		endif;
	}
	
	/*
	 * Gestion de compte
	 */
	function compteAction()
	{
		$this->view->msg = false;
		if(	$this->_request->has('msg') &&
			$this->_request->getParam('msg') == 'succes'):
			$this->view->msg = true;
		endif;
		
		$this->view->msg1 = false;
		if(	$this->_request->has('msg1') &&
			$this->_request->getParam('msg1') == 'succes'):
			$this->view->msg1 = true;
		endif;
		
		$this->view->msg2 = false;
		if(	$this->_request->has('msg2') &&
			$this->_request->getParam('msg2') == 'succes'):
			$this->view->msg2 = true;
		endif;		
		
		
		$auth = Zend_Auth::getInstance()->getIdentity();
		$this->view->listAnnonceClient = TAnnonces::getAnnonceByClient($auth->email_user);

		$form = new ModifyProfileForm(array('method'=>'post','name'=>'deposerForm', 'action'=>''));
		if ($this->_request->isPost()) :
			$p = $this->_request->getParam('Password');
			if(!empty($p)):
				$form->getElement('OlderPassword')->setRequired(true);
			endif;
		
			if($form->isValid($this->_request->getPost())):
				$values = $form->getValues();
				$values['user'] = $auth->email_user;
				
				$Client = new TClients;
				$retour = $Client->updateClient($values);
				
				$url['msg2'] = 'succes';
				if(!$retour):
					$url['msg2'] = 'n';
				endif;
				
				$url['controller'] 	= 'client';
				$url['action']		= 'compte';
				
				$this->_redirect($this->view->url($url, 'default', true));
				
			else:
				$data = array_map('stripslashes', $_POST);
				$form->populate($data);
			endif;
		else:
				$form->populate(TClients::getElementsForm($auth->email_user));
		endif;		
		$this->view->form = $form;
	}
	
	/*
	 * Oublie de mot de passe
	 * Vérification et envoie d'email
	 */
	function verifieremailAction(){
				$this->_helper->layout->disableLayout();
				$this->_helper->viewRenderer->setNoRender(true);
				
				$email = $this->_request->getParam('email', 'noemail');
				
				$cl = new TClients;
				$c = $cl->fetchRow("email_user='$email'");
				if(!$c):
					echo 0;
				else:
					echo 1;
				endif;
		       
	}
	
	/*
	 * Se connecter à mon compte
	 */
	function loginAction()
	{
		
		$form = new LoginForm(array('method'=>'post','action'=>''));
		if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) :
			$login = $this->_request->getPost('login');
			$pwd = $this->_request->getPost('pwd');
			
			$adapter  = Zend_Db_Table_Abstract::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($adapter);
			$authAdapter->setTableName('clients');
			$authAdapter->setIdentityColumn('email_user');
			$authAdapter->setCredentialColumn('psw_user');
			
			$authAdapter->setIdentity($login);
			$authAdapter->setCredential($pwd);
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);

	
			if ($result->isValid()) {
					$data = $authAdapter->getResultRowObject(null, 'psw_user');
					$auth->getStorage()->write($data);
					
					$url = My_Functions::getSavedUrl();
					if(!$url):
						$url['controller'] 	= '';
						$url['action']		= '';
						($this->_request->has('s')) ? $url['s'] = $this->_request->getParam('s') : '' ;
						
						$url = $this->view->url($url);
					else:
					
						($this->_request->has('s')) ? $url['s'] = $this->_request->getParam('s') : '' ;

						$url = $this->view->url($url);
						My_Functions::clearSavedUrl();
					endif;					
					
					$this->_redirect($url);					
			} else {
					$this->view->message = $this->view->translate('loginPassInvalid');
			}		
		endif;
		$this->view->form = $form;
		
	} 
	
	/*
	 * Abonner action
	 */
	function abonnerAction()
	{
					$this->view->urlPaypal = 'https://' . SERVER_PAYPAL . '/cgi-bin/webscr';
					
					
					
					$this->view->params = array();
					$elems = Zend_Auth::getInstance()->getIdentity();
					//var_dump();
					$this->view->params['cmd']			= '_xclick';
					$this->view->params['first_name'] 	= $elems->nom_client;
					$this->view->params['last_name'] 	= $elems->prenom_client;
					$this->view->params['address1'] 	= $elems->adresse_client;
					$this->view->params['city'] 		= $elems->ville_client;
					$this->view->params['zip'] 			= $elems->cp_client;
					$this->view->params['country'] 		= $elems->pays_client;
					$this->view->params['email'] 		= $elems->email_user;
					$this->view->params['amount'] 		= 20;
					$this->view->params['item_name'] 	= 'Default';
					$this->view->params['item_number'] 	= 1000;
					$this->view->params['business'] 	= BUSINESS;
					$this->view->params['currency_code']= 'EUR';
					$this->view->params['custom'] 		= $elems->email_user;
					$this->view->params['cancel_return']= 'http://' . SERVER_NAME . '/client/abonner';
					$this->view->params['return'] 		= 'http://' . SERVER_NAME . '/client/abonner/succes';
					$this->view->params['notify_url'] 	= 'http://' . SERVER_NAME . '/paypal/ok';
					$this->view->params['shipping'] 	= '0.00';
					$this->view->params['no_shipping'] 	= '0';
					$this->view->params['tax'] 			= '0.00';
					$this->view->params['lc'] 			= 'FR';
					
					
	}
	
	/*
	 * Abonner succes action
	 */
	function absAction()
	{
			
	}	
	
	/*
	 * Se déconnetcer
	 */
	function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
	}
}
?>