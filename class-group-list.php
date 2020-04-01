<?php 
include_once 'config/init.php';

$class_groups = new ClassGroup;

$template = new Template('templates/class-group-list.php');

$template->class_groups = $class_groups->getAllClassGroups();

echo $template;