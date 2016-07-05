<?php

require("config.php");

$reg_username = trim($_POST['reg_username']);
$reg_email = trim($_POST['reg_email']);
$reg_password = $_POST['reg_password'];
$reg_passord_confirm = $_POST['reg_password_confirm'];
$password = password_hash($_POST['reg_password'], PASSWORD_BCRYPT);

$insert_reg = "INSERT INTO users(username, useremail, password) VALUES ('$reg_username', '$reg_email', '$password')";




if(strlen($reg_username) >= 3){
if($reg_password != $reg_passord_confirm){
    $reg_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['reg_error'] = $login_error;
    header('Location: ../login.php');
    exit();
} else {
    //add a new user
    mysqli_query($link, $insert_reg);
    
    //add a profile to user
    $new_user_query = "SELECT user_id FROM users WHERE username='".$reg_username."'";
    $new_user_result = mysqli_query($link, $new_user_query);
    $_SESSION['new_user_info'] = mysqli_fetch_assoc($new_user_result);
    $new_user_id = $_SESSION['new_user_info']['user_id'];
    $addProfile = "INSERT INTO profile(user_id, username) VALUES ('$new_user_id', '$reg_username')";
    mysqli_query($link, $addProfile);
    
    //add an account to user
    $new_profile_query = "SELECT profile_id FROM profile WHERE user_id='".$new_user_id."'";
    $new_profile_result = mysqli_query($link, $new_profile_query);
    $_SESSION['new_profile_info'] = mysqli_fetch_assoc($new_profile_result);
    $new_profile_id = $_SESSION['new_profile_info']['profile_id'];
    $addAccount = "INSERT INTO account(user_id, profile_id) VALUES ('$new_user_id', '$new_profile_id')";
    mysqli_query($link, $addAccount);
    
    header('Location: ../login.php');
    exit();
    } 
}else{
    $reg_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['reg_error'] = $login_error;
    header('Location: ../login.php');
    exit();
    }

if(strlen($reg_username) <= 2){ 
    $reg_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['reg_error'] = $login_error;
    header('Location: ../login.php');
    exit();
}

?>
