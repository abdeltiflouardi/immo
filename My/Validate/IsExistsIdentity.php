<?php
class My_Validate_IsExistsIdentity extends Zend_Validate_Abstract
{
    const Exists_IN_DB = 'existsInDB';

    protected $_messageTemplates = array(
        self::Exists_IN_DB => "'%value%' already exists"
    );

    public function isValid($value, $context = null)
    {
 		
        $this->_setValue($value);

        $client = new TClients;
        $client = $client->find($value)->current();
        
		if( isset($client->email_user) and $client->email_user == $value ):
	        $this->_error(self::Exists_IN_DB);
	        return false;       	
		endif;
		
		return true;
    }
}

?>