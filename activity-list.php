<?php 
include_once 'config/init.php';

$activities = new Activity;

$template = new Template('templates/activity-list.php');

$template->activities = $activities->getAllActivities();

echo $template;