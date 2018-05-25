<?php

class QuestModel extends BaseModel
{
  /**
   * SELECT STATEMENT
   * Alle Quests eines Players laden. Diese Quest so sortieren
   * Das Alle Offenen mit der Kleinsten Ablaufzeit zuerst kommen und dann alle abgeschlossenen
   */
  public function loadQuestsByPlayerId($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player_quest
               WHERE player_id = :player_id
               ORDER BY is_finish ASC,
               end_timestamp DESC;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    // Formate Data
    $arrQuests = [];
    foreach($arrData as $arrRecord) {
      if($arrRecord['is_finish']) {
        $numTimeStamp = $arrRecord['finish_timestamp'];
        $arrRecord['timer'] = date('d/m/Y - H:i:s', $numTimeStamp);
      } else {
        $numTimeStamp = $arrRecord['end_timestamp'];
        $arrTime = explode(',', date('j,G,i,s', $numTimeStamp - time()));
        $arrRecord['timer'] = ($arrTime[0] - 1) . 'd ' . ($arrTime[1] - 1) . 'h ' . intval($arrTime[2]) . 'min ' . $arrTime[3] . 's';
      }
      $arrPrio = [0 => 'Low', 1 => 'Medium', 2 => 'High', 3 => 'Superior'];
      $arrRecord['priority'] = $arrPrio[$arrRecord['priority']];

      $arrQuests[] = $arrRecord;
    }

    return $arrQuests;
  }

  public function loadQuestById($numQuestId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player_quest
               WHERE id = :id
               ORDER BY is_finish ASC,
               end_timestamp DESC;';

    // Set SQL field values
    $arrFields = [
      'id' => $numQuestId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    // Formate Data
    $arrQuests = [];
    foreach($arrData as $arrRecord) {
      if($arrRecord['is_finish']) {
        $numTimeStamp = $arrRecord['finish_timestamp'];
        $arrRecord['timer'] = date('d/m/Y - H:i:s', $numTimeStamp);
      } else {
        $numTimeStamp = $arrRecord['end_timestamp'];
        $arrTime = explode(',', date('j,G,i,s', $numTimeStamp - time()));
        $arrRecord['timer'] = ($arrTime[0] - 1) . 'd ' . ($arrTime[1] - 1) . 'h ' . intval($arrTime[2]) . 'min ' . $arrTime[3] . 's';
      }
      $arrPrio = [0 => 'Low', 1 => 'Medium', 2 => 'High', 3 => 'Superior'];
      $arrRecord['priority'] = $arrPrio[$arrRecord['priority']];
      $arrQuests[] = $arrRecord;
    }

    return $arrQuests;
  }

  /**
  * INSERT STATEMENT
  * Erstellt eine neue Quest in der Datenbank
  */
  public function createQuest($strTitle, $numEndTimeStamp, $numPriority, $strDescription, $numExperience, $strBase64Items)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO player_quest
              (player_id, title, priority, description, end_timestamp, experience, base64_items, is_finish, is_canceled)
              VALUES
              (:player_id, :title, :priority, :description, :end_timestamp, :experience, :base64_items, :is_finish, :is_canceled);';

    // Set SQL field values
    $arrFields = [
      'player_id' => $_SESSION['user']['character']['id'],
      'title' => $strTitle,
      'priority' => $numPriority,
      'description' => $strDescription,
      'end_timestamp' => $numEndTimeStamp,
      'experience' => $numExperience,
      'base64_items' => $strBase64Items,
      'is_finish' => false,
      'is_canceled' => false
    ];

    // Execute Insert SQL
    $this->execute($strSql, $arrFields);

    // Return New Quest Code
    $this->execute('SELECT id FROM player_quest ORDER BY id DESC LIMIT 1', []);
    return $this->queryAll()[0]['id'];
  }

  /**
  * UPDATE STATEMENT
  * Quest Abschliessen und am ende die Result Items auslesen und ausgeben
  */
  public function accomplishQuest($numQuestId, $numPlayerId)
  {
    // Check if not allready Finished
    $arrQuest = $this->loadQuestById($numQuestId);
    if($arrQuest[0]['is_finish']) {
      return false;
    }

    // Set SQL statement
    $strSql = 'UPDATE player_quest
               SET is_finish = true,
               is_canceled = false,
               finish_timestamp = :finish_timestamp
               WHERE id = :id
               AND player_id = :player_id;';

    // Set SQL field values
    $arrFields = [
      'finish_timestamp' => time(),
      'id' => $numQuestId,
      'player_id' => $numPlayerId
    ];

    // Execute Update SQL
    $this->execute($strSql, $arrFields);
    $arrQuest = $this->loadQuestById($numQuestId);
    return $arrQuest;
  }

  /**
  * UPDATE STATEMENT
  * Quest Abbrechen.
  */
  public function cancelQuest($numQuestId, $numPlayerId)
  {
    // Check if not allready Finished
    $arrQuest = $this->loadQuestById($numQuestId);
    if($arrQuest[0]['is_finish']) {
      return false;
    }

    // Set SQL statement
    $strSql = 'UPDATE player_quest
               SET is_finish = true,
               is_canceled = true,
               finish_timestamp = :finish_timestamp
               WHERE id = :id
               AND player_id = :player_id;';

    // Set SQL field values
    $arrFields = [
      'finish_timestamp' => time(),
      'id' => $numQuestId,
      'player_id' => $numPlayerId
    ];

    // Execute Update SQL
    $this->execute($strSql, $arrFields);
    $arrQuest = $this->loadQuestById($numQuestId);
    return $arrQuest;
  }

  /**
  * UPDATE STATEMENT
  * Quest Abbrechen.
  */
  public function delegateQuest($numQuestId, $numPlayerId)
  {
    // Set SQL statement
    $strSql = 'UPDATE player_quest
               SET player_id = :player_id
               WHERE id = :id';

    // Set SQL field values
    $arrFields = [
      'id' => $numQuestId,
      'player_id' => $numPlayerId
    ];

    // Execute Update SQL
    $this->execute($strSql, $arrFields);;
  }
}
