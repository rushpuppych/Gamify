
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.HtmlMailSender.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ActivityLogModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Load Delegation Players
$objQuestModel = new QuestModel();
$arrQuest = $objQuestModel->loadQuestById($_POST['quest_id']);
$objQuestModel->delegateQuest($_POST['quest_id'], $_POST['to_player']);

// Neue Player email ermitteln
$objCharacterModel = new CharacterModel();
$strToEmail = $objCharacterModel->getPlayerEmail($_POST['to_player']);

// Create Delegation Log Entry
$objActivityLogModel = new ActivityLogModel();
$objActivityLogModel->addLogEntry($_SESSION['user']['character']['id'], 'quest_count_delegated', 1);

// Send Delegation Notification to new Player
$strEmailBetreff = 'Gamify: You got a new Quest.';

// Gamify Email Body
$arrConfig = getConfig('page');
$strBody  = '<b>You got a new Quest:</b><br><br><hr>';
$strBody .= '<b>' . $arrQuest[0]['title'] . '</b><br>';
$strBody .= $arrQuest[0]['description'] . '<hr><br>';
$strBody .= 'Your sincerely:<br><br>';
$strBody .= '<b>' . $arrConfig['impressum_name'] . '</b><br>';
$strBody .= $arrConfig['impressum_street'] . '<br>';
$strBody .= $arrConfig['impressum_place'] . '<br>';

// NEUER HTML Mail Generator
$arrConfig = getConfig('mail');
if($arrConfig['enable_email_notification']) {
  $objHtmlMailer = new HtmlMailSender();
  $objHtmlMailer->sendEmail($strEmailBetreff, $strBody, $strToEmail);
}

// Send Response
echo json_encode(['status' => true]);
exit;
