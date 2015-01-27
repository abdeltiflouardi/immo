<?php

class TPossedePropBien extends Zend_Db_Table_Abstract
{
	protected $_name = 'possede_prop_bien';

	protected $_referenceMap    = array(
		'Annonce' => array(
			'columns'           => array('id_annonce'),
			'refTableClass'     => 'TAnnonces',
			'refColumns'        => array('id_annonce')
		),
		'ProprieteBien' => array(
			'columns'           => array('id_propriete'),
			'refTableClass'     => 'TProprieteBien',
			'refColumns'        => array('id_propriete')
		)
    );

    public function insertAnnonceOptions( $ida , $options)
    {
    	$where = $this->getAdapter()->quoteInto('id_annonce = ?' ,$ida);
    	$this->delete($where);
    	
    	foreach($options as $op):
    		$data = array('id_annonce'=> $ida , 'id_propriete'=>$op);
    		parent::insert($data);
    	endforeach;
    }
    
   static function getElementsForm($id){
   		$elems = array();
   		
   		if(isset($id) && !empty($id)):
			$tp = new TPossedePropBien;
			$annonce = $tp->fetchAll($tp->select()->where("id_annonce='$id'"));
			$c = count($annonce);
			if($c>0):
				foreach($annonce->toArray() as $data):
					$elems["option{$data['id_propriete']}"] = 1;
				endforeach;
			endif;
   		endif;
   		
   		return $elems;
   }

}