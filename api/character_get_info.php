
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.Character.php";
include_once "../vendor/GifCreator/GifCreator.php";
include_once "../lib/class.BaseImageGenerator.php";
include_once "../lib/class.CharacterImageGenerator.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ItemModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Set Character
$objCharacterModel = new CharacterModel();
$arrCharacter = $objCharacterModel->getCharacterByPlayerId($_SESSION['user']['character']['id'])[0];

// Set Character Equip
$objItemModel = new ItemModel();
$arrEquipment = $objItemModel->getEquipedItems($_SESSION['user']['character']['id']);

// Get Character Informations
$objCharacter = new Character($arrCharacter, $arrEquipment);
$arrExpLevelSystem = $objCharacter->getExpLevelSystem();
$arrGetStats = $objCharacter->getStats();

// Create Image
$objCharacterImage = new CharacterImageGenerator();
$objCharacterImage->setCharacter($arrCharacter['body_key'], $arrCharacter['face_key'], $arrCharacter['hair_key'], 'walk_down');
$objCharacterImage->setEquipmentArray($arrEquipment);
$strBase64Image = $objCharacterImage->renderToBase64();

// Send Response
echo json_encode(['status' => true, 'player' => $arrCharacter, 'level_system' => $arrExpLevelSystem, 'stats' => $arrGetStats, 'image_base64' => $strBase64Image]);
exit;
