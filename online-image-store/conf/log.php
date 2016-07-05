<?php

require("config.php");

$login_email = trim($_POST['login_email']);
$login_password = $_POST['login_password'];
$query = "SELECT * FROM users WHERE useremail='" . mysqli_real_escape_string($link, $login_email) . "'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
$password = $row['password'];
$user_name = $row['username'];


if(password_verify($login_password, $password)){
if(mysqli_num_rows($result) == 1){
    $session_id = "UPDATE users SET session_id='" . session_id() . "' WHERE useremail='" . $login_email . "'";
    mysqli_query($link, $session_id);
    header('Location: ../index.php');
    exit();
}else{
    header('Location: ../login.php');   
    exit();
}
}else{
    $login_error = "<h3 class='error'>Your details were incorrect!</h3>";
    $_SESSION['login_error'] = $login_error;
    header('Location: ../login.php');
    exit();
}
?>