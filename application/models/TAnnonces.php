<?php

class TAnnonces extends Zend_Db_Table_Abstract
{
	/*
	 * Définition le nom de la table annonce correspond à la classe TAnnonce
	 */
	protected $_name = 'annonces'; 
	
	/*
	 * Définition de la clé primaire de la table annonce
	 */
	protected $_primary = 'id_annonce';
	
	/*
	 * Définition des tables dépond à la table annonce
	 * Array 
	 */
	protected $_dependentTables = array('TPossedePropBien', 'TImagesBien');

	/*
	 * Définition des lien entre les tables
	 * Chaque clé pripmaire dépond à une clé étrangère dans une autre table
	 */
	protected $_referenceMap    = array(
		'TypeBien' => array(
			'columns'           => array('id_type_bien'),
			'refTableClass'     => 'TTypeBien',
			'refColumns'        => array('id_type_bien')
		),
		'CategorieBien' => array(
			'columns'           => array('id_cat_bien'),
			'refTableClass'     => 'TCategoriesBien',
			'refColumns'        => array('id_cat_bien')
		),
		'Client' => array(
			'columns'           => array('email_user'),
			'refTableClass'     => 'TClients',
			'refColumns'        => array('email_user')
		)
    );

    
    /*
     * Définition de la méthode getAnnonceByClient qui vas retourner un tableau des annonces d'un client
     * getAnnonceByClient est static alors on peut l'appeler avec TAnnonce::getAnnonceByClient
     */
	static function getAnnonceByClient($client = '')
	{
			$tc 		= new TClients;
			$client  	= $tc->find($client);
			$clt  		= $client->current();
			$select     = $tc->select()->where('active=0')->order('date_insertion_annonce desc');

			if(!$clt) return array();

			return $clt->findDependentRowset('TAnnonces',null,$select)->toArray();
	}

	
	/*
	 * getAnnonceByCriteres cette permet de retourner un tableau des annonce selon un critère donnéderniers
	 * 
	 * On l'utilise dans:
	 * 		la recherche
	 * 		la navigation dans les annonces vente/location
	 * 		Affichage des derniers offres 
	 */
	static function getAnnonceByCriteres($criteres = array(), $limit = 0, $order = "date_insertion_annonce desc")
	{		
		$where = array('active=0');
		if(!empty($criteres['idAnnonce'])) 
			$where[] = "id_annonce = '{$criteres['idAnnonce']}'";
		
		if(!empty($criteres['TypeBien'])) 
			$where[] = "id_type_bien = '{$criteres['TypeBien']}'";
		
		if(!empty($criteres['PaysBien'])) 
			$where[] = "pays_bien = '{$criteres['PaysBien']}'";

 		if(!empty($criteres['ville']))
			$where[] = "ville_bien = '{$criteres['ville']}'";
		
 		if(!empty($criteres['Categorie']))
			$where[] = "id_cat_bien = '{$criteres['Categorie']}'";

		if(!empty($criteres['PrixD']) and !empty($criteres['PrixF'])):
			$where[] = "(prix between {$criteres['PrixD']} and {$criteres['PrixF']})";
		elseif(!empty($criteres['PrixD'])):
			$where[] = "prix='{$criteres['PrixD']}'";
		endif;
		
		if(!empty($criteres['nbrPieceMin']) and !empty($criteres['nbrPieceMax'])):
			if( $criteres['nbrPieceMax'] == 6):
				$where[] = "nbr_pieces>{$criteres['nbrPieceMin']}";
			else:
				$where[] = "(nbr_pieces between {$criteres['nbrPieceMin']} and {$criteres['nbrPieceMax']})";
			endif;			
		elseif(!empty($criteres['nbrPieceMin'])):
			$where[] = "nbr_pieces={$criteres['nbrPieceMin']}";
		endif;		

		if(!empty($criteres['surfaceD']) and !empty($criteres['surfaceF'])):
			$where[] = "(surface between {$criteres['surfaceD']} and {$criteres['surfaceF']})";
		elseif(!empty($criteres['surfaceD'])):
			$where[] = "surface={$criteres['surfaceD']}";
		endif;	

		$objAnnonce = new TAnnonces;
		
		if(count($where)==0):
			$select = $objAnnonce->select();
		else:
			$where = implode(' and ',$where);
			$select = $objAnnonce->select()->where($where);
		endif;

		if($limit > 0):
			$select->limit($limit);
		endif;

		if($order != ""):
			$select->order($order);
		endif;
		
		$listeType 	= TTypeBien::getListe();
		$listeAnnonce = $objAnnonce->fetchAll($select)->toArray();
		
		foreach($listeAnnonce as $k=>$v):
			$listeAnnonce[$k]['nameTypeBien'] = $listeType[$v['id_type_bien']];
		endforeach;
		
		TImagesBien::getImageByAnnonce($listeAnnonce);
		return $listeAnnonce;
	}
	
	
	/*
	 * Retour les élement du formulaire pour l'édition
	 */
	
