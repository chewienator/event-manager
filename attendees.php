<?php 
include_once 'config/init.php';

$event = new Event;
$users = new User;

//grab parameters from GET request (only while reading)
$event_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//get request data
if(isset($action)){
    //create data array
    $data = array(
        'event_id' => $_GET['id'],
        'user_id' => $_GET['uid'],
        'state' => $_GET['s'],
        'is_organiser' =>  $_GET['is_organiser']
    );

    $saved = false;
    switch($action){
        case 'c':
            $saved = $event->addAttendee($data);
            break;
        case 'attending':
            $saved = $event->attendeeStatus($data, 'attending');
            break;
        case 'confirm':
            $saved = $event->attendeeStatus($data, 'confirm');
            break;
        case 'attended':
            $saved = $event->attendeeStatus($data, 'attended');
            break;
        case 'd':
            $saved = $event->deleteAttendee($data);
            break;
        default: $saved = false;
    }

    if($saved){
        redirect("attendees.php?id=$event_id", 'Success', 'success');
    }else{
        redirect(false, 'Something went wrong please try again', 'error');
    }
    
}

$template = new Template('templates/attendee-list.php');

//extra variables for the template
$template->action = $action;
$template->event = $event->getEvent($event_id);
$template->attendees = $event->getAttendees($event_id);
$template->users = $event->getNonAttendees($event_id);

//output the template
echo $template;