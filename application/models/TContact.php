<?php

class TContact extends Zend_Db_Table_Abstract
{
	protected $_name = 'contact';

	public function insertContact($data = array())
	{	
		$iData = array(
			'emailC'		=>$data['Email'],
			'sujetC'		=>$data['Sujet'],
			'textC'			=>$data['Message'],
			'contactProbleme'=>$data['contactProbleme'],
			'dateC'			=>new Zend_Db_Expr('NOW()')
		);
		return parent::insert($iData);
	}
}