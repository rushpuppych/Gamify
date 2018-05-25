
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.HtmlMailSender.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";
include_once "../models/class.AccountModel.php";
include_once "../models/class.ActivityLogModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Cancel Quest
$objQuestModel = new QuestModel();
$arrQuest = $objQuestModel->cancelQuest($_POST['quest_id'], $_SESSION['user']['character']['id']);

// Create Cancle quest entry
$objActivityLogModel = new ActivityLogModel();
$objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'quest_count_canceled', 1);

// Check if not allready finished (Hack atempt!)
if(is_bool($arrQuest)) {
  if(!$arrQuest) {
    echo json_encode(['status' => false, 'msg' => 'This Quest is allready finished or canceled.']);
    exit;
  }
}

// Send Response
echo json_encode(['status' => true]);
exit;
