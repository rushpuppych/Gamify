
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.ItemModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Get Correct Type
$mixType = $_POST['type'];
if($mixType == 'weapon') {
  $mixType = ['sword', 'bow', 'axe'];
}
if($mixType == 'special') {
  $mixType = ['specialfront', 'specialback'];
}

// Get All Items from a Character
$objItemModel = new ItemModel();
$arrItems = $objItemModel->loadItemsByType($_SESSION['user']['character']['id'] , $mixType);

// Send Response
echo json_encode(['status' => true, 'items' => $arrItems]);
exit;
