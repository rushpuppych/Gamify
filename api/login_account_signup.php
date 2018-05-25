
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.AccountModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Validate Email Address
if(strpos($_POST['email'], '@') === false) {
   echo json_encode(['status' => false, 'field' => 'signup_email', 'message' => 'Please enter a valid email.']);
   exit;
}

// Validate Password
if(strlen($_POST['password']) < 6) {
  echo json_encode(['status' => false, 'field' => 'signup_password', 'message' => 'Password to short (min. 6 chars)']);
  exit;
}
if($_POST['password'] != $_POST['repassword']) {
  echo json_encode(['status' => false, 'field' => 'signup_repassword', 'message' => 'Passwords are not the same.']);
  exit;
}

// Check if this account allready exists
$objAccountModel = new AccountModel();
if($objAccountModel->checkEmail($_POST['email'])) {
  echo json_encode(['status' => false, 'field' => 'signup_email', 'message' => 'This email is already registered. Please Login.']);
  exit;
}

// Insert new Account
$objAccountModel->createAccount($_POST['email'], md5($_POST['password']), $_POST['fraction']);

// Send Response
echo json_encode(['status' => true]);
exit;
