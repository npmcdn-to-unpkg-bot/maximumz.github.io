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

$form_errors = 0;

if(isset($_POST['contact-auth'])){

$name = $_POST['contact-name'];
$email = $_POST['contact-email'];
$message = $_POST['contact-message'];
$auth = $_POST['contact-auth'];

    if(empty($name && $email && $message) ){
        $error_message = "<p class='errorfade-out text-center'>All the form fields are reqired!</p>";
        $form_errors = 1;
    }
    
    if($auth != 72) {
        $error_message = "<p class='error fade-out text-center'>Check the sum!</p>";
        $form_errors = 1;
    }
    

    if($form_errors == 0){
            require 'conf/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer();
            $mail->Charset = "utf-8";
            $mail->IsSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';       
             //Whether to use SMTP authentication
            $mail->SMTPAuth = true;       
            //Username
            $mail->Username = "mpltdtester@gmail.com";
            //password
            $mail->Password = "zigzag22zigzag22";
            $mail->SMTPSecure = "tls";
            //sent from
            $mail->setFrom('mpltdtester@gmail.com', 'Your Name');
            //sent to
            $mail->addAddress('nick@maximizedpotential.co.nz', 'Nick_O');
            $mail->isHTML(true); 

            $mail->Subject = 'MAXXI Online Store';
            $mail->Body    = 'Hi, the following is from the <b>MAXXI Online Store:-</b><br><p>Name: ' .$name. '<br>Email: ' .$email. '<br>Message: ' .$message. '<br>Kind regards,<br>MAXXI</p>';

            if(!$mail->send()) {
                echo '<p class="error fade-out text-center">Message could not be sent</p>';
            }else {
                echo '<p class="success fade-out text-center">Message has been sent</p>';
            }
        }
    unset($_POST);
}

?>
    <?php if($form_errors == 1){ echo $error_message; } ?>
    <div class="row">
        <div class="col-md-12 text-center">
           <h3>Feel free to contact us!</h3>

            <form id="contact-form" method="POST">
                <label for="contact-name">Your name</label>
                <div class="form-group">
                    <input id="contact-name" type="text" name="contact-name" placeholder="Please enter your name" required>
                </div>
                <label for="contact-email">Your email</label>
                <div class="form-group">
                    <input id="contact-email" type="email" name="contact-email" placeholder="Enter your email" required>
                </div>
                <label for="contact-message">Your Message</label>
                <div class="form-group">
                    <textarea id="contact-message" type="text" name="contact-message" placeholder="Type your message here" required></textarea>
                </div>
                <label for="contact-auth">What is 5 + 4 x 8?</label>
                <div class="form-group">
                    <input id="contact-auth" type="number" name="contact-auth" placeholder="What is 5+4x8?" required>
                </div>
                <button type="submit" name="Submit" class="btn btn-success contact-submit" value="Send">Send</button>
            </form>
        </div>
    </div>  
<?php include 'conf/footer.php'; ?>
    </body>
    <script>
        //search
        $("#ls_query").ajaxlivesearch({
            loaded_at: <?php echo $time; ?>,
            token: <?php echo "'" . $token . "'"; ?>,
            max_input: <?php echo $maxInputLength; ?>,
        });
    </script>
</html>