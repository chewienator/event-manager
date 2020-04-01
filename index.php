<?php 
include_once 'config/init.php';

$events = new Event;
$activities = new Activity;

$template = new Template('templates/frontpage.php');

$activity = isset($_GET['activity']) ? $_GET['activity'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;

//filter list
if(is_numeric($activity)){
    $template->events = $events->getAllActiveEventsByActivity($activity, $sort);
}else{
    $template->events = $events->getAllActiveEvents($sort);
}

//sorting
if($sort == 'new'){
    $template->title = 'New events';
}else{
    $template->title = 'Upcoming events';
}

$template->selectedActivity = $activity;
$template->sort = $sort;


$template->activities = $activities->getAllActivities();

echo $template;