<?php

/**
 *
 * 
 * @author 
 * @version
 */
class LoginForm extends Zend_Dojo_Form
{
	
	protected $_standardGroupDecorator = array(
        'DijitElement',
        array('HtmlTag', array('tag'=>'ol')),
        'Fieldset'
    );
	
    /**
     * Décorateur par défaut
     * @var array
     */
	
    protected $_defaultDecorator = array(
        array('DijitElement'),
        array('Description', array('tag' => 'span', 'class' => 'description', 'escape' => false)),
        array('Errors'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
    /**
     * Décorateur flottant à gauche (largeur 50 %)
     * @var array
     */
    protected $_floatLeftDecorator = array(
        array('DijitElement'),
        array('Errors'),
        array('Description', array('tag' => 'span', 'class' => 'description')),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row left')),
    );
    
    /**
     * Décorateur flottant à droite (largeur 50 %)
     * @var array
     */
    protected $_floatRightDecorator = array(
        array('DijitElement'),
        array('Errors'),
        array('Description', array('tag' => 'span', 'class' => 'description')),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row right')),
    );
    
    /**
     * Décorateur avec label en style inline
     * (utile pour les cases à cocher)
     * @var array
     */
    protected $_inlineDecorator = array(
        array('DijitElement'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row inline')),
    );
    
    /**
     * Décorateur sans label, spécifique au bouton submit du formulaire
     * @var array
     */
    protected $_submitDecorator = array(
        array('DijitElement'),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
	function init(){
		$this->addElement('TextBox','login',
			array(
			 'label'		=>'Login',
			 'required'		=>true,
			)
		);
		
		$this->addElement('PasswordTextBox','pwd',    
			array(
	        'label'          => 'Password',
	        'required'       => true,
	        'trim'           => true,
	        'lowercase'      => true,
	        'regExp'         => '^[a-z0-9]{6,}$',
	        'invalidMessage' => 'Invalid password; ' .
	                            'must be at least 6 alphanumeric characters',
	    	)
		);
		$this->addElement('SubmitButton', 'submit', array('label' => 'Se connecter'));
		
		
		$this->clearDecorators();

        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('DijitForm');

        $this->setElementDecorators($this->_defaultDecorator);
                
        $this->getElement('submit')->setDecorators($this->_submitDecorator);        
        
        return $this;
	}
}
?>