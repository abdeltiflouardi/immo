<?php
/*
 *
 *`id_abonnement` int(11) NOT NULL auto_increment,
  `email_user` varchar(10) default NULL,
  `nbr_jours` int(11) default NULL,
  `prix` varchar(10) default NULL,
  `statut` tinyint(1) default NULL,
  `date_abonnement` datetime NOT NULL,
 */

class TAbonnement extends Zend_Db_Table_Abstract
{
	protected $_name = 'abonnements';
	
	public function  insertAbonnement($data)
	{
		$iData = array(
						'email_user'	=> $data['email'],
						'nbr_jours'		=> $data['nbr_jours'],
						'prix'			=> $data['prix'],
						'statut'		=> 1,
						'date_abonnement'=>new Zend_Db_Expr('NOW()')
					);
					
		parent::insert($iData);
	}
	
	static public function getLeftByClient($email)
	{
		$testa = new TAbonnement;
		$sel = $testa->select()
		->from(	array('a'=>'abonnements'),
				array('jours'=>"TO_DAYS(date_add(date_abonnement, interval nbr_jours DAY)) - TO_DAYS(now())")
			)
		->where(' date_add(date_abonnement, interval nbr_jours DAY ) > now() and ' .
				'email_user like "' . $email . '"')
		->order('date_abonnement desc');
			    		
    	$testa = $testa->fetchRow($sel);
    	
    	return (count($testa)) ? $testa->jours : 0;
	}
}
?>