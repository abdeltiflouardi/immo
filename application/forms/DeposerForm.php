<?php

/**
 *
 * 
 * @author 
 * @version
 */
class DeposerForm extends Zend_Dojo_Form
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
        array('Description', array('tag' => 'div', 'class' => 'indication')),        
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row files')),
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
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false, 'placement'=>'append')),
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
    
    
	$listeType 	= TTypeBien::getListe();
	$listeCat 	= TCategoriesBien::getListe();
	$listeProp	= TProprieteBien::getListe();
	
	$listeCat[array_search('Achat',$listeCat)]	= 'Vente';
	
	
	$this->addElement(
			'FilteringSelect',	
			'Categorie',
			array(
				'label'=>'Categorie',
				'multiOptions'=>$listeCat
			)
		);

	$this->addElement(
			'FilteringSelect',
			'TypeBien',
			array(
				'label'=>'TypeBien',
				'multiOptions'=>$listeType
			)
		);
			
	$this->addElement(
		'FilteringSelect',
		'PaysBien',
		array(
			'label'       => 'PaysBien',
			'invalidMessage'=>$this->getDefaultTranslator()->_('InvalidPays'),
			'storeId'     => 'stateStore',
			'storeType'   => 'dojo.data.ItemFileReadStore',
			'storeParams' => array(
			'url' => '/public/js/countries.json',
			),
			'dijitParams' => array(
			'searchAttr' => 'name',
			),
		)
		);
		
		$this->addDisplayGroup(
				array('Categorie', 'TypeBien','PaysBien'), 
				'G1',
				array('legend'=>'SelectCritere')
			);
	
		
		$this->addElement(
			'TextBox',
			'Adresse',
			array(
				'label'=>'Adresse'
			)
		);
		//$this->getElement('Adresse')->addValidator('StringLength', false, array(6, 20));

		
		$this->addElement(
			'TextBox',
			'CodePostal',
			array(
				'label'=>'CodePostal'
			)
		);
		
		$this->addElement(
			'TextBox',
			'Ville',
			array(
				'required'=>true,
				'label'=>'Ville'
			)
		);

		$this->addElement(
			'TextBox',
			'nbrPiece',
			array(
				'label'=>'nbrPiece'
			)
		);	

		$this->addElement(
			'TextBox',
			'surface',
			array(
				'label'=>'surface',
				'description'=>'sufaceUnite'
			)
		);	
		
		$this->addElement(
			'CurrencyTextBox',
			'Prix',
			array(
				'label'=>'Prix',
				'required'=>true,
				'currency'=>'EUR',
			    'invalidMessage'=>$this->getDefaultTranslator()->_('InvalidCurrency'),		
				'description'=>'prixUnite'
			)
		);	
		
		$this->addDisplayGroup(
			array('Adresse','CodePostal','Ville','nbrPiece','surface','Prix'), 
			'G2',
			array('legend'=>'InfoBien')
		);
		
		$this->addElement(
			'TextBox',
			'Seduire',
			array(
				'description'=>'indicTitreAnnonce',
				'label'=>'Seduire',
				'required'=>true
			)
		);			

	$this->addElement(
    'SimpleTextarea',
    'ContenuAnnonce',
	    array(
	        'label'    => 'ContenuAnnonce',
	        'required' => true,
	        'style'    => 'width: 200px;height:100px;'
	    )
	);
		$this->addDisplayGroup(
			array('Seduire', 'ContenuAnnonce', 'Images'), 
			'G3',
			array('legend'=>'VotreAnnonce')
		);
		
		
		$this->addElement(
			'TextBox',
			'TelContact',
			array(
				'label'=>'TelContact',
				'description'=>'indicTelContact'
			)
		);

		$this->addElement(
			'TextBox',
			'EmailContact',
			array(
				'label'=>'EmailContact',
				'description'=>'indicEmailContact'
			)
		);		
		
		$this->addDisplayGroup(
			array('EmailContact','TelContact'), 
			'G4',
			array('legend'=>'Contact')
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
		
		$this->addDisplayGroup(
			array('Images'), 
			'G5',
			array('legend'=>'Photo')
		);
		
		foreach($listeProp as $k=>$v):
			$this->addElement('CheckBox', "option$k", array(
	            'label' => $v
			));
			$elems[] = "option$k";
		endforeach;
		
        $this->addDisplayGroup(
			$elems, 
			'G6',
			array('legend'=>'OtherOptions')
		);
		
		
        $this->addElement('SubmitButton', 'submit', array(
            'label' => 'Enregistrer'
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
       	
        foreach($listeProp as $k=>$v)
        	$this->getElement("option$k")->setDecorators($this->_inlineDecorator);
        
        $this->getElement('Seduire')->setDecorators($this->_indicationDecorator);
        $this->getElement('EmailContact')->setDecorators($this->_indicationDecorator);
        $this->getElement('TelContact')->setDecorators($this->_indicationDecorator);
        $this->getElement('Images')->setDecorators($this->_filesDecorator);
        $this->getElement('submit')->setDecorators($this->_submitDecorator);        
        
        return $this;
    }
}


