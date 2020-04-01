<?php 
include_once 'config/init.php';

$locations = new Location;

$template = new Template('templates/location-list.php');

$template->locations = $locations->getLocations();

echo $template;