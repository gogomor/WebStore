<?php

//definisanje putanja
defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
//define('SITE_ROOT','/home'.DS.'u931191961'.DS.'public_html'); 
define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'WebStore'.DS.'public_html');
//putanja za wamp: define('SITE_ROOT', 'C:'.DS.'wamp64'.DS.'www'.DS.'WebStore'.DS.'public_html'); 
//putanja za xampp: C:\xampp2\htdocs\dashboard\WebStore\public_html
//define('SITE_ROOT','/storage/h2/072/647072'.DS.'public_html');
defined('INCL_PATH') ? null : define('INCL_PATH', SITE_ROOT.DS.'includes');
defined('MODEL_PATH') ? null : define('MODEL_PATH', SITE_ROOT.DS.'model');
defined('CONTROLL_PATH') ? null : define('CONTROLL_PATH', SITE_ROOT.DS.'controller');



//ucitavanje configuracije
require_once(INCL_PATH.DS."config.php");
//ucitavanje kljucnih objekata
require_once(INCL_PATH.DS."validation_functions.php");
require_once(INCL_PATH.DS."pagination.php");
require_once(MODEL_PATH.DS."database.php");
require_once(CONTROLL_PATH.DS."controller.php");


//ucitavanje domenskih objekata:
require_once(MODEL_PATH.DS."domenski_objekat.php");
require_once(MODEL_PATH.DS."korisnik.php");
require_once(MODEL_PATH.DS."narudzbenica.php");

require_once(MODEL_PATH.DS."proizvod.php");
require_once(MODEL_PATH.DS."stavka_narudzbenice.php");



require_once(INCL_PATH.DS."session.php");


?>