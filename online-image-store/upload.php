<?php
require 'conf/config.php';

$ds = DIRECTORY_SEPARATOR;  //1

$newFolder = time();
$currentUser = $_SESSION['users']['username'];

settype($newFolder, "string");
$newDir = $newFolder.$currentUser;

mkdir('uploads/vault/'.$newDir.'');

$storeFolder = 'uploads/vault/'.$newDir.'';   //2

if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];  //3             
      
    $targetPath = dirname( __FILE__ ).$ds.$storeFolder.$ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile, $targetFile); //6
    
    $photoLocation = $storeFolder.'/'.$_FILES['file']['name'];
    $photoURL = trim($photoLocation);
    
    
    //copy this image to the watermarked folder
    mkdir('uploads/watermarked/'.$newDir.'');

    $storeFolderWM = 'uploads/watermarked/'.$newDir.'';
    $copyLocation = $storeFolderWM.'/'.$_FILES['file']['name'];
    $copyPhotoURL = trim($copyLocation);
    
    copy($storeFolder.'/'.$_FILES['file']['name'], $copyLocation);
    
    //watermark
    $extn = pathinfo($copyPhotoURL, PATHINFO_EXTENSION);
    $stamp = imagecreatefrompng('img/watermark.png'); 
    $stampURL = 'img/watermark.png';
    

    
    if ($extn == "png")
        $im = imagecreatefrompng($copyLocation);
    if ($extn == "jpg" || $extn == "jpeg")
        $im = imagecreatefromjpeg($copyLocation);
    if ($extn == "gif")
        $im = imagecreatefromgif($copyLocation);
    
    $size = getimagesize($copyLocation);
    list($stamp_width,$stamp_height) = getimagesize($stampURL);
    
    // Copy the stamp image onto our photo using the margin offsets and the photo
    // width to calculate positioning of the stamp.
    
    $dest_x = $size[0] - $stamp_width - 0;
    $dest_y = $size[1] - $stamp_height - 0;
    
    $resizeWidth = $size[0]/4;
    $resizeHeight = $size[1]/4;
    $reScaled = imagescale($im, $resizeWidth, $resizeHeight,  IMG_BICUBIC_FIXED);
    
    imagejpeg($reScaled,$copyLocation, 40); 
    
    if ($extn == "png")
        $im = imagecreatefrompng($copyLocation);
    if ($extn == "jpg" || $extn == "jpeg")
        $im = imagecreatefromjpeg($copyLocation);
    if ($extn == "gif")
        $im = imagecreatefromgif($copyLocation);
    
    $size = getimagesize($copyLocation);
    $dest_x = $size[0] - $stamp_width - 0;
    $dest_y = $size[1] - $stamp_height - 0;
    
    imagecopy($im, $stamp, $dest_x/2, $dest_y/2, 0, 0, $stamp_width, $stamp_height);
    
    imagejpeg($im,$copyLocation, 100);
    
    imagedestroy($im);
    imagedestroy($reScaled);
    imagedestroy($stamp);
    
    $insertPhotoInfo = "INSERT INTO photos(user_id, watermarked_url, photo_url) VALUES ('".$_SESSION['users']['user_id']."', '$copyPhotoURL', '$photoURL')";
    mysqli_query($link, $insertPhotoInfo);
}

?>    