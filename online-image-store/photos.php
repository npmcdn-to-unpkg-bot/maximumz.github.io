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
<!-- Masonry grid of latest images -->
<div class="row">
    <div class="grid" class="container">

       <?php 
            foreach($getAllImageInfo_result as $post){
                echo "<div class='grid-item text-center'>
                <h6>".$post['title']."</h6>
                <img class='img-responsive' src='".$post['watermarked_url']."'>";
                
                if($logged_in == true){ 
                    echo "<form method='POST' action='content/buy-image.php'>
                    <input type='hidden' name='photoID' value='".$post['photo_id']."'>
                    <button class='btn btn-success purchase'>Pruchase</button>
                    </form>";
                }else{
                    echo "You must <a href='login.php'>login</a> to pruchase.";
                } echo "</div>";
            }
        ?>
        

    </div>
</div>

<?php include '/conf/footer.php'; ?>
    </body>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
    <script>
        $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 200,
            gutter: 10
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
</html>