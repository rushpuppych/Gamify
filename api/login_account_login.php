
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.AccountModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ActivityLogModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Account Login
$objAccountModel = new AccountModel();
if(!$objAccountModel->checkEmail($_POST['email'])) {
  echo json_encode(['status' => false, 'field' => 'login_email', 'message' => 'Wrong email. Please try again.']);
  exit;
}
$arrAccount = $objAccountModel->getAccountByCredentials($_POST['email'], md5($_POST['password']));
if(empty($arrAccount)) {
  echo json_encode(['status' => false, 'field' => 'login_password', 'message' => 'Wrong password. Please try again.']);
  exit;
}

// Create Account Session
$_SESSION['user']['id'] = $arrAccount[0]['id'];
$_SESSION['user']['email'] = $arrAccount[0]['email'];
$_SESSION['user']['fraction'] = $arrAccount[0]['fraction'];

// Load Character
$objCharacterModel = new CharacterModel();
$arrCharacter = $objCharacterModel->getCharacterByAccountId($arrAccount[0]['id']);

// Create Character Session
$boolFirstLogin = true;
$_SESSION['user']['character'] = [];
if(!empty($arrCharacter)) {
  $boolFirstLogin = false;
  $_SESSION['user']['character'] = $arrCharacter[0];

  // Insert Log Entry
  $objActivityLogModel = new ActivityLogModel();
  $objActivityLogModel->addLogEntry($arrCharacter[0]['id'], 'login_count', 1);
}

// Send Response
echo json_encode(['status' => true, 'firstlogin' => $boolFirstLogin]);
exit;
