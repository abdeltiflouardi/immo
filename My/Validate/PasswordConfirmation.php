<?php
class My_Validate_PasswordConfirmation extends Zend_Validate_Abstract
{
    const NOT_MATCH = 'notMatch';

    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Mot de passe de confirmation est incorrect'
    );

    public function isValid($value, $context = null)
    {
  		//var_dump($value);
  		//var_dump($context);
  		//exit;
        $value = (string) $value;
        $this->_setValue($value);

        if (is_array($context)) {
            if (isset($context['Password'])
                && ($value == $context['Password']))
            {
                return true;
            }
        } elseif (is_string($context) && ($value == $context)) {
            return true;
        }

        $this->_error(self::NOT_MATCH);
        return false;
    }
}

?>