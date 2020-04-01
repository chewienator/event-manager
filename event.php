<?php 
include_once 'config/init.php';

$events = new Event;
$activities = new Activity;
$locations = new Location;
$users = new User;
$class_groups = new ClassGroup;

//get posted data
if(isset($_POST['submit'])){
    //create data array
    $data = array(
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'activity_id' => $_POST['activity'],
        'date_time' => $_POST['datetime'],
        'registration_close' => $_POST['registration_close'],
        'location_id' => $_POST['location'],
        'location_id2' => $_POST['location2'],
        'description' => $_POST['description'],
        'organisers' => $_POST['organisers'],
        'class_groups'=> $_POST['class_groups']
    );

    if($_POST['a']=='c'){ //create new Event
        if($events->createEvent($data)){
            redirect('index.php', 'Event Created', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='e'){ //edit Event
        if($events->editEvent($data)){
            redirect('index.php', 'Event Edited', 'success');
        }else{
            redirect('event.php?id='.$_POST['id'].'&a=e', 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='d'){
        if($events->deleteEvent($data['id'])){
            redirect('index.php', 'Event Deleted', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }
}

$template = new Template('templates/single-event.php');

//grab parameters from GET request (only while reading)
$event_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//for editing we need the id and action
if(is_numeric($event_id) && $action == 'e'){ 
    $template->event = $events->getEvent($event_id);
    $template->organisers = $events->getEventOrganisers($event_id);
    $title = 'Edit Event';
}else{ 
    $template->event = null;
    $title = 'Create Event';
}

$template->action = $action;
$template->activities = $activities->getAllActivities();
$template->locations = $locations->getLocations();
$template->teachers = $users->getStaffUsers();
$template->class_groups = $class_groups->getAllClassGroups();


echo $template;