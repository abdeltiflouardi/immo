<?php
//var_dump($_POST);
//exit;
/**
 *
 * 
 * @author
 * @version
 */

// définition des constantes /*'1.8.a1'1.10.2*/

define('ZFV',					'1.10.2' );
define('WEBAPP_DIR', 			realpath(dirname(__FILE__) . '/'));

//define("BUSINESS", "elasri_abdeljalil@hotmail.com");
define("BUSINESS", "elasri_hajar@hotmail.com");
if(file_exists('server')):
	define('LIBRARY', 		 		'../www/library');
	$env = 'production';
	define('SERVER_NAME' , 'immobilier.trouvez-services.com');
	define('SERVER_PAYPAL' , 'www.sandbox.paypal.com');
else:
	define('LIBRARY', 		 		'../zend/' . ZFV . '/library');
	$env = 'development';
	define('SERVER_NAME' , 'immo');
	define('SERVER_PAYPAL' , 'www.sandbox.paypal.com');
endif;

define('APP_DIR', 				WEBAPP_DIR . '/application');
define('MODELS_DIR', 			WEBAPP_DIR . '/application/models');
define('CONTROLLERS_DIR', 		WEBAPP_DIR . '/application/controllers');
define('FORMS_DIR', 			WEBAPP_DIR . '/application/forms');
define('VIEWS_DIR', 			WEBAPP_DIR . '/application/views');
define('LAYOUTS_DIR', 			WEBAPP_DIR . '/application/layouts');
define('HELPERS_DIR', 			WEBAPP_DIR . '/application/views/helpers');
define('PARTIALS_DIR', 			WEBAPP_DIR . '/application/views/scripts/partials');
define('LANGUAGES_DIR', 		WEBAPP_DIR . '/application/languages');

// relative URL (idem .htaccess)
define('BASE_URL', '/');

// include path
set_include_path(
    LIBRARY . 		PATH_SEPARATOR .
    MODELS_DIR . 	PATH_SEPARATOR .
    FORMS_DIR . 		PATH_SEPARATOR .
    '.' . 				PATH_SEPARATOR .
    get_include_path()
);

require_once APP_DIR . '/Initializer.php';

// autoloading
//require_once 'Zend/Loader.php';
//Zend_Loader::registerAutoload();
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Default_');
$loader->suppressNotFoundWarnings(false);
$loader->setFallbackAutoloader(true);

 
// préparation du front controller (avec environnement en paramètre)
$frontController = Zend_Controller_Front::getInstance();
$frontController->registerPlugin(new Initializer($env));

$frontController->dispatch();
unset($frontController);
