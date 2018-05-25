<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../lib/class.Battle.php";
include_once "../lib/class.Character.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.CharacterModel.php";
include_once "../models/class.DailyBattleModel.php";
include_once "../models/class.ItemModel.php";
include_once "../models/class.ActivityLogModel.php";

// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Get All
$objCharacterModel = new CharacterModel();
$arrPlayers = $objCharacterModel->getAllPlayerNames($_SESSION['user']['fraction']);

// Generate Battle Positions
$arrPositions = [];
for($numIndex = 0; $numIndex < 16; $numIndex++) {
  if(isset($arrPlayers[$numIndex])) {
    $arrPositions[$numIndex] = $arrPlayers[$numIndex];
  } else {
    $arrPositions[$numIndex] = [];
  }
}
shuffle($arrPositions);

// Generate Battle
$arrBattle = [];
for($numRound = 0; $numRound < 19; $numRound++) {
  $arrRound = [];

  // Second Round
  if($numRound == 3) {
    // 8 Battles
    $arrRound[] = getBattle($arrPositions[0], $arrPositions[1], $numRound);
    $arrRound[] = getBattle($arrPositions[2], $arrPositions[3], $numRound);
    $arrRound[] = getBattle($arrPositions[4], $arrPositions[5], $numRound);
    $arrRound[] = getBattle($arrPositions[6], $arrPositions[7], $numRound);
    $arrRound[] = getBattle($arrPositions[8], $arrPositions[9], $numRound);
    $arrRound[] = getBattle($arrPositions[10], $arrPositions[11], $numRound);
    $arrRound[] = getBattle($arrPositions[12], $arrPositions[13], $numRound);
    $arrRound[] = getBattle($arrPositions[14], $arrPositions[15], $numRound);
  }

  // Quater Finals
  if($numRound == 7) {
    $arrRound[] = getBattle($arrBattle[3][0]['winner'], $arrBattle[3][1]['winner'], $numRound);
    $arrRound[] = getBattle($arrBattle[3][2]['winner'], $arrBattle[3][3]['winner'], $numRound);
    $arrRound[] = getBattle($arrBattle[3][4]['winner'], $arrBattle[3][5]['winner'], $numRound);
    $arrRound[] = getBattle($arrBattle[3][6]['winner'], $arrBattle[3][7]['winner'], $numRound);
  }

  // Semifinal
  if($numRound == 14) {
    $arrRound[] = getBattle($arrBattle[7][0]['winner'], $arrBattle[7][1]['winner'], $numRound);
    $arrRound[] = getBattle($arrBattle[7][2]['winner'], $arrBattle[7][3]['winner'], $numRound);
  }

  // Final
  if($numRound == 16) {
    $arrRound[] = getBattle($arrBattle[14][0]['winner'], $arrBattle[14][1]['winner'], $numRound);
  }
  $arrBattle[$numRound] = $arrRound;
}

// Build Daily Battle Story
$arrAllBattle = [];
foreach($arrBattle as $numRound => $arrBattleList) {
  foreach($arrBattleList as $arrBattle) {
    if(!empty($arrBattle)) {
      if(!empty($arrBattle['looser'])) {
        $numPlayerId = $arrBattle['looser']['id'];
        $arrAllBattle[$numPlayerId] = $arrBattle;
      }
    }
  }
}

// Generate Rounds
$arrDailyBattleRounds = [];
for($numRound = 0; $numRound < 19; $numRound++) {
  $arrDailyBattleRounds[$numRound] = [];

  foreach($arrPositions as $numPosition => $arrPlayer) {
    if(!empty($arrPlayer)) {
      // If Player is still alive
      $arrPlayer['round'] = $numRound;
      $arrPlayer['position'] = $numPosition;
      $arrPlayer['battle'] = [];
      $arrPlayer['is_killed'] = 0;

      // If Player was killed
      $numPlayerId = $arrPlayer['id'];
      if(isset($arrAllBattle[$numPlayerId])) {
        if($numRound >= $arrAllBattle[$numPlayerId]['round']) {
          $arrPlayer['battle'] = $arrAllBattle[$numPlayerId];
          $arrPlayer['round'] = $arrAllBattle[$numPlayerId]['round'];
          $arrPlayer['is_killed'] = 1;
        }
      }
      $arrDailyBattleRounds[$numRound][] = $arrPlayer;
    }
  }
}

// Get Actual Round
$arrConfig = getConfig('game');
$numFrom = getTimeNumeric($arrConfig['battle_time_from']);
$numTo = getTimeNumeric($arrConfig['battle_time_to']);
$numTotal = $numTo - $numFrom;
$numRoundTime = $numTotal / 19;
$numTimeStampStart = strtotime(date('Y-m-d ') . $arrConfig['battle_time_from'] . ':00');

$numNow = time();
$numRound = 0;
for($numIndex = 1; $numIndex <= 19; $numIndex++) {
  $numTime = intval($numTimeStampStart + ($numRoundTime * $numIndex));
  if($numNow > $numTime) {
    $numRound = $numIndex - 1;
  }
}

