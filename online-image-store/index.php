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

?>
    <div class="row text-center">
        <div class="col-md-6">
            <div class="btn btn-danger">Popular Catagories</div>
            <ul class="home-list">
                <li>Food</li>
                <li>Nature</li>
                <li>People</li>
                <li>Abstract</li>
                <li>Animals</li>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="btn btn-danger">Types of Images</div>
            <ul class="home-list">
                <li>Icons</li>
                <li>Graphics</li>
                <li>JPEG</li>
                <li>PNG</li>
                <li>SVG</li>
            </ul>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-6">
            <div class="btn btn-danger">Recently Added</div>
            <ul class="home-list">
                <li>Food</li>
                <li>Nature</li>
                <li>People</li>
                <li>Abstract</li>
                <li>Animals</li>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="btn btn-danger">Tag Word Cloud</div>
            <ul class="home-list">
                <li>Food</li>
                <li>Nature</li>
                <li>People</li>
                <li>Abstract</li>
                <li>Animals</li>
            </ul>
        </div>
    </div>
<!-- Masonry grid of latest images -->
<div class="row">
    <div class="grid" class="container">

       <?php 
    
            //counter
            $i = 0;
            //run through the images
            foreach($getAllImageInfo_result as $post){
                //limit the amount of images on home page to 12
                if($i == 12) break;
                echo "<div class='grid-item'>
                <img class='img-responsive' src='".$post['watermarked_url']."'>
                </div>";
                $i++;  
            }
        ?>
        

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
    <script>
        $('.row').imagesLoaded( function() {
            // images have loaded
            $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 200,
            gutter: 10
        });
        });
    </script>

</html>