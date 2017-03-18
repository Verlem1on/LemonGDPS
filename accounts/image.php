<?
session_id($_GET['sid']);
session_start();

$im = imagecreate(80,31);
imageColorAllocate($im,70,68,93);

imagestring($im,20,20,10,$_SESSION['secret'],imageColorAllocate($im,rand(0, 255),rand(0, 255),rand(0, 255)));

imageline($im,20,0,80,31,imageColorAllocate($im,rand(0, 255),rand(0, 255),rand(0, 255)));
imageline($im,0,10,50,0,imageColorAllocate($im,rand(0, 255),rand(0, 255),rand(0, 255)));
imageline($im,90,5,40,31,imageColorAllocate($im,rand(0, 255),rand(0, 255),rand(0, 255)));
imageline($im,0,31,70,0,imageColorAllocate($im,rand(0, 255),rand(0, 255),rand(0, 255)));
imageGif($im);
header("Content-Type: image/gif");
?>
