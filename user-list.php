<?php 
include_once 'config/init.php';

$users = new User;

$template = new Template('templates/user-list.php');

$template->users = $users->getAllUsers();

echo $template;