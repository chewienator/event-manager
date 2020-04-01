<?php 
include_once 'config/init.php';

$user = new User;
$groups = new ClassGroup;

//get posted data
if(isset($_POST['submit'])){
    //create data array
    $data = array(
        'id' => $_POST['id'],
        'first_name'=> $_POST['first_name'],
        'last_name'=> $_POST['last_name'],
        'email'=> $_POST['email'],
        'mobile'=> $_POST['mobile'],
        'user_type'=> $_POST['user_type'],
        'group_id'=> $_POST['group_id']
    );

    if($_POST['a']=='c'){ //create new user
        if($user->createUser($data)){
            redirect('user-list.php', 'User Created', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='e'){ //edit user
        if($user->editUser($data)){
            redirect('user-list.php', 'User Edited', 'success');
        }else{
            redirect('user.php?id='.$_POST['id'].'&a=e', 'Something went wrong please try again', 'error');
        }
    }elseif($_POST['a']=='d'){
        if($user->deleteUser($data['id'])){
            redirect('user-list.php', 'User Deleted', 'success');
        }else{
            redirect(false, 'Something went wrong please try again', 'error');
        }
    }
}

$template = new Template('templates/single-user.php');

//grab parameters from GET request (only while reading)
$user_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['a']) ? $_GET['a'] : null;

//for editing we need the id and action
if(is_numeric($user_id) && $action == 'e'){ 
    $template->user = $user->getuser($user_id);
    $title = 'Edit user';
}else{ 
    $template->user = null;
    $title = 'Create user';
}

//extra variables for the template
$template->action = $action;
$template->title = $title;
$template->groups = $groups->getAllClassGroups();
$template->user_types = $user->getUserTypes();

//output the template
echo $template;