	static function getElementsForm($id)
	{
		$elems = array();
		
		if(isset($id) && !empty($id)):
			$ta = new TAnnonces;
			$annonce = $ta->find($id);
			$c = count($annonce);
			if($c>0):				
				$tmp = $annonce->current()->toArray();
				$tmp = array_map('utf8_encode', $tmp);
				
				$elems['Categorie'] 		= $tmp['id_cat_bien'];
				$elems['TypeBien'] 			= $tmp['id_type_bien'];
				$elems['PaysBien'] 			= $tmp['pays_bien'];
				$elems['Adresse']			= $tmp['adresse_bien'];
				$elems['CodePostal']		= $tmp['cp_bien'];
				$elems['Ville']				= $tmp['ville_bien'];
				$elems['nbrPiece']			= $tmp['nbr_pieces'];
				$elems['surface']			= $tmp['surface'];
				$elems['Prix']				= $tmp['prix'];
				$elems['Seduire']			= $tmp['titre_annonce'];
				$elems['ContenuAnnonce']	= $tmp['contenu_annonce'];
				$elems['EmailContact']		= $tmp['email_contact'];
				$elems['TelContact']		= $tmp['tel_contact'];
				
				unset($tmp);
			endif;
		endif;
		
		return $elems;
	}
	
	/*
	 * insertAnnonce méthode pour insérer les annonces
	 */
	
	public function insertAnnonce($data = array())
	{
		$data['TelContact'] = (empty($data['TelContact'])) ? $data['tel_aux'] : $data['TelContact'];
		$data['EmailContact'] = (empty($data['EmailContact'])) ? $data['user'] : $data['EmailContact'];
		
		$iData = array(
						'email_user' 		=> $data['user'],
						'pays_bien' 		=> $data['PaysBien'],
						'date_insertion_annonce' 	=> new Zend_Db_Expr('NOW()'),
						'id_type_bien'		=> $data['TypeBien'],
						'id_cat_bien'		=> $data['Categorie'],
						'adresse_bien'		=> $data['Adresse'],
						'cp_bien'			=> $data['CodePostal'],
						'ville_bien'		=> $data['Ville'],
						'nbr_pieces'		=> $data['nbrPiece'],
						'surface'			=> $data['surface'],
						'prix'				=> $data['Prix'],
						'titre_annonce'		=> $data['Seduire'],
						'contenu_annonce'	=> $data['ContenuAnnonce'],
						'tel_contact'		=> $data['TelContact'],
						'email_contact'		=> $data['EmailContact']
					);
		//return $iData;
		return parent::insert($iData);
	}
	
	/*
	 * insertAnnonce méthode pour mettre à jour les annonces
	 */
	
	public function updateAnnonce($data = array())
	{
		$uData = array(
						'pays_bien' 		=> $data['PaysBien'],
						'id_type_bien'		=> $data['TypeBien'],
						'id_cat_bien'		=> $data['Categorie'],
						'adresse_bien'		=> $data['Adresse'],
						'cp_bien'			=> $data['CodePostal'],
						'ville_bien'		=> $data['Ville'],
						'nbr_pieces'		=> $data['nbrPiece'],
						'surface'			=> $data['surface'],
						'prix'				=> $data['Prix'],
						'titre_annonce'		=> $data['Seduire'],
						'contenu_annonce'	=> $data['ContenuAnnonce'],
						'tel_contact'		=> $data['TelContact'],
						'email_contact'		=> $data['EmailContact'],
						'date_modif_annonce'=> new Zend_Db_Expr('NOW()')
					);
		
		$uWhere[] = $this->getAdapter()->quoteInto('id_annonce = ?', $data['id']);
		$uWhere[] = $this->getAdapter()->quoteInto('email_user = ?', $data['user']);
		
		//return $uData;
		return parent::update($uData, $uWhere);
	}

}