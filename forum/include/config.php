<?php
session_start();

//declare your MySQL database connection details below 
$host = "localhost";
$username = "";
$password = "";
$dbname = "";

//declare your forum root domain below
$forum_http = "http://maximumz.github.io/forum";

//database connection
$link = mysqli_connect($host, $username, $password, $dbname);

//if no connection made check database connection details
if(!$link){
    die("Sorry there was no connection" . mysqli_connect_ERROR() . " (" . mysqli_connect_errno() . ") " );
}

//create a session id for the current user
$session_query = "SELECT * FROM users WHERE session_id='" . session_id() . "'";
$logged_in = false;
$is_admin = false; 
$session_result = mysqli_query($link, $session_query);

//if query returns nothing connection dies
if(!$session_result){
    die("Sorry");
}

//check if user is logged in
if(mysqli_num_rows($session_result) == 1){
    $_SESSION['users'] = mysqli_fetch_assoc($session_result);
    $logged_in = true;
//check for admin status
    $admin_query = "SELECT admin FROM users";
    $check_admin = mysqli_query($link, $admin_query);
    $is_admin = false;
if($_SESSION['users']['admin'] == 1){
    $is_admin = true; 
}
}

?>