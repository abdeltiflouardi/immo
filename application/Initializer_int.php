<?php

/**
 * Zend_Form test
 * 
 * @author
 * @version
 */

require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Initializes configuration depndeing on the type of environment 
 * (test, development, production, etc.)
 *  
 * This can be used to configure environment variables, databases, 
 * layouts, routers, helpers and more
 * 
 * @author
 * @version
 */
class Initializer extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_Config
     */
    protected static $_config;
    
    /**
     * @var string Current environment
     */
    protected $_env;
    
    /**
     * @var Zend_Controller_Front
     */
    protected $_front;
    
    /**
     * @var string Path to application root
     */
    protected $_root;
    
    /**
     * Constructor
     *
     * Initialize environment, root path, and configuration.
     * 
     * @param  string $env 
     * @param  string|null $root 
     * @return void
     */
    public function __construct($env = null, $root = null)
    {
        $this->_setEnv($env);
        if (null === $root) {
            $root = realpath(dirname(__FILE__) . '/../');
        }
        $this->_root = $root;
        
        $this->_front = Zend_Controller_Front::getInstance();
        $this->_front->setParam('env', $env);
        $this->initPhpConfig($env);
    }
    
    /**
     * Initialize environment
     * 
     * @param  string $env 
     * @return void
     */
    protected function _setEnv($env) 
    {
		$this->_env = $env;    		
    }

    /**
     * Initialize PHP config
     * 
     * @return void
     */
    public function initPhpConfig($env)
    {
        // set the test environment parameters
        switch ($env) {
            case 'development':
    			// Enable all errors so we'll know when something goes wrong
    			error_reporting(E_ALL | E_STRICT);
    			ini_set('display_startup_errors', 1);
    			ini_set('display_errors', 1);
                
    			$this->_front->throwExceptions(false);
                break;
            default:
                	//error_reporting(0);
    			//ini_set('display_startup_errors', 0);
    			//ini_set('display_errors', 0);
                
    			$this->_front->throwExceptions(true);
                break;
        }
    }
    
    /**
     * Route startup
     * 
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
       	$this->initDb();
        $this->initHelpers();
        $this->initView();
        $this->initTranslate();
        $this->initPlugins();
        $this->initRoutes();
        $this->initControllers();
    }
    
    /**
     * Initialize data bases
     * 
     * @return void
     */
    public function initDb()
    {
	switch ($this->_env) :
            case 'development':
		$var = 'local';
		;break;
	   default:
		$var = 'server';
		;break;
	endswitch;

	$config = new Zend_Config_Xml('application/config/config.xml', $var);

	$db = Zend_Db::factory($config->database->adapter,
			$config->database->params->toArray());
	
	$sql = file_get_contents('sc.sql');
	$db->getConnection()->exec($sql);
	exit('base created');
	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
    
    /**
     * Initialize action helpers
     * 
     * @return void
     */
    public function initHelpers()
    {
    	// register the default action helpers
    	Zend_Controller_Action_HelperBroker::addPath(HELPERS_DIR, 'Zend_Controller_Action_Helper');
    }
    
    /**
     * Initialize view 
     * 
     * @return void
     */
    public function initView()
    {
        // init view
        $view = new Zend_View();
        $view->strictVars()
             ->setBasePath(VIEWS_DIR)
             ->setEncoding('UTF-8')
             ->setEscape('htmlspecialchars')
		->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
        
        $view->baseUrl = BASE_URL;
        $view->applicationUrl = BASE_URL;
        
        // init viewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->setViewSuffix('php')
                     ->setView($view)
                     ->view->doctype('XHTML1_STRICT');
        
        // init view layout
        $layout = Zend_Layout::startMvc(array(
		    'layoutPath' => LAYOUTS_DIR,
		    'layout' => 'main'
		));
        $layout->setViewSuffix('php');
    }
    
    /**
     * Initialize translate
     * 
     * @return void
     */
    public function initTranslate()
    {
    	$Lang = 'fr';
    	//exit($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    	switch($Lang):
    	case 'fr': 
    		$nomFichier = 'french';
    		$code = 'fr_FR';
    		;break;
    	case 'en':
     		$nomFichier = 'english';
    		$code = 'en_EN';   		
    		;break;
    	endswitch;
    	
		$translate = new Zend_Translate('Array', LANGUAGES_DIR . '/' . $nomFichier . '.php' , $code);
        $translate->setLocale($code);
        
        
        Zend_Registry::set('Zend_Translate', $translate);
        
        Zend_Validate_Abstract::setDefaultTranslator($translate);
        Zend_Form::setDefaultTranslator($translate);
        
    }
    
    /**
     * Initialize plugins 
     * 
     * @return void
     */
    public function initPlugins()
    {
    }
    
    /**
     * Initialize routes
     * 
     * @return void
     */
    public function initRoutes()
    {
    	
        $router = $this->_front->getRouter();
        $route = new Zend_Controller_Router_Route(
    			'/recherche/*',
    			array('controller'=>'index','action'=>'index')
				);
		$router->addRoute('recherche', $route);
		        
    }
    
    /**
     * Initialize Controller paths 
     * 
     * @return void
     */
    public function initControllers()
    {
    	$this->_front->addControllerDirectory(CONTROLLERS_DIR, 'default');
    }
}
