<?php
require("http://forum.maximizedpotential.co.nz/config.php");

$first_blog_query = "SELECT * FROM topics ORDER BY topic_id DESC LIMIT 1";
$first_blog_result = mysqli_query($link, $first_blog_query);
$result1 = $first_blog_result->fetch_assoc();

if(!$first_blog_result){
  echo "Sound the alarm! Brace yourself for impact!";  
}

$second_blog_query = "SELECT * FROM topics ORDER BY topic_id DESC LIMIT 1,1";
$second_blog_result = mysqli_query($link, $second_blog_query);
$result2 = $second_blog_result->fetch_assoc();

if(!$second_blog_result){
  echo "Sound the alarm! Brace yourself for impact!";  
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/norm.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
    <?php include 'include/header.php' ; ?>
        <div class="row main-title">
            <div class="large-12 columns text-center">
                <h1>Weclome to The Cloud!</h1>
                <h3>The Place to Discuss Web/Tech Related Stuff</h3>
            </div>
        </div>
        <div class="row main">
            <div class="small-12 large-4 columns text-center">
                <h3>Get stuck in!</h3>
                <i class="fa fa-universal-access"></i>
        <?php
            if($logged_in == true) {
            echo '<p><a href="pages/create.php">Create</a> some new topics!</p> <p>Or go to the <a href="pages/forum.php">forum</a> to get in on the conversations...</p>';
                                    }else{
            echo '<p>To get stuck in you will need to register first!<br>Follow this <a href="include/access/registar.php">link to register</a>..</p>';
            }?>
            </div>
            <div class="small-12 large-4 columns text-center">
                <h3>What is this?</h3>
                <i class="fa fa-sitemap" aria-hidden="true"></i>
                <p>This forum is a place where you can discuss &amp; follow news on web development!</p>
            </div>
            <div class="small-12 large-4 columns text-center">
                <h3>Help me out here!</h3>
                <i class="fa fa-ambulance" aria-hidden="true"></i>
                <p>If you need help just head over to the help section &amp; your sure to find what your looking for.</p>
            </div>
        </div>
        <div class="row main">
            <h1 class="text-center">Recent Topics</h1>
            <div class="small-12 large-6 columns text-center">
        <?php 
            echo "<div class='preview'><a href='/pages/forum.php?id=".$result1['topic_id']."'>";
            echo "<h3>".$result1['topic_title']."</h3>";
            echo $result1['topic_content'];
            echo "</a></div>";
        ?>
            </div>
            <div class="small-12 large-6 columns text-center">
        <?php 
            echo "<div class='preview'><a href='/pages/forum.php?id=".$result2['topic_id']."'>";
            echo "<h3>".$result2['topic_title']."</h3>";
            echo $result2['topic_content'];
            echo "</a></div>";
        ?>
            </div>
        </div>
        <?php include 'include/footer.php'; ?>
    </body>
</html>