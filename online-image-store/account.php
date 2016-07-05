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

<div class="row">
    <div class="col-md-12 text-center">
        <?php  //error or success messages
            if($delete_success == true){
                echo $delete_success_message;
                unset($_SESSION['delete_success']);
            };
    
            if($delete_error == true){
                echo $delete_error_message;
                unset($_SESSION['delete_error']);
            };
    
            if($edit_success == true){
                echo $edit_success_message;
                unset($_SESSION['edit_success']);
            };
                
            if($edit_error == true){
                echo $edit_error_message;
                unset($_SESSION['edit_error']);
            }; 
        
            if($payment_failed == true){
                echo $payment_failed_message;
                unset($_SESSION['payment_failed']);
            };
        
            if($payment_success == true){
                echo $payment_success_message;
                unset($_SESSION['payment_success']);
            };
        ?>
            
    </div> 
    <?php if($logged_in == false){
    echo "<div class'col-md-12'><p class='text-center'>You haven't either registered or logged in yet, click <a href='login.php'>here</a> to get started!</p></div>";
    }else{
    echo "<div class='col-md-12 text-center'>
        <div class='col-md-4'>
           <h3>Your details</h3><br>    
           <p>Click <a id='edit-details'>here</a> to edit your details.</p>
           <form id='edit-details-form' class='user-data hidden' action='content/edit-profile-details.php' method='POST'>
                <div class='form-group'>
                   <h3>Profile Details</h3>
                    <input class='form-control' type='text' name='profile-details'"; 
    
            if($userProfile['details'] == NULL){
                echo "placeholder='Please enter a title here i.e web developer'>"; 
                    }else{     
                    echo "placeholder='".$userProfile['details']."'>";
                    }
                echo "</div>
            <button class='btn btn-warning edit' name='update_details' type='submit' value='Update Details'>Update Details</button>
           </form>
            <form id='edit-description-form' class='user-data hidden' action='content/edit-profile-description.php' method='POST'>
                <div class='form-group'>
                    <h3>Profile Description</h3>
                    <textarea class='form-control' type='text' name='profile-description'"; if($userProfile['description'] == NULL){
                       echo "placeholder='Please enter a description'></textarea>"; 
                    }else{     
                    echo "placeholder='".$userProfile['description']."'>".$userProfile['description']."</textarea>";
                    }
                echo "</div>
            <button class='btn btn-warning edit' name='update_description' type='submit' value='Update Details'>Update Description</button>
           </form>
            <ul class='user-data'>
                <li><b>Username:</b> '".$userData['username']."'</li>
                <li><b>Email:</b> ".$userData['useremail']."</li>
                <li><b>Details</b><br> ".$userProfile['details']."</li>
                <li><b>Discription</b><br> ".$userProfile['description']."</li>
            </ul>
            <h3>Account balance</h3>";
                echo "<b>Credits:</b> ".$userAccount['balance']."
            <ul class='user-data'>
                <p>Credit is added by $10 at a time, $10 = 10 credits.<br>1 x image = 1 x credit.</p>
                <h4>Add Credit</h4>
                <li>
                    <form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='POST' target='_top'>
                    <input type='hidden' name='cmd' value='_s-xclick'>
                    <input type='hidden' name='hosted_button_id' value='Z8WGH4EMH38EL'>
                    <input type='image' src='https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
                    <img alt='' border='0' src='https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif'  width='1' height='1'>
                    </form>
                </li>
            </ul>
            <h3>Purchased images</h3>
            <ul class='user-data'>";   
            if($userOrders == false){
                echo "You have yet to purchase an image!";
            }else{
            //$list_of_ordered_photo_id = ;
            foreach($userOrderResult as $post){
                    $purchased_photo = $post['photo_id'];
                    $get_photo_url = "SELECT * FROM photos WHERE photo_id='".$purchased_photo."'";
                    $photo_url_result = mysqli_query($link, $get_photo_url);
                    $photo_url = mysqli_fetch_assoc($photo_url_result);
                    echo "<li><img class='user-images img-responsive' src='".$photo_url['watermarked_url']."'</li>";      
            }   
            echo "</ul>";
            }
            
            echo "</div>
            <div class='col-md-4 photo-column'>
            <ul>";
                
                    echo "<h3>Here's all your images</h3><br><p>Please note you must set the title &amp; tags!</p>";
                
                    foreach($userPhotoResult as $post){
                    $photoID = $post['photo_id'];
                    $photoTitle = $post['title'];
                    $photoTags = $post['tags'];
                    //list photo's user has uploaded
                    echo "<li class='user-images'>"; 
                        
                    if($photoTitle == NULL){
                       echo "<h3>You have to set a title</h3>"; 
                    }else{     
                    echo "<h4>Photo Title: ".$photoTitle."</h4><br><h6>Photo Tags: ".$photoTags."</h6>";
                    }
                        
                    echo "<img class='img-responsive' src='".$post['watermarked_url']."'>";   

                    //add/edit title
                    if($photoTitle == NULL){
                       echo "<form class='edit-form' action='content/edit-title.php' method='POST'>
                       <div class='form-group'>
                       <input class='form-control' type='text' name='photo-title' placeholder='Enter your title here'>
                       </div>
                       <input type='hidden' name='photoID' value='".$photoID."'>
                       <button class='btn btn-warning edit' name='edit_title' type='submit' value='Edit Title'>Edit Title</button>
                    </form>
                       "; 
                    }else{
                       echo "<form class='edit-form' action='content/edit-title.php' method='POST'>
                       <div class='form-group'>
                       <input class='form-control' type='text' name='photo-title' placeholder='".$photoTitle."'>
                       </div>
                       <input type='hidden' name='photoID' value='".$photoID."'>
                       <button class='btn btn-warning edit' name='edit_title' type='submit' value='Edit Title'>Edit Title</button>
                    </form>
                    ";
                    }
                    //add/edit tags
                    if($photoTags == NULL){
                       echo "<form class='edit-form' action='content/edit-tags.php' method='POST' id='edit-tags'>
                       <div class='form-group'>
                       <textarea class='form-control' name='photo-tags'>Enter your tags seperated by a comma</textarea>
                       </div>
                       <input type='hidden' name='photoID' value='".$photoID."'>
                       <button class='btn btn-warning edit' name='edit_title' type='submit' value='Edit Title'>Edit Tags</button>
                    </form>"; 
                    }else{
                       echo "<form class='edit-form' action='content/edit-tags.php' method='POST' id='edit-tags'>
                       <div class='form-group'>
                        <textarea class='form-control' name='photo-tags'>".$photoTags."</textarea>
                       </div>
                       <input type='hidden' name='photoID' value='".$photoID."'>
                       <button class='btn btn-warning edit' name='edit_title' type='submit' value='Edit Title'>Edit Tags</button>
                    </form>
                    ";
                    }
                    //delete image
                    echo "<form class='delete-form' action='content/delete.php' method='POST'>
                    <input type='hidden' name='photoID' value='".$photoID."'>
                    <button class='btn btn-danger' name='delete_photo' type='submit' value='Delete Image'>Delete Image</button>
                    </form></li>";
                    }

            echo "</ul>
            
        </div>
        <div class='col-md-4'>
            <h3>Upload your images here</h3><br>
            <p>Images must be at least 3000x3000px</p>
            <ul class='user-data'>
                <li>
                    <form enctype='multipart/form-data' action='upload.php' class='dropzone upload'>
                    </form>
                </li>
            </ul>
        </div>
   </div>";
    }
        
    
?>
</div>
</div>


<?php include 'conf/footer.php'; ?>
   <script src="js/upload.js"></script>
    <script>
        $( "#edit-details" ).click(function() {
            $( "#edit-details-form" ).removeClass( "hidden" ).addClass( "show" );
        });
        $( "#edit-details" ).click(function() {
            $( "#edit-description-form" ).removeClass( "hidden" ).addClass( "show" );
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