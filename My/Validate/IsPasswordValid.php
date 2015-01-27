<?php
class My_Validate_IsPasswordValid extends Zend_Validate_Abstract
{
    const Password_IN_DB = 'PasswordInDB';

    protected $_messageTemplates = array(
        self::Password_IN_DB => "Password invalid"
    );

    public function isValid($value, $context = null)
    {
 		
        $this->_setValue($value);
        $auth = Zend_Auth::getInstance()->getIdentity();
        
		$user = $auth->email_user;
        
        $client = new TClients;
        $client = $client->find($user)->current();
        
		if(  $client->psw_user != $value ):
	        $this->_error(self::Password_IN_DB);
	        return false;       	
		endif;
		
		return true;
    }
}

?>