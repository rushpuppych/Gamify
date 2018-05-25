
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Load all Resources from Folder
$arrResources = [
  'armor' => getFilesFromFolder('armor'),
  'body' => getFilesFromFolder('body'),
  'face' => getFilesFromFolder('face'),
  'hair' => getFilesFromFolder('hair'),
  'helmet' => getFilesFromFolder('helmet'),
  'shield' => getFilesFromFolder('shield'),
  'specialback' => getFilesFromFolder('specialback'),
  'specialfront' => getFilesFromFolder('specialfront'),
  'sword' => getFilesFromFolder('sword'),
];

// Send Response
echo json_encode(['status' => true, 'resources' => $arrResources]);
exit;


function getFilesFromFolder($strFolder)
{
  $arrImages = [];
  $arrRecord = scandir('../assets/images/character/' . $strFolder . '/');
  foreach($arrRecord as $strKey) {
    if(is_file('../assets/images/character/' . $strFolder . '/' . $strKey)) {
      $strKey = explode('.', $strKey)[0];
      $arrImages[] = $strKey;
    }
  }
  return $arrImages;
}
