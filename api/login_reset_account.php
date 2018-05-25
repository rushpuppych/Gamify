
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.HtmlMailSender.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.AccountModel.php";


// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Validate Email Address
if(strpos($_POST['email'], '@') === false) {
   echo json_encode(['status' => false, 'field' => 'reset_email', 'message' => 'Please enter a valid email.']);
   exit;
}

// Check if there is a account
$objAccountModel = new AccountModel();
if(!$objAccountModel->checkEmail($_POST['email'])) {
  echo json_encode(['status' => false, 'field' => 'reset_email', 'message' => 'This email is not registered. Please signup for a new account.']);
  exit;
}

// Generate new Generic Password
$strPlainPassword = uniqid();
$strNewGenericPassword = md5($strPlainPassword);

// Save new password to database
$objAccountModel->resetPasswordByEmail($_POST['email'], $strNewGenericPassword);

// Send new password via email
$strEmailBetreff = 'Gamify Password Reset Mail.';

// Gamify Email Body
$arrConfig = getConfig('page');
$strBody  = '<b>Your Password has been reseted</b><br><br>';
$strBody .= 'Your new Password is:<br>';
$strBody .= $strPlainPassword . '<br><br>';
$strBody .= 'Please Login and use the Setting menu to set a new Password.<br><br>';
$strBody .= 'Your sincerely:<br><br>';
$strBody .= '<b>' . $arrConfig['impressum_name'] . '</b><br>';
$strBody .= $arrConfig['impressum_street'] . '<br>';
$strBody .= $arrConfig['impressum_place'] . '<br>';

// NEUER HTML Mail Generator
$objHtmlMailer = new HtmlMailSender();
$objHtmlMailer->sendEmail($strEmailBetreff, $strBody, $_POST['email']);

// Send Response
echo json_encode(['status' => true]);
exit;
