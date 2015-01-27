<?php

/**
 *
 * 
 * @author 
 * @version
 */
class Contact extends Zend_Form
{
    /**
     * Décorateur par défaut
     * @var array
     */
    protected $_defaultDecorator = array(
        array('ViewHelper'),
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
        array('ViewHelper'),
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
        array('ViewHelper'),
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
        array('ViewHelper'),
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
        array('ViewHelper'),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
    public function init()
    {
    	//Zend_Dojo::enableForm($this);
        $this->setName('contact-form')
             ->setAttrib('id', 'contact-form');
        
        $this->addElement('select', 'subject', array(
            'label' => 'subject',
            'required' => true,
            'multiOptions' => array('' => '', 1 => 'commercial', 2 => 'technical')
        ));
        $file1 = $this->createElement("file","file1");
$file1->setRequired(false)
       ->setLabel("File:")
       ->addValidator('Count', true, 2)     
       ->addValidator('Size', true, "100KB")
       ->addValidator('Extension', true, 'jpg')
       ->addValidator('MimeType',true,array('image/jpeg'))
       ->addValidator('ImageSize',true,array(0,0,340,480))
       ->setMultiFile(3)
       ;
$this->addElement($file1);	
        $this->addElement('text', 'firstname', array(
            'label' => 'firstname',
            'required' => true,
            'validators' => array('alnum')
        ));
        
        $this->addElement('text', 'lastname', array(
            'label' => 'lastname',
            'required' => true,
            'validators' => array('alnum')
        ));
        
        $this->addElement('text', 'email', array(
            'label' => 'email',
            'required' => true,
            'validators' => array('EmailAddress')
        ));
        
        $this->addElement('textarea', 'message', array(
            'label' => 'message',
            'rows' => 5,
            'cols' => 50,
            'required' => true
        ));
        
        $this->addElement('text', 'birthday', array(
            'label' => 'birthday',
            'description' => 'birthdayDescription'
        ));
        // date validator
        $this->getElement('birthday')->addValidator(new Zend_Validate_Date(null, Zend_Registry::get('Zend_Translate')->getLocale()));
        
        $this->addElement('checkbox', 'newsletter', array(
            'label' => 'newsletter'
        ));
        
        $this->addElement('submit', 'submit', array(
            'label' => 'submit'
        ));
        
        /**
         * Decorators
         */
        $this->clearDecorators();
        
        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('Form');
        
        $this->setElementDecorators($this->_defaultDecorator);
        
        $this->getElement('file1')->clearDecorators()
        		->addDecorator('FormElements')
                 ->addDecorator('HtmlTag', array('tag' => '<dl>', 'class' => 'zend_form'))
                 ->addDecorator('Form');
        
        $this->getElement('firstname')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('lastname')->setDecorators($this->_floatRightDecorator);
        $this->getElement('newsletter')->setDecorators($this->_inlineDecorator);
        $this->getElement('submit')->setDecorators($this->_submitDecorator);
        
        return $this;
    }
}
