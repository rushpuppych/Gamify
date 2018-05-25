
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.CharacterModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Validate name minimum size
if(strlen($_POST['name']) < 3) {
  echo json_encode(['status' => false, 'field' => 'character_name', 'message' => 'Name to shoort. Minimal size 16 characters.']);
  exit;
}

// Validate name maximum size
if(strlen($_POST['name']) > 16) {
  echo json_encode(['status' => false, 'field' => 'character_name', 'message' => 'Name to long. Maximal size 16 characters.']);
  exit;
}

// Save Character
$objCharacterModel = new CharacterModel();
$objCharacterModel->saveCharacter($_POST['name'], $_POST['body_key'], $_POST['face_key'], $_POST['hair_key']);

// Send Response
echo json_encode(['status' => true]);
exit;
