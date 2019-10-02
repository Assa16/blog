<?php 
require 'vendor/autoload.php';
require_once('src/session.php');
require_once 'src/HomeController.php';
require_once 'src/PostController.php';
require_once 'src/ProfileController.php';
require_once 'src/AuthentificationController.php';
require_once 'src/PostprofileController.php';

Flight::set('flight.views.path',  './templates');
Flight::set('flight.compiled.views.path', './templates/cache');
// Set the view renderer use twig. Before deploying to prod. activate the cache and
// set the web user allowed to read/write from/to the folder.
$loader = new Twig_Loader_Filesystem(Flight::get('flight.views.path'));
$twigConfig = array(
	'cache'	=>	Flight::get('flight.compiled.views.path'),
	'cache'	=>	false,
	'debug'	=>	true,
);
// Sets twig as the view handler for Flight.
Flight::register('view', 'Twig_Environment', array($loader, $twigConfig), function($twig) {
	$twig->addExtension(new Twig_Extension_Debug()); // Add the debug extension
});
// Map the call for ease of use.
Flight::map('render', function($template, $data){
	echo Flight::view()->render($template, $data);
});

 Flight::route('/hello', function(){
    echo 'hello world!';
});
// Register your class
Flight::register('db','ORM');
Flight::route('GET /',array('HomeController','index'));
Flight::route('GET /inscription',array('AuthentificationController','register_index')); 
Flight::route('POST /inscription',array('AuthentificationController','register')); 
Flight::route('GET /connection',array('AuthentificationController','login_index')); 
Flight::route('POST /connection',array('AuthentificationController','login')); 
Flight::route('GET /deconnection',array('AuthentificationController','logout'));
//Flight::route('POST /posts/create',array('HomeController','create'));
Flight::route('POST /posts/create',array('PostController','create'));
Flight::route('GET /profile',array('ProfileController','display'));
Flight::route('GET /profile/update',array('ProfileController','update_index'));
Flight::route('POST /profile/update',array('ProfileController','update'));
Flight::route('GET /post/@id',array('PostprofileController','show'));
Flight::start();
?>
