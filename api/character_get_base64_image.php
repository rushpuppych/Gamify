<?php // MUSST BE ON LINE 1 BECAUSE OF THE IMAGE GENERATION !!!

// Includes
include_once "../lib/global.php";
include_once "../vendor/GifCreator/GifCreator.php";
include_once "../lib/class.BaseImageGenerator.php";
include_once "../lib/class.CharacterImageGenerator.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ItemModel.php";

// Set Character
$objCharacterModel = new CharacterModel();
$arrCharacter = $objCharacterModel->getCharacterByPlayerId($_GET['player_id'])[0];

// Set Character Equip
$objItemModel = new ItemModel();
$arrEquipment = $objItemModel->getEquipedItems($_GET['player_id']);

// Load Character Image
$objCharacterImage = new CharacterImageGenerator();
$objCharacterImage->setCharacter($arrCharacter['body_key'], $arrCharacter['face_key'], $arrCharacter['hair_key'], $_GET['animation']);
$objCharacterImage->setEquipmentArray($arrEquipment);
$strContent = $objCharacterImage->renderToResourceAnimated();

// Echo Image
header("Content-type: image/gif");
echo $strContent;
exit;
