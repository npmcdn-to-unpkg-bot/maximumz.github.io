<?php
include 'conf/head.php';
include 'conf/header.php';

file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');

use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;

if (session_id() == '') {
    session_start();
}

    Handler::getJavascriptAntiBot();
    $token = Handler::getToken();
    $time = time();
    $maxInputLength = Config::getConfig('maxInputLength');

$error = false;
if(isset($_SESSION['login_error'])){
$login_error = $_SESSION['login_error'];
    $error = true;
}else{
    $error = false;
}

if(isset($_SESSION['reg_error'])){
$reg_error = $_SESSION['reg_error'];
    $error = true;
}else{
    $error = false;
}
?>
        <div class="row">
            <div class="col-md-6"> 
                <form id="login-form" class="col-md-10 text-center" method="post" action="conf/log.php">
                  <div class="title">
                       <h1>Login</h1>
                       <h5>Please enter your details below!</h5>
                       <h5>If you would like to test use <br><br>username: <b>demo@gmail.com</b><br><br>password: <b>11111111</b></h5>
                   </div>
                   <div class="form-group">
                        <input class="form-control" type="text" name="login_email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="login_password" placeholder="Password">
                        <?php if($error == true){echo $login_error;unset($_SESSION['login_error']);}?>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-success">
                </form>
            </div>
        <div class="col-md-6">  
            <form id="reg-form" class="col-md-10 text-center" method="post" action="conf/reg.php">
                  <div class="title">
                       <h1>Register</h1>
                       <h5>Please fill in all the fields below!</h5>
                   </div>
                <?php if($error == true){echo $reg_error;unset($_SESSION['reg_error']);}?>
                <div class="form-group">
                    <input id="reg-name" class="form-control" type="text" name="reg_username" placeholder="Username">
                    <span id="name-length-error" class="hidden">Your name will need to be between 4 - 8 characters long!</span>
                    <span id="name-type-error" class="hidden">You can't use that name sorry!</span>
                </div>
                <div class="form-group">
                    <input id="reg-email" class="form-control" type="text" name="reg_email" placeholder="Email">
                    <span id="email-error" class="hidden">Please enter a valid email!</span>
                </div>
                <div class="form-group">
                    <input id="pass-length" class="form-control" type="password" name="reg_password" placeholder="Password">
                    <span id="pass-error-length" class="hidden">Your password will needs to be at least 8 characters!</span>
                </div>
                <div class="form-group">
                    <input id="pass-match" class="form-control hidden" type="password" name="reg_password_confirm" placeholder="Confirm Password">
                    <span id="pass-error-match" class="hidden">Your password does not match!</span>
                </div>
                <input id="submit" type="submit" value="Submit" class="btn btn-success" disabled>
            </form>
        </div>
    </div>  
<?php include 'conf/footer.php'; ?>
    <script src="js/verify.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            validateMe();
        });
    </script>
    <script>
        //search
        $("#ls_query").ajaxlivesearch({
            loaded_at: <?php echo $time; ?>,
            token: <?php echo "'" . $token . "'"; ?>,
            max_input: <?php echo $maxInputLength; ?>,
        });
    </script>
    </body>
</html>