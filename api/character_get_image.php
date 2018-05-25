
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../vendor/GifCreator/GifCreator.php";
include_once "../lib/class.BaseImageGenerator.php";
include_once "../lib/class.CharacterImageGenerator.php";

include_once "../models/class.BaseModel.php";
include_once "../models/class.AccountModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Set Default Character
$strBody = '115';
$strFace = '119';
$strHair = '132';
$strArmor = null;
$strHelmet = null;
$strSpecialBack = null;
$strSpecialFront = null;

// Load Character from Server
if(isset($_POST['character_id'])) {
  $numCharacterId = $_POST['character_id'];
  // TODO: Load character settings from Server
}

// Load Character from Parameter
if(isset($_POST['body_key'])) {$strBody = $_POST['body_key'];}
if(isset($_POST['face_key'])) {$strFace = $_POST['face_key'];}
if(isset($_POST['hair_key'])) {$strHair = $_POST['hair_key'];}

// Load Character Image
$objCharacterImage = new CharacterImageGenerator();
$objCharacterImage->setCharacter($strBody, $strFace, $strHair, $_POST['animation']);
$objCharacterImage->setEquipment($strArmor, $strHelmet, $strSpecialBack, $strSpecialFront);
$strBase64Image = $objCharacterImage->renderToBase64();

// Send Response
echo json_encode(['status' => true, 'image_base64' => $strBase64Image]);
exit;
