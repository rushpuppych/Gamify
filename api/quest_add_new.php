
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.QuestGenerator.php";
include_once "../lib/class.ItemNameGenerator.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";
include_once "../models/class.ActivityLogModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Validate Quest Title
if(strlen($_POST['title']) < 5) {
  echo json_encode(['status' => false, 'field' => 'quest_title', 'message' => 'Quest Title must be at least 5 characters long.']);
  exit;
}

// Build and Generate Quest
$objQuestGenerator = new QuestGenerator();
$arrQuest = $objQuestGenerator->getQuestArray($_POST['title'], ['prio' => $_POST['priority']]);

// Convert Timestamp
$numTimeStamp = time();
$numTimeStamp += ($_POST['time_days'] * 24 * 60 * 60);
$numTimeStamp += ($_POST['time_hours'] * 60 * 60);
$numTimeStamp += ($_POST['time_minutes'] * 60);

// Save Quest
$objQuestModel = new QuestModel();
$numQuestCode = $objQuestModel->createQuest($arrQuest['title'], $numTimeStamp, $arrQuest['prio'], $_POST['description'], $arrQuest['exp'], base64_encode(json_encode($arrQuest['items'])));
$strQuestCode = '{"type":"quest", "id": "' . $numQuestCode . '", "hash": "' . md5($numQuestCode . getConfig('security')['salt']) . '"}';

// Create Log Entry
$objActivityLogModel = new ActivityLogModel();
$objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'quest_count_created', 1);

// Send Response
echo json_encode(['status' => true, 'quest_code' => $strQuestCode]);
exit;
