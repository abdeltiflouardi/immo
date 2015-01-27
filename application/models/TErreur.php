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

class TErreur extends Zend_Db_Table_Abstract
{
	protected $_name = 'erreur';
}
?>