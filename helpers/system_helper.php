<?php 

//Redirect to page
function redirect($page = false, $message = NULL, $message_type = NULL){
    if(is_string($page)){
        $location = $page;
    }else{
        $location = $_SERVER['SCRIPT_NAME'];
    }

    //check for message
    if($message != NULL){
        //Set message
        $_SESSION['message'] = $message;
    }
    
    //Check for message type
    if($message_type != NULL){
        $_SESSION['message_type'] = $message_type;        
    }

    //Rediect
    header('Location: '.$location);
    exit;
}

//Display message
function displayMessage(){
    if(!empty($_SESSION['message'])){
        
        //Assign message var
        $message = $_SESSION['message'];

        if(!empty($_SESSION['message_type'])){
            //Assign type var
            $message_type = $_SESSION['message_type'];

            //Create output message
            if($message_type == 'error'){
                $alert = 'danger';
            }else{
                $alert = 'success';
            }
            ?>
            <div id="msg" class="alert alert-<?php echo $alert; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }

        //Unset message form SESSION
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    
    }else{
        echo '';
    }
}