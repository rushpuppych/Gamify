
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.ItemModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Set Type
$mixType = $_POST['type'];
$arrWeapons = ['sword', 'bow', 'axe'];
if(in_array($_POST['type'], $arrWeapons)) {
  $mixType = $arrWeapons;
}

// Unequip all Items of type
$objItemModel = new ItemModel();
$objItemModel->unequipItemByType($_SESSION['user']['character']['id'], $mixType);
if ($_POST['is_equiped'] != 1) {
  $objItemModel->equipItemById($_SESSION['user']['character']['id'], $_POST['item_id']);
}

// Send Response
echo json_encode(['status' => true]);
exit;
