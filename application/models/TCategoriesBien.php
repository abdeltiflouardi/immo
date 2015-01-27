<?php

class TCategoriesBien extends Zend_Db_Table_Abstract
{
	protected $_name = 'categories_bien';
	protected $_dependentTables = array('TAnnonces');

	static function getListe()
	{
		$lister = array();

		$listes = new TCategoriesBien;
		$listes = $listes->fetchAll();

		foreach($listes as $ligne):
			$lister[$ligne->id_cat_bien] = $ligne->libelle_cat_bien;
		endforeach;
		$lister	= array_map('utf8_encode', $lister);
		return $lister;
	}
	
	static function getIdByName($name = '')
	{
		$array = TCategoriesBien::getListe();
		return (int)array_search($name, $array);
	}
}