<?php
//start session
session_start();

//config files
require_once 'config.php';

//Helper file
require_once 'helpers/system_helper.php';

//Autoloader
function myAutoLoader($class_name){
    require_once 'lib/'.$class_name.'.php';
}

//register autoload function
spl_autoload_register('myAutoLoader');
