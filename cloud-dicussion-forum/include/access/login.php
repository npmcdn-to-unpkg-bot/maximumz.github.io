<?php
require("../config.php");
    $error = false;
if(isset($_SESSION['login_error'])){
$login_error = $_SESSION['login_error'];
    $error = true;
}else{
    $error = false;
}
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="../../css/norm.css">
<link rel="stylesheet" href="../../css/style.css">
<style>
    body {
        background-image: url(../../img/white_clouds.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(116, 121, 247, 0.79);
        background-blend-mode: overlay;
    }
    
    .title h1, .title h5 {
    color: #ff6c00;
    mix-blend-mode: exclusion;
}
    .title h5 {
        padding-bottom: 1em;
    }
</style>
</head>
    <body>
        <?php include '../header.php' ; ?>
        <div class="row">
            <div class="sm-10 md-6 col text-center"> 
                <form class="reg" method="post" action="log.php">
                  <div class="title">
                       <h1>Login</h1>
                       <h5>Please enter your details below!</h5>
                   </div>
                    <input type="text" name="login_email" placeholder="Email">
                    <input type="password" name="login_password" placeholder="Password">
                    <?php if($error == true){echo $login_error;unset($_SESSION['login_error']);}?>
                    <input type="submit" value="enter" class="btn btn-success">
                </form>
            </div>
        </div>  
   </body>
</html>