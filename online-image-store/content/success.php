<?php
require("../conf/config.php");

    $item_price = 10;
    $_SESSION['payment_success'] = "Yeehaa payment accepted!";
    
    $user_balance = $userAccount['balance'];
    $a = array($user_balance,$item_price);
    $add_credit = array_sum($a);
    
    $send_credit_query = "UPDATE account SET balance ='".$add_credit."' WHERE user_id ='".$userData['user_id']."'";
    $send_credit = mysqli_query($link, $send_credit_query);

    header('Location: ../account.php');

?>