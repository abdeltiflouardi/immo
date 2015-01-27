<?php
// id_type_bien
// libelle_type_bien
class TTypeBien extends Zend_Db_Table_Abstract
{
	protected $_name = 'types_bien';
	protected $_dependentTables = array('TAnnonces');

	static function getListe()
	{
		$lister = array();

		$listes = new TTypeBien;
		$listes = $listes->fetchAll();

		foreach($listes as $ligne):
			$lister[$ligne->id_type_bien] = $ligne->libelle_type_bien;
		endforeach;

		$lister	= array_map('utf8_encode', $lister);
		return $lister;
	}

	static function getIdByName($name = '')
	{
		$array = TTypeBien::getListe();
		return (int)array_search($name, $array);
	}
}