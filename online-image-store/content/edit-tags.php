<?php
require '../conf/config.php';

//edit the photo title
$edit_success = false;
if(isset($_POST['photo-tags'])){
    $photoID = $_POST['photoID'];
    $photoTags = $_POST['photo-tags'];
    $thisUsername = $_SESSION['users']['username'];
    
    //set photo title
    $set_tags_query = "UPDATE photos SET tags='".$photoTags."' WHERE photo_id='".$photoID."'";
    $set_tags_result = mysqli_query($link, $set_tags_query);

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