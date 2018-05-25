
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.AccountModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Validate old Password
$objAccountModel = new AccountModel();
if(!$objAccountModel->checkLogin($_SESSION['user']['email'], md5($_POST['old_password']))) {
  echo json_encode(['status' => false, 'field' => 'password_old', 'message' => 'This is not your password.']);
  exit;
}

// Validate New Password and Re Password
if(strlen($_POST['new_password']) < 6) {
  echo json_encode(['status' => false, 'field' => 'password_new', 'message' => 'Password to short (min. 6 chars)']);
  exit;
}
if($_POST['new_password'] != $_POST['renew_password']) {
  echo json_encode(['status' => false, 'field' => 'password_renew', 'message' => 'Passwords are not the same.']);
  exit;
}

// Change Password
$objAccountModel->resetPasswordByEmail($_SESSION['user']['email'], md5($_POST['new_password']));

// Send Response
echo json_encode(['status' => true]);
exit;
