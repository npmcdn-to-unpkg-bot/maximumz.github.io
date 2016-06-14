<?php
require("http://forum.maximizedpotential.co.nz/config.php");

$forum_query = "SELECT * FROM topics ORDER BY topic_id DESC";
$forum_result = mysqli_query($link, $forum_query);
$forum_data = $forum_result->fetch_assoc();

if(!$forum_result){
        echo "It is broken :(";  
    }

if(isset($_POST['text'])){
        $t = $_POST['text'];
        $postDate = date('Y-m-d H:i:s');
        $topic_id = $_POST['topic_id'];
        $post_author_id = $_SESSION['users']['user_id'];
        $post_author = $_SESSION['users']['username'];
        $post_inject = "INSERT INTO posts(post_content, user_id, username, topic_id, post_date) VALUES ('$t', '$post_author_id', '$post_author', '$topic_id', '$postDate')"; 
        mysqli_query($link, $post_inject);
        unset($_POST['text']);
    }

$delete_success = false;
if(isset($_POST['admin_delete_topic'])){           
        $topicID = $_POST['topicID'];
        $admin_delete = "DELETE FROM `topics` WHERE `topic_id`='".$topicID."'";
        mysqli_query($link, $admin_delete);
        $delete_success_message = "<span class='fade-out error'>Topic deleted successfully!</span>";
        $delete_success = true;
        header('Location: forum.php');
        exit;
        }else{
        $delete_success = false;
        }
if(isset($_POST['admin_delete_post'])){
        $postID = $_POST['postID'];
        $admin_delete = "DELETE FROM `posts` WHERE `post_id`='".$postID."'";
        mysqli_query($link, $admin_delete);
        $delete_success_message = "<span class='fade-out error'>Post deleted successfully!</span>";
        $delete_success = true;
        }else{
        $delete_success = false;
}

$topic_return = false;
if(isset($_GET['id'])) {
    $topic_nav = $_GET['id'];
    $topic_query = "SELECT * FROM topics WHERE topic_id='".$topic_nav."'";
    $topic_result = mysqli_query($link, $topic_query);
    $topic_data = $topic_result->fetch_assoc();
    $topic_return = true;
}else{
    $topic_return = false;
}

