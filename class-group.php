<?php 
include_once 'config/init.php';

$class_groups = new ClassGroup;

//get posted data
if(isset($_POST['submit'])){
    //create data array
    $data = array(
        'id' => $_POST['id'],
        'name' => $_POST['class_group_name']
    );

    if($_POST['a']=='c'){ //create new activity
        if($class_groups->createClassGroup($data)){
            redirect('class-group-list.php', 'Class group Created', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='e'){ //edit activity
        if($class_groups->editClassGroup($data)){
            redirect('class-group-list.php', 'Class group Edited', 'success');
        }else{
            redirect('class-group.php?id='.$_POST['id'].'&a=e', 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='d'){
        if($class_groups->deleteClassGroup($data['id'])){
            redirect('class-group-list.php', 'Class group Deleted', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }
}

$template = new Template('templates/single-class-group.php');

//grab parameters from GET request (only while reading)
$class_group_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//for editing we need the id and action
if(is_numeric($class_group_id) && $action == 'e'){ 
    $template->class_group = $class_groups->getClassGroup($class_group_id);
    $title = 'Edit Class Group';
}else{ 
    $template->class_group = null;
    $title = 'Create Class Group';
}

//extra variables for the template
$template->action = $action;
$template->title = $title;

//output the template
echo $template;