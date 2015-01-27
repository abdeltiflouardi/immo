<?php

/**
 *
 * 
 * @author 
 * @version
 */
class ModifyProfileForm extends Zend_Dojo_Form
{
 	protected $_standardGroupDecorator = array(
        'DijitElement',
        array('HtmlTag', array('tag'=>'ol')),
        'Fieldset'
    );
	
     /**
     * Décorateur pour les indication
     * @var array
     */
	
    protected $_indicationDecorator = array(
        array('DijitElement'),
        array('Errors'),
        array('Description', array('tag' => 'div', 'class' => 'indication')),        
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
    /**
     * Décorateur par défaut
     * @var array
     */
	
    protected $_defaultDecorator = array(
        array('DijitElement'),
        array('Description', array('tag' => 'span', 'class' => 'description')),
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
    
    public function init()
    {
		$this->setElementFilters(array('StringTrim'));
		$this->addElementPrefixPath('My_Validate', 'My/Validate/', Zend_Form_Element::VALIDATE);
		
		$this->addElement(
			'PasswordTextBox',
			'OlderPassword',
			array(
		        'label'          => 'OlderPassword',
		        'trim'           => true,
				'description'=>'descOlderPassword',
		        'lowercase'      => true,
		        'regExp'         => '^[a-z0-9]{6,}$',
		        'invalidMessage' => $this->getTranslator()->_('notAlnum'),
				'validators'	 => array(
										array('IsPasswordValid')
									)
		    	)
		);		
		
		
		$this->addElement(
			'PasswordTextBox',
			'Password',
			array(
		        'label'          => 'NewPassword',
		        'trim'           => true,
		        'lowercase'      => true,
		        'regExp'         => '^[a-z0-9]{6,}$',
		        'invalidMessage' => $this->getTranslator()->_('notAlnum')
		    	)
		);
		
		$this->addElement(
			'PasswordTextBox',
			'password_confirm',
			array(
					'label'=>'RNewPassword', 
			        'trim'           => true,
			        'lowercase'      => true,
			        'regExp'         => '^[a-z0-9]{6,}$',
			        'invalidMessage' => $this->getTranslator()->_('notAlnum'),
					'validators' => array(
											array('PasswordConfirmation')
										)
					)
		);
		
		
			$this->addDisplayGroup(
				array('OlderPassword', 'Password','password_confirm'), 
				'G1',
				array('legend'=>'legendPassword')
			);
		
		
		$this->addElement(
			'TextBox',
			'Nom',
			array('label'=>'nom')
		);

		$this->addElement(
			'TextBox',
			'Prenom',
			array('label'=>'prenom')
		);

		$this->addElement(
			'TextBox',
			'Adresse',
			array('label'=>'Adresse')
		);
		
		$this->addElement(
			'TextBox',
			'Ville',
			array('label'=>'Ville')
		);
		
		$this->addElement(
			'TextBox',
			'CodePostal',
			array('label'=>'CodePostal')
		);
	
	/*
	 * Définition d'un objet <select> contenant la liste des pays du fichier /countries.json
	 */
	$this->addElement(
		'FilteringSelect',
		'Pays',
		array(
				'label'       		=> 'Pays',
				'storeId'     		=> 'stateStore',
				'required'			=> true,
				'storeType'   		=> 'dojo.data.ItemFileReadStore',
				'invalidMessage' 	=> $this->getTranslator()->_('InvalidPays'),
				'storeParams' 		=> array(
											'url' => '/public/js/countries.json',
										),
				'dijitParams' 		=> array(
											'searchAttr' => 'name'
										),
		)
		);
		
		$this->addElement(
			'TextBox',
			'Tel',
			array('label'=>'Tel')
		);
		
		
		$this->addDisplayGroup(
			array('Nom', 'Prenom','Adresse', 'Ville', 'CodePostal', 'Pays' , 'Tel'), 
			'G2',
			array('legend'=>'legendProfile')
		);
		
		$this->addElement('SubmitButton', 'submit', array(
            'label' => 'Modifier'
        ));
        
        $this->setDisplayGroupDecorators(array(
		    'FormElements',
		    'Fieldset'
		));	
        
        $this->clearDecorators();
        
        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('DijitForm');

        $this->setElementDecorators($this->_defaultDecorator);

        $this->getElement('OlderPassword')->setDecorators($this->_indicationDecorator);  
        $this->getElement('submit')->setDecorators($this->_submitDecorator);        
        
        return $this;
    }
}
