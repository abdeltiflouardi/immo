<?php

class TProprieteBien extends Zend_Db_Table_Abstract
{
	protected $_name = 'proprietes_bien';
	protected $_dependentTables = array('TPossedePropBien');

	static function getListe()
	{
		$lister = array();

		$listes = new TProprieteBien;
		$listes = $listes->fetchAll($listes->select()->where('statut_propriete=0'));

		foreach($listes as $ligne):
			$lister[$ligne->id_propriete] = $ligne->libelle_propriete;
		endforeach;

		$lister	= array_map('utf8_encode', $lister);
		return $lister;
	}
	
}