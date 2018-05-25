
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Save Quest
$objQuestModel = new QuestModel();
$arrResult = $objQuestModel->loadQuestsByPlayerId($_SESSION['user']['character']['id']);

// Add QR codes
foreach($arrResult as $numIndex => $arrRecord) {
    $arrResult[$numIndex]['quest_code'] = md5($arrRecord['id'] . getConfig('security')['salt']);
}

// Send Response
echo json_encode(['status' => true, 'quest_data' => $arrResult]);
exit;
