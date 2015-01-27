<?php

/**
 *
 * 
 * @author 
 * @version
 */
class AnnonceImagesForm extends Zend_Dojo_Form
{
	protected $_path = 'tmp';
	
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
    
    protected $_filesDecorator = array(
        array('File'),
        array('Errors'),
        array('decorator' => array('div' => 'HtmlTag'), 'options' => array('tag' => 'div', 'id'=>'fieldsFiles')),
        array('Label'),
        array('Description', array('tag' => 'div', 'class' => 'indication')), 
        array('decorator' => array('li' => 'HtmlTag'), 'options' => array('tag' => 'li', 'id'=>'files','class'=>'files')), 
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
    $this->setAttrib('enctype', 'multipart/form-data');
		
    	$this->addElement(
    			'hidden',
    			'id',
    			array()
    	);
    
		$this->addElement(
				'file',
				'Images',
				array(
					'label'=>'Photos',
					'multiFile'=>4,
					'destination'=>$this->_path,
					'description'=>'indicImages',
					'validators'=>array(
											array('Extension', false, 'jpg,png,gif'),
											array('Count', false, array()),
											array('Size', false, 1024 * 1024 * 5)
									)
				)
				
		);
		
		$this->addElement('SubmitButton', 'submit', array(
            'label' => 'Enregistrer'
        ));
		
		$this->addDisplayGroup(
			array('Images', 'submit' , 'id'), 
			'G5',
			array('legend'=>'Photo')
		);
		
		$this->setDisplayGroupDecorators(array(
		    'FormElements',
		    'Fieldset'
		));	
				


        $this->clearDecorators();

        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('DijitForm');

        $this->setElementDecorators($this->_defaultDecorator);
        $this->getElement('Images')->setDecorators($this->_filesDecorator);
        $this->getElement('submit')->setDecorators($this->_submitDecorator);        
        
        return $this;
    }
}


