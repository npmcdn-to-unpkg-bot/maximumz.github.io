<?php
require("../config.php");
$error = false;
if(isset($_SESSION['reg_error'])){
$reg_error = $_SESSION['reg_error'];
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
    <?php include '../header.php'; ?>
    <div class="row">
        <div class="col md-6 text-center">  
            <form class="reg" method="post" action="reg.php">
                  <div class="title">
                       <h1>Register</h1>
                       <h5>Please fill in all the fields below!</h5>
                   </div>
                <?php if($error == true){echo $reg_error;unset($_SESSION['reg_error']);}?>
                <input id="reg-name" type="text" name="reg_username" placeholder="Username">
                <span id="name-length-error" class="hidden">Your name will need to be between 4 - 8 characters long!</span>
                <span id="name-type-error" class="hidden">You can't use that name sorry!</span>
                <input id="reg-email" type="text" name="reg_email" placeholder="Email">
                <span id="email-error" class="hidden">Please enter a valid email!</span>
                <input id="pass-length" type="password" name="reg_password" placeholder="Password">
                <span id="pass-error-length" class="hidden">Your password will needs to be at least 8 characters!</span>
                <input id="pass-match" class="hidden" type="password" name="reg_password_confirm" placeholder="Confirm Password">
                <span id="pass-error-match" class="hidden">Your password does not match!</span>
                <br>
                <input id="submit" type="submit" value="Submit" class="btn btn-success" disabled>
            </form>
        </div>
    </div>
    <script src="../../js/verify.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            validateMe();
        });
    </script>
   </body>

</html>