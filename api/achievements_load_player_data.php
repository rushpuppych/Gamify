
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.Character.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.ActivityLogModel.php";
include_once "../models/class.CharacterModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Set Character
$objCharacterModel = new CharacterModel();
$arrCharacter = $objCharacterModel->getCharacterByPlayerId($_SESSION['user']['character']['id'])[0];

// Get Character Informations
$objCharacter = new Character($arrCharacter, []);
$arrExpLevelSystem = $objCharacter->getExpLevelSystem();

// Get Achievements Data
$objQuestModel = new ActivityLogModel();
$arrResult = $objQuestModel->getAchievementsView($_SESSION['user']['character']['id'])[0];
$arrResult['level'] = $arrExpLevelSystem['level'];

// Send Response
echo json_encode(['status' => true, 'achievment_data' => $arrResult]);
exit;
