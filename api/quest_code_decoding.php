<?php

SESSION_START();

use Zxing\QrReader;

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.QuestModel.php";
require "../vendor/autoload.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Decode Base64 Image
$objImageResource = imagecreatefromstring(base64_decode($_POST['data']));
$objQrReader = new QrReader($objImageResource, QrReader::SOURCE_TYPE_RESOURCE);
$strQrResult = $objQrReader->text();

$arrQrCode = json_decode($strQrResult, true);
if(!is_array($arrQrCode)) {
  echo json_encode(['status' => false, 'msg' => 'QR Code not Readable.']);
  exit;
}

// Check QR Code Security
if(md5($arrQrCode['id'] . getConfig('security')['salt']) != $arrQrCode['hash']) {
  echo json_encode(['status' => false, 'msg' => "Don't Try do Hack this thing ;-)"]);
  exit;
}

// If QR Code is Quest Delegation
if($arrQrCode['type'] == 'quest') {
  $objQuestModel = new QuestModel();
  $arrQuest = $objQuestModel->loadQuestById($arrQrCode['id']);
  $objQuestModel->delegateQuest($arrQrCode['id'], $_SESSION['user']['character']['id']);
}

// Send Response
echo json_encode(['status' => true]);
exit;
