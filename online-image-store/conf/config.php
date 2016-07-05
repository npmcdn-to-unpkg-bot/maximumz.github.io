<?php
session_start();

//declare your MySQL database connection details below 
$host = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

//database connection
$link = mysqli_connect($host, $username, $password, $dbname);

//if no connection made check database connection details
if(!$link){
    die("Sorry there was no connection" . mysqli_connect_ERROR() . " (" . mysqli_connect_errno() . ") " );
}

//create a session id for the current user
$session_query = "SELECT * FROM users WHERE session_id='".session_id()."'";
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
    $admin_query = "SELECT user_role FROM users";
    $check_admin = mysqli_query($link, $admin_query);
    $is_admin = false;
if($_SESSION['users']['user_role'] == 99){
    $is_admin = true; 
}
}

//load the images
$getAllImageInfo_query = "SELECT * FROM photos WHERE 1";
$getAllImageInfo_result = mysqli_query($link, $getAllImageInfo_query);

if(!$getAllImageInfo_query){
    die("Sorry");
}

if(mysqli_num_rows($getAllImageInfo_result) >= 1){
    $_SESSION['photos'] = mysqli_fetch_assoc($getAllImageInfo_result);
    $wmImage = $_SESSION['photos']['watermarked_url'];
}

if($logged_in == true) {
    //collect user data
    $userData = $_SESSION['users']; 
    $userPhotoQuery = "SELECT * FROM photos WHERE user_id='".$userData['user_id']."'";
    $userPhotoResult = mysqli_query($link, $userPhotoQuery);

    //collect profile data 
    $userProfileQuery = "SELECT * FROM profile WHERE user_id='".$userData['user_id']."'";
    $userProfileResult = mysqli_query($link, $userProfileQuery);
    
    //collect account data 
    $userAccountQuery = "SELECT * FROM account WHERE user_id='".$userData['user_id']."'";
    $userAccountResult = mysqli_query($link, $userAccountQuery);

    //collect order data
    $userOrderQuery = "SELECT * FROM orders WHERE user_id='".$userData['user_id']."'";
    $userOrderResult = mysqli_query($link, $userOrderQuery);
    
    //collect  
if(mysqli_num_rows($userPhotoResult) >= 1){
    $_SESSION['user-photos'] = mysqli_fetch_assoc($userPhotoResult);
    $userImages = $_SESSION['user-photos']['watermarked_url'];
}

if(mysqli_num_rows($userProfileResult) >= 1){
    $_SESSION['user-profile'] = mysqli_fetch_assoc($userProfileResult);
    $userProfile = $_SESSION['user-profile'];
}

if(mysqli_num_rows($userAccountResult) >= 1){
    $_SESSION['user-account'] = mysqli_fetch_assoc($userAccountResult);
    $userAccount = $_SESSION['user-account'];
}

if(mysqli_num_rows($userOrderResult) >= 1){
    $_SESSION['user-orders'] = mysqli_fetch_assoc($userOrderResult);
    $userOrders = $_SESSION['user-orders'];
}else{
    $userOrders = false;
}
}



//success or errors

if(isset($_SESSION['delete_success'])){
        $delete_success_message = $_SESSION['delete_success'];
        $delete_success = true;
}else{
    $delete_success = false;
};

if(isset($_SESSION['delete_error'])){
        $delete_error_message = $_SESSION['delete_error'];
        $delete_error = true;
}else{
    $delete_error = false;
};

$folder = false;
if(isset($_SESSION['test'])){
    $folder = $_SESSION['test'];
}

//edit error or success
if(isset($_SESSION['edit_success'])){
        $edit_success_message = $_SESSION['edit_success'];
        $edit_success = true;
}else{
    $edit_success = false;
};

if(isset($_SESSION['edit_error'])){
        $edit_error_message = $_SESSION['edit_error'];
        $edit_error = true;
}else{
    $edit_error = false;
};


//payment failed message
if(isset($_SESSION['payment_failed'])){
        $payment_failed_message = $_SESSION['payment_failed'];
        $payment_failed = true;
}else{
    $payment_failed = false;
};

//payment success message
if(isset($_SESSION['payment_success'])){
        $payment_success_message = $_SESSION['payment_success'];
        $payment_success = true;
}else{
    $payment_success = false;
};


?>