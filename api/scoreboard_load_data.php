
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.Character.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.ActivityLogModel.php";
include_once "../models/class.AccountModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.ItemModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Build Experience Ranking
$arrExperienceRanking = [];
$objCharacterModel = new CharacterModel();
$arrResult = $objCharacterModel->getExperienceRanking();
foreach($arrResult as $arrRecord) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($arrRecord['id']);
  $arrTemp['value'] = $arrRecord['experience']. ' Exp';
  $arrExperienceRanking[] = $arrTemp;
}

// Build Battle Ranking
$arrBattleRanking = [];
$objActivityLogModel = new ActivityLogModel();
$arrResult = $objActivityLogModel->getBattleRanking();
foreach($arrResult as $numPlayerId => $numWinns) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($numPlayerId);
  $arrTemp['value'] = $numWinns . ' Points';
  $arrBattleRanking[] = $arrTemp;
}

// Build Weapon Ranking Top 10
$arrWeaponRanking = [];
$objBaseModel = new BaseModel();
$objBaseModel->execute('CALL best_item(:type, 10)', ['type' => 'weapon']);
$arrResult = $objBaseModel->queryAll();
foreach($arrResult as $arrRecord) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($arrRecord['player_id']);
  $arrTemp['value'] = intval($arrRecord['power']);
  $arrTemp['item_info'] = getWeaponInfoById($arrRecord['item_id']);
  $arrWeaponRanking[] = $arrTemp;
}

// Build Armor Ranking Top 10
$arrArmorRanking = [];
$objBaseModel = new BaseModel();
$objBaseModel->execute('CALL best_item(:type, 10)', ['type' => 'armor']);
$arrResult = $objBaseModel->queryAll();
foreach($arrResult as $arrRecord) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($arrRecord['player_id']);
  $arrTemp['value'] = intval($arrRecord['power']);
  $arrTemp['item_info'] = getWeaponInfoById($arrRecord['item_id']);
  $arrArmorRanking[] = $arrTemp;
}

// Build Shield Ranking Top 10
$arrShieldRanking = [];
$objBaseModel = new BaseModel();
$objBaseModel->execute('CALL best_item(:type, 10)', ['type' => 'shield']);
$arrResult = $objBaseModel->queryAll();
foreach($arrResult as $arrRecord) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($arrRecord['player_id']);
  $arrTemp['value'] = intval($arrRecord['power']);
  $arrTemp['item_info'] = getWeaponInfoById($arrRecord['item_id']);
  $arrShieldRanking[] = $arrTemp;
}

// Build Shield Ranking Top 10
$arrSpecialRanking = [];
$objBaseModel = new BaseModel();
$objBaseModel->execute('CALL best_item(:type, 10)', ['type' => 'special']);
$arrResult = $objBaseModel->queryAll();
foreach($arrResult as $arrRecord) {
  $arrTemp = [];
  $arrTemp['player'] = getPlayerInfoById($arrRecord['player_id']);
  $arrTemp['value'] = intval($arrRecord['power']);
  $arrTemp['item_info'] = getWeaponInfoById($arrRecord['item_id']);
  $arrSpecialRanking[] = $arrTemp;
}

// Send Response
echo json_encode([
  'status' => true,
  'experience_ranking' => $arrExperienceRanking,
  'battle_ranking' => $arrBattleRanking,
  'weapon_ranking' => $arrWeaponRanking,
  'armor_ranking' => $arrArmorRanking,
  'shield_ranking' => $arrShieldRanking,
  'special_ranking' => $arrSpecialRanking
]);
exit;

function getWeaponInfoById($numItemId)
{
  // Get Item from Database
  $objItemModel = new ItemModel();
  $arrResult = $objItemModel->loadItemByItemId($numItemId);

  // Switch Item color
  switch($arrResult['rarity']) {
    case 0:
      $strRarity = 'Poor';
      break;
    case 1:
      $strRarity = 'Common';
      break;
    case 2:
      $strRarity = 'Uncommon';
      break;
    case 3:
      $strRarity = 'Epic';
      break;
    case 4:
      $strRarity = 'Legendary';
      break;
    case 5:
      $strRarity = 'Divine';
      break;
  }

  // Build Item Array
  $arrItem = [];
  $arrItem['name'] = $arrResult['name'];
  $arrItem['rarity'] = $strRarity;
  $arrItem['imagekey'] = $arrResult['image_key'];
  $arrItem['type'] = $arrResult['type'];
  return $arrItem;
};


function getPlayerInfoById($numPlayerId)
{
  // Set Character
  $objCharacterModel = new CharacterModel();
  $arrCharacter = $objCharacterModel->getCharacterByPlayerId($numPlayerId)[0];

  // Load Account Information
  $objAccountModel = new AccountModel();
  $arrAccount = $objAccountModel->getAccountByAccountId($arrCharacter['account_id']);

  // Get Character Informations
  $objCharacter = new Character($arrCharacter, []);
  $arrExpLevelSystem = $objCharacter->getExpLevelSystem();

  // Build Player Object
  $arrPlayer = [];
  $arrPlayer['player_id'] = $arrCharacter['id'];
  $arrPlayer['name'] = $arrCharacter['name'];
  $arrPlayer['exp'] = $arrCharacter['experience'];
  $arrPlayer['level'] = $arrExpLevelSystem['level'];
  $arrPlayer['fraction'] = $arrAccount['fraction'];
  return $arrPlayer;
};