// Calculate Battle Days
$numDayNumber = date('w');
$strDays = substr($arrConfig['battle_days'], 6, 1) . substr($arrConfig['battle_days'], 0, 6);
if(substr($strDays, $numDayNumber, 1) == '-') {
  echo json_encode(['status' => true, 'battle' => [], 'is_battle' => false]);
  exit;
}

// Load Daily Battle From Cache
$objDailyBattleModel = new DailyBattleModel();
$arrBattle = $objDailyBattleModel->getBattleToday(date('Y-m-d'), $_SESSION['user']['fraction']);
if(empty($arrBattle)) {
  // Create Cache Entry
  $objDailyBattleModel->createBattleToday(date('Y-m-d'), $_SESSION['user']['fraction'], $arrDailyBattleRounds);

  // Create Daily Battle Logs
  $objActivityLogModel = new ActivityLogModel();
  $arrLogEntrys = getBattleLogEntrys($arrDailyBattleRounds);
  foreach($arrLogEntrys as $numPlayerId => $numRanking) {
    $objActivityLogModel->addLogEntry($numPlayerId, 'is_battle_' . $numRanking, 1);
  }

} else {
  $arrDailyBattleRounds = $arrBattle[0]['battle_data_json'];
}

// Get Actual Battle Round
$arrReturn = $arrDailyBattleRounds[$numRound];

// Send Response
echo json_encode(['status' => true, 'battle' => $arrReturn, 'is_battle' => true]);
exit;

/**
* Get Battle Log Entrys
*/
function getBattleLogEntrys($arrDailyBattleRounds)
{
  $arrPlayerInfo = [];
  foreach($arrDailyBattleRounds as $arrRound) {
    foreach($arrRound as $arrPlayer) {
      // Get Player Info
      $numPlayerId = $arrPlayer['id'];
      $numRound = $arrPlayer['round'];

      // Get The Player Killed at round Infos
      if($arrPlayer['is_killed'] > 0) {
        $arrRankings = [16 => '1', 14 => '2', 7 => '4', 3 => '8'];
        $arrPlayerInfo[$numPlayerId] = $arrRankings[$numRound];
      }

      // Get The Winner
      if($arrPlayer['is_killed'] == 0 && !isset($arrPlayerInfo[$numPlayerId])) {
        $arrPlayerInfo[$numPlayerId] = 0;
      }
    }
  }
  return $arrPlayerInfo;
}

/**
* Calculate a Battle
*/
function getBattle($arrPlayerA, $arrPlayerB, $numRound)
{
  // Battle Header
  $arrBattle = [];
  $arrBattle['log'] = '';
  $arrBattle['round'] = $numRound;

  // Decide if Battle or Not
  $objCharacterModel = new CharacterModel();
  $objItemModel = new ItemModel();
  if(!empty($arrPlayerA) && !empty($arrPlayerB)) {
    // Get Character Info
    $arrPlayerA = $objCharacterModel->getCharacterByPlayerId($arrPlayerA['id'])[0];
    $arrPlayerB = $objCharacterModel->getCharacterByPlayerId($arrPlayerB['id'])[0];
    $arrPlayerEquipA = $objItemModel->getEquipedItems($arrPlayerA['id']);
    $arrPlayerEquipB = $objItemModel->getEquipedItems($arrPlayerB['id']);

    // Create Player Object
    $objPlayerA = new Character($arrPlayerA, $arrPlayerEquipA);
    $objPlayerB = new Character($arrPlayerB, $arrPlayerEquipB);

    // Calculate Battle
    $objBattle = new Battle();
    $arrFightStory = $objBattle->fight($objPlayerA, $objPlayerB);

    // Get Winner
    $numFightCount = count($arrFightStory) - 1;
    if($arrFightStory[$numFightCount]['attacker'] == 'A') {
      $arrBattle['winner'] = $arrPlayerA;
      $arrBattle['looser'] = $arrPlayerB;
    } else {
      $arrBattle['winner'] = $arrPlayerB;
      $arrBattle['looser'] = $arrPlayerA;
    }

    // Set Fight Story
    $arrBattle['log'] = $arrFightStory;
  } else {
    // No Battle Player Winns
    if(!empty($arrPlayerA)) {
      $arrBattle['winner'] = $objCharacterModel->getCharacterByPlayerId($arrPlayerA['id'])[0];
      $arrBattle['looser'] = [];
    } else if(!empty($arrPlayerB)) {
      $arrBattle['winner'] = $objCharacterModel->getCharacterByPlayerId($arrPlayerB['id'])[0];
      $arrBattle['looser'] = [];
    } else {
      $arrBattle['winner'] = [];
      $arrBattle['looser'] = [];
    }
  }

  return $arrBattle;
}

function getTimeNumeric($strTime)
{
  $arrTime = explode(':', $strTime);
  $numTime = (intval($arrTime[0]) * 60 * 60) + (intval($arrTime[1]) * 60);
  return $numTime;
}
