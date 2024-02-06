<?


  // session_destroy();
session_start();
$kode=$_GET["reqId"];
// $kode =$_SESSION["capcha"];
// sleep(1);

$image = imagecreatefrompng("bg.png"); // Generating CAPTCHA
/*$foreground = imagecolorallocate($image, 888, 80, 00);*/ // Font Color
$foreground = imagecolorallocate($image, 137, 137, 137);
$font = 'Raleway-Black.ttf';

 // imagestring($image, 30, 35, 10,$kode , $foreground);
imagettftext($image, 20, 0, 20, 30, $foreground, $font,$kode);

// echo $_SESSION["capcha"];
header('Content-type: image/png');
imagepng($image);

imagedestroy($image);

?>