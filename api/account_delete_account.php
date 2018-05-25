
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
if(!$objAccountModel->checkLogin($_SESSION['user']['email'], md5($_POST['delete_password']))) {
  echo json_encode(['status' => false, 'field' => 'delete_password', 'message' => 'This is not your password.']);
  exit;
}

// Delete Account
// TODO

// Delete Character
// TODO

// Delete Items
// TODO

// Delete Achievements
// TODO

// Send Response
echo json_encode(['status' => true]);
exit;
