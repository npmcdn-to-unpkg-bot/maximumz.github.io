<?php

require("http://forum.maximizedpotential.co.nz/config.php");

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
    header('Location: register.php');
    exit();
} else {
    mysqli_query($link, $insert_reg);
    header('Location: login.php');
    exit();
} 
}else{
    $reg_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['reg_error'] = $login_error;
    header('Location: register.php');
    exit();
}

if(strlen($reg_username) <= 2){ 
    $reg_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['reg_error'] = $login_error;
    header('Location: register.php');
    exit();
}

?>
