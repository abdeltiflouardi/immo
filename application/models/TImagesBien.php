<?php

class TImagesBien extends Zend_Db_Table_Abstract
{
	protected $_name = 'images_bien';
	
	protected $_referenceMap    = array(
		'Annonce' => array(
			'columns'           => array('id_annonce'),
			'refTableClass'     => 'TAnnonces',
			'refColumns'        => array('id_annonce')
		)
	);

	static function getImageByAnnonce(&$annonces=array())
	{
		foreach($annonces as $k=>$v):
			$objImage = new TImagesBien;

			$images = $objImage->fetchAll($objImage->select()->where('id_annonce = ?' , $v['id_annonce']))->toArray();

			$annonces[$k]['liste_images'] = count($images)>0 ? $images : array(0=>array('nom_image'=>'defaut.png'));
		endforeach;

		return;
	}

	public function insertImages($idA , $nomI)
	{
		$iData = array(
						'id_annonce'=>$idA,
						'nom_image'=>$nomI
				);
		return parent::insert($iData);
	}
	
}