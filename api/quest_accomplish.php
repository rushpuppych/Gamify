
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.Character.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";
include_once "../models/class.ItemModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ActivityLogModel.php";


// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Accomplish Quest
$objQuestModel = new QuestModel();

$arrQuest = $objQuestModel->accomplishQuest($_POST['quest_id'], $_SESSION['user']['character']['id']);

// Check if not allready finished (Hack atempt!)
if(is_bool($arrQuest)) {
  if(!$arrQuest) {
    echo json_encode(['status' => false, 'msg' => 'This Quest is allready finished or canceled.']);
    exit;
  }
}

// Create Activity Log Model
$objActivityLogModel = new ActivityLogModel();

// Check for Levelup
$objCharacterModel = new CharacterModel();
$arrPlayer = $objCharacterModel->getCharacterByPlayerId($_SESSION['user']['character']['id'])[0];
$objCharacter = new Character(['experience' => $arrPlayer['experience']], []);
$numOldLevel = $objCharacter->getExpLevelSystem()['level'];
$objCharacter = new Character(['experience' => $arrPlayer['experience'] + $arrQuest[0]['experience']], []);
$numNewLevel = $objCharacter->getExpLevelSystem()['level'];
$arrLevelUp = ['old' => $numOldLevel, 'new' => $numNewLevel];

// Add Quest Log Entry
$objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'quest_count_prio_' . getPriority($arrQuest[0]['priority']), 1);

// Add Experience to Character
$objCharacterModel->addExperience($_SESSION['user']['character']['id'], $arrQuest[0]['experience']);
$objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'gained_exp', $arrQuest[0]['experience']);

// Add Items to Character
$arrItems = json_decode(base64_decode($arrQuest[0]['base64_items']), true);
$objItemModel = new ItemModel();
foreach($arrItems as $arrItem) {
  $objItemModel->addItemToPlayer($_SESSION['user']['character']['id'], $arrItem);
  $objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'item_count_prio_' . $arrItem['rarity'], 1);
}

// Send Response
echo json_encode(['status' => true, 'items' => $arrItems, 'experience' => $arrQuest[0]['experience'], 'level_up' => $arrLevelUp]);
exit;


function getPriority($strPriority)
{
  $arrPrio = ['Low' => 0, 'Medium' => 1, 'High' => 2, 'Superior' => 3];
  return $arrPrio[$strPriority];
}
