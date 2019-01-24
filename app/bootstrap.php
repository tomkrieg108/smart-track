<?php

require_once '../app/config/config.php'; 

//Load helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

//Load libraries
// require_once 'libraries/Core.php';
// require_once 'libraries/Controller.php';
// require_once 'libraries/Database.php';
 
//Autoload core libraries (replaces the above) - the class name must match the file name for this to work
spl_autoload_register(function($className) {
  require_once 'libraries/' . $className . '.php';
});