function dateDifference($then) {
			$now =  new DateTime(); 
			$difference = date_diff($then, $now)->format("%y");
			if ($difference != 0) {
				return $difference." years ago";
			} else {
				$difference = date_diff($then, $now)->format("%m");
				if ($difference != 0) {
					return $difference." months ago";
				} else {
					$difference = date_diff($then, $now)->format("%d");
					if ($difference != 0) {
						return $difference." days ago";
					} else {
						$difference = date_diff($then, $now)->format("%h");
						if ($difference != 0) {
							return $difference." hours ago";
						} else {
							$difference = date_diff($then, $now)->format("%i");
							if ($difference != 0) {
								return $difference." minutes ago";
							} else {
								$difference = date_diff($then, $now)->format("%frac");
								if ($difference != 0) {
									return $difference." seconds ago";
								} else {
									return "just now";
								}
							}
						}
					}
				}
			}
		}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $forum_http ?>/css/norm.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $forum_http ?>/css/style.css">
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
            selector: 'textarea',
            inline: true,
            toolbar: 'undo redo',
            menubar: false
            });
        </script>
        <style>
            .feed .mce-toolbar-grp .mce-container .mce-panel .mce-stack-layout-item .mce-first {
                display: none;
            }
        </style>
    </head>
    <body>
    <?php include '../include/header.php';?>
        <div class="row main-title">
            <div class="small-12 text-center">
                <h1>The Cloud Forum!</h1>
                <h3>Discuss Web/Tech Related Stuff here</h3>
            </div>
        </div>

    <?php 
        if($topic_return == false){
        echo '<div class="row text-center main"><div class="small-12 large-9 columns feed">';
        echo "<h1>".$forum_data['topic_title']."</h1>";
        $topicID = $forum_data['topic_id'];
            if($is_admin == true){
                echo "<form method='POST'>
                <input type='hidden' name='topicID' value='".$topicID."'>
                <button id='delete' name='admin_delete_topic' type='submit' value='Delete'>Delete</button></form>";
            }
            echo $forum_data['topic_content'];
            echo "<hr>";
        if($delete_success==true){echo $delete_success_message;};
            $post_query = "SELECT * FROM posts WHERE topic_id = '".$forum_data['topic_id']."' ORDER BY post_id ASC";
            $post_result = mysqli_query($link, $post_query);
            echo "<div id='posts'>";
        foreach($post_result as $post){
            $then = $post['post_date'];
            $then = new DateTime($then);
            $time_result = dateDifference($then);
            $postID = $post['post_id'];
            echo "<div class='column differ'>";
        if($is_admin == true){
            echo "<form class='delete' method='POST'>
            <input type='hidden' name='postID' value='".$postID."'>
            <button id='delete' name='admin_delete_post' type='submit' value='Delete'>Delete</button></form>";
            }
            echo "<div class='post-content'>
            <p>".$post['post_content']." <span class='post-date'>- Posted " .$time_result. "</span></p>
            </div><div class='username'>
            ".$post['username']."</div>";
            echo "</div>";
            }   
        if($logged_in == true) {
            echo '<div class="small-12 large-12 column">
            <form method="POST">
            <input name="topic_id" value="'.$forum_data['topic_id'].'" style="display:none;">
            <h3>Post a comment</h3>
            <input id="post-submit" class="editable" name="text" placeholder="Comment here!">
            </input>
            <button class="button" type="submit" value="Save" id="submitbtn" name="save">Submit</button>
            </form></div>';
            }else{
            echo '<div class="text-center"><h3>You need to login to comment!</h3><br><p><a href="'.$forum_http .'/include/access/login.php">Login</a><p></div>';
            }
            echo "</div></div>";
            echo "<div class='small-12 large-3 columns fixed'><ul><h3>Latest Topics</h3>";
            foreach($forum_result as $post){
            echo "<li><a href='forum.php?id=".$post['topic_id']."'>".$post['topic_title']."</a></li>";
            }
            echo "</ul></div></div>";
            }else{
                //if topic menu called
            echo '<div class="row text-center main"><div class="small-12 large-9 columns feed">';
            echo "<h1>".$topic_data['topic_title']."</h1>";
            $topicID = $topic_data['topic_id'];
        if($is_admin == true){
            echo "<form method='POST'>
                <input type='hidden' name='topicID' value='".$topicID."'>
                <button id='delete' name='admin_delete_topic' type='submit' value='Delete'>Delete</button></form>";
                }
            echo $topic_data['topic_content'];
            echo "<hr>";
        if($delete_success==true){echo $delete_success_message;};
            $post_query = "SELECT * FROM posts WHERE topic_id = '".$topic_nav."' ORDER BY post_id ASC";
            $post_result = mysqli_query($link, $post_query);
            echo "<div id='posts'>";
        foreach($post_result as $post){
            $then = $post['post_date'];
            $then = new DateTime($then);
            $time_result = dateDifference($then);
            $postID = $post['post_id'];
            echo "<div class='column differ'>";
        if($is_admin == true){
            echo "<form class='delete' method='POST'>
            <input type='hidden' name='postID' value='".$postID."'>
            <button id='delete' name='admin_delete_post' type='submit' value='Delete'>Delete</button></form>";
            }
            echo "<div class='post-content'>
            <p>".$post['post_content']." <span class='post-date'>- Posted ".$time_result."</span></p>
            </div><div class='username'>
            ".$post['username']."</div>";
            echo "</div>";
            }   
        if($logged_in == true) {
            echo '<div class="small-12 large-12 column">
            <form method="POST">
            <input name="topic_id" value="'.$topic_data['topic_id'].'" style="display:none;">
            <h3>Post a comment</h3>
            <input id="post-submit" class="editable" name="text" placeholder="Comment here!">
            </input>
            <button class="button" type="submit" value="Save" id="submitbtn" name="save">Submit</button>
            </form></div></div></div>';
            }else{
            echo '<div class="text-center"><h3>You need to login to comment!</h3><br><p><a href="'.$forum_http .'/include/access/login.php">Login</a><p></div></div></div>';
            }
            echo "<div class='small-12 large-3 columns fixed'><ul><h3>Latest Topics</h3>";
        foreach($forum_result as $post){
            echo "<li><a href='forum.php?id=".$post['topic_id']."'>".$post['topic_title']."</a></li>";
            }
            echo "</ul></div></div>";
            }
        ?>

        <?php include '../include/footer.php'; ?>
        <script src="/js/main.js"></script>
    </body>
</html>