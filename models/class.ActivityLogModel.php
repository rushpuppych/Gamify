<?php

class ActivityLogModel extends BaseModel
{
  public function addLogEntry($numPlayerId, $strKey, $numValue)
  {
    // Check if Log Entry exists (by date)
    $arrDayLog = $this->getDayLogByPlayerId($numPlayerId);
    if(empty($arrDayLog)) {
      $this->insertLogEnty($numPlayerId, $strKey, $numValue);
    } else {
      $this->updateLogEntry($numPlayerId, $strKey, $numValue);
    }
  }

  public function getDayLogByPlayerId($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM activity_log
               WHERE player_id = :player_id
               AND `date` = :date;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId,
      'date' => date('Y-m-d', time())
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  public function insertLogEnty($numPlayerId, $strKey, $numValue)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO activity_log
               (player_id, `date`, ' . $strKey . ')
               VALUES
               (:player_id, :date, :value);';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId,
      'date' => date('Y-m-d', time()),
      'value' => $numValue
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  public function updateLogEntry($numPlayerId, $strKey, $numValue)
  {
    // Set SQL statement
    $strSql = 'UPDATE activity_log
               SET ' . $strKey . ' = ' . $strKey . ' + ' . $numValue . '
               WHERE player_id = :player_id
               AND `date` = :date;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId,
      'date' => date('Y-m-d', time())
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  public function getAchievementsView($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT *
                 FROM get_achievements
                WHERE player_id = :player_id';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  /**
   * SELECT STATEMENT
   * Selekiert alle gewonnenen Battles nach Player id und Count.
   */
  public function getBattleRanking()
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM activity_log;';

    // Execute SQL
    $this->execute($strSql, []);
    $arrResult = $this->queryAll();

    // Calculate Battle SUM
    $arrData = [];
    foreach($arrResult as $arrRecord) {
      $numPlayerId = $arrRecord['player_id'];
      if(!isset($arrData[$numPlayerId])) {
        $arrData[$numPlayerId] = 0;
      }

      $arrData[$numPlayerId] += floatval($arrRecord['is_battle_0']) * 6;
      $arrData[$numPlayerId] += floatval($arrRecord['is_battle_1']) * 4;
      $arrData[$numPlayerId] += floatval($arrRecord['is_battle_2']) * 2;
      $arrData[$numPlayerId] += floatval($arrRecord['is_battle_4']) * 1;
      $arrData[$numPlayerId] = round($arrData[$numPlayerId]);

      arsort($arrData);
    }
    return $arrData;
  }
}
