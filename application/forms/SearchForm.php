<?php

/**
 *
 * 
 * @author 
 * @version
 */
class SearchForm extends Zend_Dojo_Form
{

    /**
     * Décorateur par defaut
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
    
    
    /*
     * Inialisation du formulaire
     * Function
     */
    public function init()
    {
    
    /*
     * Avoir la liste des types de biens ex(Departement, villa, maison .....)
     * Return array
     */
	$listeType 	= TTypeBien::getListe();
	
	
    /*
     * Avoir la liste des categories de biens ex(Vente, achat, location .....)
     * Return array
     */	
	$listeCat 	= TCategoriesBien::getListe();
		
	/*
	 * Définition d'un objet <select> contenant la liste des catégories
	 */
	$this->addElement(
			'FilteringSelect',
			'Categorie',
			array(
				'required'=>true,
				'label'=>'Categorie',
				'invalidMessage' => $this->getTranslator()->_('isEmpty'),
				'multiOptions'=>$listeCat
			)
		);

	/*
	 * Définition d'un objet <select> contenant la liste des types du bien
	 */	
	$this->addElement(
			'FilteringSelect',
			'TypeBien',
			array(
				'label'=>'TypeBien',
				'invalidMessage' => $this->getTranslator()->_('isEmpty'),
				'multiOptions'=>$listeType
			)
		);
	
	/*
	 * Définition d'un objet <select> contenant la liste des pays du fichier /countries.json
	 */
	$this->addElement(
		'FilteringSelect',
		'PaysBien',
		array(
				'label'       		=> 'PaysBien',
				'storeId'     		=> 'stateStore',
				'storeType'   		=> 'dojo.data.ItemFileReadStore',
				'invalidMessage' 	=> $this->getTranslator()->_('InvalidPays'),
				'storeParams' 		=> array(
											'url' => '/public/js/countries.json',
										),
				'dijitParams' 		=> array(
											'searchAttr' => 'name',
											'required'	  => false
										),
		)
		);

		
	/*
	 * Définition d'un objet <input type="text">
	 * Ville
	 */	
	$this->addElement(
			'TextBox',
			'ville',
			array(
				'label'     => 'Ville',
				'trim'      => true
			)
			);
			
		
	/*
	 * Définition d'un objet <input type="text">
	 * Prix Min en EURO
	 */
	$this->addElement(
		'CurrencyTextBox',
		'PrixD',
		array(
			'label'     => 'PrixD',
			'currency'	=> 'EUR',
			'style'		=> 'width:100px;',
			'invalidMessage' => $this->getTranslator()->_('InvalidCurrency'),
			'trim'      => true
		)
		);

	/*
	 * Définition d'un objet <input type="text">
	 * Prix Max en EURO
	 */
		$this->addElement(
			'CurrencyTextBox',
			'PrixF',
			array(
				'label'     => 'PrixF',
				'currency'	=> 'EUR',
				'style'		=> 'width:100px;',
				'invalidMessage' => $this->getTranslator()->_('InvalidCurrency'),
				'trim'      => true
			)
			);
	
			
	/*
	 * Définition d'un objet <select>
	 * Nombre Min des pièces souhaités
	 */
		$this->addElement(
				'FilteringSelect',
				'nbrPieceMin',
				array(
					'label'     => 'nbrPieceMin',
					'style'		=> 'width:100px;',
					'trim'      => true,
					'invalidMessage' => $this->getTranslator()->_('InvalidPiece'),
					'multiOptions'=>array('',1=>1,2=>2,3=>3,4=>4,5=>5)
				)
				);
	/*
	 * Définition d'un objet <select>
	 * Nombre Max des pièces souhaités
	 */		
		$this->addElement(
				'FilteringSelect',
				'nbrPieceMax',
				array(
					'label'     => 'nbrPieceMax',
					'style'		=> 'width:100px;',
					'trim'      => true,
					'invalidMessage' => $this->getTranslator()->_('InvalidPiece'),
					'multiOptions'=>array('',2=>2,3=>3,4=>4,5=>5,6=>'6+')
				)
				);
	/*
	 * Définition d'un objet <input type="text">
	 * surface Min du bien
	 */
		$this->addElement(
				'NumberTextBox',
				'surfaceD',
				array(
					'label'     => 'surfaceD',
					'style'		=> 'width:100px;',
					'trim'      => true,
					'invalidMessage' => $this->getTranslator()->_('InvalidSurface'),
					'description'=>'M²'
				)
				);
	/*
	 * Définition d'un objet <input type="text">
	 * surface Max du bien
	 */
		$this->addElement(
				'NumberTextBox',
				'surfaceF',
				array(
					'label'     => 'surfaceF',
					'style'		=> 'width:100px;',
					'trim'      => true,
					'invalidMessage' => $this->getTranslator()->_('InvalidSurface'),
					'description'=>'M²'
				)
				);		
			
	/*
	 * Définition d'un objet <input type="submit">
	 * surface Min du bien
	 */
        $this->addElement('SubmitButton', 'submit', array(
            'label' => 'Rechercher'
        ));
        
    /*
	 * Tout d'abord on élimine le decorateur actuel
	 */
      	$this->clearDecorators();
      	
    /*
	 * Aprés on définit un décorateur pour le formulaire
	 * les éléments seront entre la balise <ul> 
	 * et décorer avec dijit
	 */
        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form'))
             ->addDecorator('DijitForm')
             ->addDecorator('Fieldset', array('legend'=>'SearchCadre'));

    /*
	 * On définit le décorateur par défaut pour tous les éléments du formulaire
	 */
             
             $this->setElementDecorators($this->_defaultDecorator);
        
    /*
	 * On définit le décorateur float left/right pour les éléments 
	 * 
	 * 		prixd/prixf, 
	 * 
	 * 		nbrPieceMax/nbrPieceMin
	 * 
	 * 		surfaceD/surfaceF
	 */
             
        $this->getElement('PrixD')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('PrixF')->setDecorators($this->_floatRightDecorator);
        
        $this->getElement('nbrPieceMin')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('nbrPieceMax')->setDecorators($this->_floatRightDecorator);
        
        $this->getElement('surfaceD')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('surfaceF')->setDecorators($this->_floatRightDecorator);

	/*
	 * On définit le décorateur submit pour le bouton submit
	 */
        $this->getElement('submit')->setDecorators($this->_submitDecorator);

	/*
	 * On fait retour de l'objet form
	 */
        return $this;
    }
}


