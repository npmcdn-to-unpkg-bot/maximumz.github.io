<?php
require '../conf/config.php';
if($logged_in == true){
// grab the requested file's name
$this_photo_id = $_POST['photoID'];

$this_photo_query = "SELECT * FROM photos WHERE photo_id='".$this_photo_id."'";

$this_photo_result = mysqli_query($link, $this_photo_query);
$this_photo = mysqli_fetch_assoc($this_photo_result);
$back_one_folder = "../";
$file_name = $back_one_folder.$this_photo['photo_url'];

// make sure it's a file before doing anything!
if(is_file($file_name)) {

    //debit account
    $user_balance = $userAccount['balance'];
    $add_debit = $user_balance - 1;
    $send_debit_query = "UPDATE account SET balance ='".$add_debit."' WHERE user_id ='".$userData['user_id']."'";
    mysqli_query($link, $send_debit_query);
    
    //get users list & update it
    $this_users_id = $userData['user_id'];
    $this_photo_id = $this_photo['photo_id'];
    $send_order_query = "INSERT INTO orders (user_id, photo_id) VALUES ('$this_users_id','$this_photo_id')";
    mysqli_query($link, $send_order_query);

	// required for IE
	if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

	// get the file mime type using the file extension
	switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
		case 'pdf': $mime = 'application/pdf'; break;
		case 'zip': $mime = 'application/zip'; break;
		case 'jpeg':
		case 'jpg': $mime = 'image/jpg'; break;
		default: $mime = 'application/force-download';
	}
    
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file_name));	// provide file size
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();
    header('Location: ../photos.php');

}
    }else{
    header('Location: cancel.php');
}
?>