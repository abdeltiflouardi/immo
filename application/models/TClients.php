<?php

class TClients extends Zend_Db_Table_Abstract
{
	protected $_name = 'clients';
	protected $_dependentTables = array('TAnnonces');

	public function insertClient($data = array())
	{	
		$iData = array(
			'email_user'	=>$data['Login'],
			'psw_user'		=>$data['Password'],
			'nom_client'	=>$data['Nom'],
			'prenom_client'	=>$data['Prenom'],
			'cp_client'		=>$data['CodePostal'],
			'adresse_client'=>$data['Adresse'],
			'ville_client'	=>$data['Ville'],
			'pays_client'	=>$data['Pays'],
			'tel_client'	=>$data['Tel'],
			'date_insc_client'=>new Zend_Db_Expr('NOW()')
		);
		return parent::insert($iData);
	}
	
	public function updateClient($data = array())
	{	
		$uData = array(
			'nom_client'		=>$data['Nom'],
			'prenom_client'		=>$data['Prenom'],
			'cp_client'			=>$data['CodePostal'],
			'adresse_client'	=>$data['Adresse'],
			'ville_client'		=>$data['Ville'],
			'pays_client'		=>$data['Pays'],
			'tel_client'		=>$data['Tel']
		);
		

		if(!empty($data['Password'])):
			$uData['psw_user'] = $data['Password'];
		endif;
		
		$uWhere = $this->getAdapter()->quoteInto('email_user = ?', $data['user']);
		
		return parent::update($uData, $uWhere);
	}
	
	static function getElementsForm($client)
	{
		$elems = array();
		
		$table = new TClients;
		$ct = $table->find($client);
		
		if($ct):
			$ct = $ct->current()->toArray();
			$elems['Nom'] 		= $ct['nom_client'];
			$elems['Prenom'] 	= $ct['prenom_client'];
			$elems['Adresse'] 	= $ct['adresse_client'];
			$elems['Ville'] 	= $ct['ville_client'];
			$elems['CodePostal']= $ct['cp_client'];
			$elems['Pays'] 		= $ct['pays_client'];
			$elems['Tel'] 		= $ct['tel_client'];
		endif;
		
		return $elems;
	}
	
}