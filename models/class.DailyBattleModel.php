<?php

class DailyBattleModel extends BaseModel
{
  /**
  * SELECT STATEMENT
  * Liest das heutige Battle aus.
  */
  public function getBattleToday($strDate, $strFraction)
  {
    // Set SQL statement
    $strSql = 'SELECT *
               FROM daily_battle
               WHERE `date` = :today
               AND fraction = :fraction;';

    // Set SQL field values
    $arrFields = [
      'today' => $strDate,
      'fraction' => $strFraction
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    $arrResult = [];
    foreach($arrData as $arrRecord) {
      $arrRecord['battle_data_json'] = json_decode($arrRecord['battle_data_json'], true);
      $arrResult[] = $arrRecord;
    }
    return $arrResult;
  }

  /**
  * INSERT STATEMENT
  * Erstellt ein neues Battle für den heutigen Tag.
  */
  public function createBattleToday($strDate, $strFraction, $arrBattlePlan)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO daily_battle
               (`date`, fraction, battle_data_json)
               VALUES
               (:today, :fraction, :battle_data_json);';

    // Set SQL field values
    $arrFields = [
      'today' => $strDate,
      'fraction' => $strFraction,
      'battle_data_json' => json_encode($arrBattlePlan)
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }
}
