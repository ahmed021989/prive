<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$project_path = dirname(__FILE__);
$project_path = str_replace('includes', '', $project_path);
defined('SITE_ROOT') ? null : 
	define('SITE_ROOT',$project_path);
	
defined('SITE_PATH') ? null : 
	define('SITE_PATH',dirname($_SERVER['PHP_SELF']));
    
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.'includes');

// charger fichier config  avant tout
require_once(LIB_PATH.DS.'config.php');

// charger fonctions
require_once(LIB_PATH.DS.'fonctions.php');

// charger core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'bd.php');

// charger  classes
require_once(LIB_PATH.DS.'personne.php');
require_once(LIB_PATH.DS.'direction.php');
require_once(LIB_PATH.DS.'etablissement.php');
require_once(LIB_PATH.DS.'wilayas.php');
require_once(LIB_PATH.DS.'employe.php');
require_once(LIB_PATH.DS.'commune.php');
require_once(LIB_PATH.DS.'communes.php');
require_once(LIB_PATH.DS.'diplome.php');
require_once(LIB_PATH.DS.'specialite.php');
require_once(LIB_PATH.DS.'message.php');
require_once(LIB_PATH.DS.'actualite.php');
require_once(LIB_PATH.DS.'fonction.php');
require_once(LIB_PATH.DS.'fin_relation.php');
require_once(LIB_PATH.DS.'mutation.php');
require_once(LIB_PATH.DS.'transfere.php');
require_once(LIB_PATH.DS.'affiliation.php');






//require_once(LIB_PATH.DS.'contact_us.php');




?>