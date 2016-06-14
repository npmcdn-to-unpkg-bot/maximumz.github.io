<?php
require("http://forum.maximizedpotential.co.nz/config.php");

$error_report = false;
$success_report = false;
if(isset($_POST['text'], $_POST['topic_title'])){
    $ttitle = $_POST['topic_title'];
    $t = $_POST['text'];
    $forum_author_id = $_SESSION['users']['user_id'];
    $forum_author = $_SESSION['users']['username'];
    $forum_inject = "INSERT INTO topics(topic_title, topic_content, user_id, username, topic_date) VALUES ('$ttitle', '$t', '$forum_author_id', '$forum_author', NOW())"; 
    mysqli_query($link, $forum_inject);
    $success_report = true;
    $success = "Your Forum Topic has been created!";
    }else{
        $error_report = true;
        $error = "Both an awesome title & content are required!";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/norm.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: 200,
                plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
                        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io']
                        });
        </script>
    </head>
    <body>
    <?php include '../include/header.php'; ?>
        <div class="row text-center main-title">
            <div class="large-12 columns text-center">
                <h1>Create, discuss &amp; build!</h1>
            </div>
        </div>
    <?php  if($logged_in == true) {
                echo '<div class="row main"><div class="small-10 small-offset-2 large-9 large-offset-2 column">';
            if($error_report == true){echo '<div class="text-center error">'.$error.'</div>';}
            if($success_report == true){echo '<div class="text-center success">'.$success.'</div>';}
                echo '<form method="POST">
                <h3>Forum Topic Title</h3>
                <input type="text" name="topic_title" id="topic_title" placeholder="Type your heading here!">
                <h3>Forum Topic Content</h3>
                <textarea id="main_editor" name="text">
                <p>Start typing your new blog content here up to 200 characters!</p>
                </textarea>
                <button class="button" type="submit" value="Save" id="submitbtn" name="save">Save</button>
                </form>
                </div>
                </div>';
                }else{
                echo '<div class="text-center"><h3>You need to login to comment!</h3><br><p><a href="'.$forum_http.'/include/access/login.php">Login</a><p></div>';
                } ?>


    <?php include '../include/footer.php'; ?>
    </body>
</html>