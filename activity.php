<?php 
include_once 'config/init.php';

$activities = new Activity;

//get posted data
if(isset($_POST['submit'])){
    //create data array
    $data = array(
        'id' => $_POST['id'],
        'name' => $_POST['activity_name']
    );

    if($_POST['a']=='c'){ //create new activity
        if($activities->createActivity($data)){
            redirect('activity-list.php', 'Activity Created', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='e'){ //edit activity
        if($activities->editActivity($data)){
            redirect('activity-list.php', 'Activity Edited', 'success');
        }else{
            redirect('activity.php?id='.$_POST['id'].'&a=e', 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='d'){
        if($activities->deleteActivity($data['id'])){
            redirect('activity-list.php', 'Activity Deleted', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }
}

$template = new Template('templates/single-activity.php');

//grab parameters from GET request (only while reading)
$activity_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//for editing we need the id and action
if(is_numeric($activity_id) && $action == 'e'){ 
    $template->activity = $activities->getActivity($activity_id);
    $title = 'Edit Activity';
}else{ 
    $template->activity = null;
    $title = 'Create Activity';
}

//extra variables for the template
$template->action = $action;
$template->title = $title;

//output the template
echo $template;