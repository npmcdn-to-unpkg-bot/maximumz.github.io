<?php
require '../conf/config.php';

//edit profile details
$edit_success = false;
if(isset($_POST['profile-details'])){
    $profileDetails = $_POST['profile-details'];
    $thisUsername = $_SESSION['users']['username'];
    
    //set profile details
    $set_profile_details_query = "UPDATE profile SET details='".$profileDetails."' WHERE username='".$thisUsername."'";
    $set_profile_details_result = mysqli_query($link, $set_profile_details_query);

    $edit_success = true;
    $edit_success_message = "<span class='success fade-out'>You have succeeded!</span>";
    $_SESSION['edit_success'] = $edit_success_message;
    header('Location: ../account.php');
}else{
    $edit_success = false;
    $edit_error_message = "<span class='error fade-out'>You have failed!</span>";
    $_SESSION['edit_error'] = $edit_error_message;
    header('Location: ../account.php');
};

?>