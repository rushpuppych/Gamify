<?php // MUSST BE ON LINE 1 BECAUSE OF THE IMAGE GENERATION !!!

// Get Image Get Parameter
$strImgKey = str_replace('/', '/', $_GET['img_key']);
$strImgPath = '../assets/images/character/' . $strImgKey . '.png';

// Get Image Size Calculations
$arrSize = getimagesize($strImgPath);
$numWidth = 32;
$numHeight = 32;
$numFrameX = 0;
$numFrameY = 0;

// Arr Offsets
$arrOffset = [];
$arrOffset['armor'] = ['x' => 4, 'y' => 44];
$arrOffset['helmet'] = ['x' => 4, 'y' => -5];
$arrOffset['specialback'] = ['x' => 4, 'y' => 0];
$arrOffset['specialfront'] = ['x' => 4, 'y' => 0];
$arrOffset['shield'] = ['x' => 18, 'y' => 40];

// Get Frame if Picture is 3x4 Sprite
if($arrSize[0] > 32 || $arrSize[1] > 32) {
  $numWidth = 72;
  $numHeight = 96;
  $arrTemp = $arrOffset[$_GET['type']];
  $numFrameX = $numWidth + $arrTemp['x'];
  $numFrameY = ($numHeight * 2) + $arrTemp['y'];
}

// Create Images
$objAddImage = imagecreatefrompng($strImgPath);
$objImageContainer = imagecreatetruecolor(64, 64);

// Set Image Transparency
$strTransparentColor = ImageColorAllocate($objImageContainer, 34, 156, 0);
imagecolortransparent($objImageContainer, $strTransparentColor);
imagefill($objImageContainer, 0, 0, $strTransparentColor);

$strTransparentColor = ImageColorAllocate($objAddImage, 34, 156, 0);
imagecolortransparent($objAddImage, $strTransparentColor);
imagefill($objAddImage, 0, 0, $strTransparentColor);

// Create Image
//imagecopy($objImageContainer, $objAddImage, 0, 0, $numFrameX, $numFrameY, $numWidth, $numHeight);
imagecopyresized($objImageContainer, $objAddImage, 0, 0, $numFrameX, $numFrameY, 64, 64, $numWidth, $numHeight);

// Save Image Stream to String
ob_start();
imagepng($objImageContainer);
$strContent =  ob_get_contents();
ob_end_clean();

// Free Space
imagedestroy($objAddImage);
imagedestroy($objImageContainer);

header("Content-type: image/png");
echo $strContent;
exit;
// Send Response
//echo json_encode(['status' => true, 'image_base64' => base64_encode($strContent)]);
//exit;
