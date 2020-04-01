<?php 
include_once 'config/init.php';

$locations = new Location;

//get posted data
if(isset($_POST['submit'])){
    //create data array
    $data = array(
        'id' => $_POST['id'],
        'name' => $_POST['location_name'],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude']
    );

    if($_POST['a']=='c'){ //create new location
        if($locations->createLocation($data)){
            redirect('location-list.php', 'Location Created', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='e'){ //edit location
        if($locations->editLocation($data)){
            redirect('location-list.php', 'Location Edited', 'success');
        }else{
            redirect('location.php?id='.$_POST['id'].'&a=e', 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='d'){
        if($locations->deleteLocation($data['id'])){
            redirect('location-list.php', 'Location Deleted', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }
}

$template = new Template('templates/single-location.php');

//grab parameters from GET request (only while reading)
$location_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//for editing we need the id and action
if(is_numeric($location_id) && $action == 'e'){ 
    $template->location = $locations->getLocation($location_id);
    $title = 'Edit location';
}else{ 
    $template->location = null;
    $title = 'Create location';
}

//extra variables for the template
$template->action = $action;
$template->title = $title;

//output the template
echo $template;