<?php

/**
 *
 * 
 * @author 
 * @version
 */
class ContactForm extends Zend_Dojo_Form
{
    /**
     * Décorateur par défaut
     * @var array
     */
    protected $_defaultDecorator = array(
        array('dijitElement'),
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
        array('dijitElement'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row left')),
    );
    
    /**
     * Décorateur flottant à droite (largeur 50 %)
     * @var array
     */
    protected $_floatRightDecorator = array(
        array('dijitElement'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row right')),
    );
    
    /**
     * Décorateur avec label en style inline
     * (utile pour les cases à cocher)
     * @var array
     */
    protected $_inlineDecorator = array(
        array('dijitElement'),
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
        array('dijitElement'),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
    public function init()
    {
    	//Zend_Dojo::enableForm($this);
        $this->setName('contact-form')
                ->setAction("/contact")
             ->setAttrib('id', 'contact-form');
        
        $this->addElement(
        		'ComboBox',
        		'contactProbleme',
        		array(
        			'label'=>'contactProbleme',
        			'required' => true,
        			'multiOptions'=>array('demandeInfo', 'reclamation', 'proposition', 'autre')
        		)
        );
             
             
        $this->addElement(
        		'TextBox',
        		'Email',
        		array(
        			'label'=>'Email',
        			'required' => true,
        			'validators'=>array('EmailAddress')
        		)
        );

        $this->addElement(
        		'TextBox',
        		'Sujet',
        		array(
        			'label'=>'Sujet',
        			'required' => true,
        		)
        );
        
		$this->addElement(
		    'Textarea',
		    'Message',
		    array(
		        'label'    => 'VMessage',
		        'required' => true,
			    'style'    => 'width: 200px;height:100px;'    	
		    )
		);      
        
        $this->addElement('SubmitButton', 'submit', array(
            'label' => 'Envoyer'
        ));
        
        $this->clearDecorators();
        
        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('Form')
             ->addDecorator('Fieldset', array('legend'=>'ClientContactCadre'));
        
        $this->setElementDecorators($this->_defaultDecorator);
        
        $this->getElement('submit')->setDecorators($this->_submitDecorator);

        return $this;
    }
}
