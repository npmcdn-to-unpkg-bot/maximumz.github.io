<?php
require '../conf/config.php';
$delete_success = false;
if(isset($_POST['delete_photo'])){
    $photoID = $_POST['photoID'];
    $thisUsername = $_SESSION['users']['username'];
    
    //delete folder & images
    $get_folder_query = "SELECT * FROM photos WHERE photo_id='".$photoID."'";
    $get_folder_result = mysqli_query($link, $get_folder_query);
    $ridData = mysqli_fetch_assoc($get_folder_result);   
    $cd = '../';
    $wmImageDelete = $cd.$ridData['watermarked_url'];
    $imageDelete = $cd.$ridData['photo_url'];

    if(unlink($wmImageDelete) && unlink($imageDelete) == true){   
        
    //remove empty folders
    $folder = $imageDelete = substr($imageDelete, 0, strpos($imageDelete, $thisUsername));
    $target_folder = $folder.$thisUsername;
    rmdir($target_folder); 
    $folder = $wmImageDelete = substr($wmImageDelete, 0, strpos($wmImageDelete, $thisUsername));
    $target_folder = $folder.$thisUsername;
    rmdir($target_folder); 

    //delete data from database
    $delete_request = "DELETE FROM photos WHERE photo_id='".$photoID."'";
    $delete_result = mysqli_query($link, $delete_request);
    $delete_success = true;
    $delete_success_message = "<span class='success fade-out'>You have succeeded!</span>";
    $_SESSION['delete_success'] = $delete_success_message;
    header('Location: ../account.php');
    }

}else{
    $delete_success = false;
    $delete_error_message = "<span class='error fade-out'>You have failed!</span>";
    $_SESSION['delete_error'] = $delete_error_message;
    header('Location: ../account.php');
};
//edit the photo title
$edit_title_success = false;
if(isset($_POST['photo-title'])){
    $photoID = $_POST['photoID'];
    $photoTitle = $_POST['photo-title'];
    $thisUsername = $_SESSION['users']['username'];
    
    //set photo title
    $set_title_query = "UPDATE photos SET title='".$photoTitle."' WHERE photo_id='".$photoID."'";
    $set_title_result = mysqli_query($link, $set_title_query);

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