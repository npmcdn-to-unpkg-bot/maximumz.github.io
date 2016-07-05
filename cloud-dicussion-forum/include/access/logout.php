<?php
require("../config.php");      
      
$logout = 'UPDATE users SET session_id = NULL WHERE user_id = "' . $_SESSION['users']['user_id'] . '" LIMIT 1';
        
mysqli_query($link, $logout);
    unset($_SESSION['users']['session_id']);
    header('Location: ../../index.php');
    exit();
?>
