<?php

class CharacterModel extends BaseModel
{
  /**
  * SELECT STATEMENT
  * Liest einen Character anhand der AccountId aus der Datebank aus
  * und gibt diesen zurück.
  */
  public function getCharacterByAccountId($numAccountId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player
               WHERE account_id = :account_id;';

    // Set SQL field values
    $arrFields = [
      'account_id' => $numAccountId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  /**
  * SELECT STATEMENT
  * Liest einen Character anhand der AccountId aus der Datebank aus
  * und gibt diesen zurück.
  */
  public function getCharacterByPlayerId($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player
               WHERE id = :player_id;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  public function saveCharacter($strName, $strBodyKey, $strFaceKey, $strHairKey)
  {
    if(count($this->getCharacterByAccountId($_SESSION['user']['id'])) == 0) {
      $this->createCharacter($strName, $strBodyKey, $strFaceKey, $strHairKey);
    } else {
      $this->updateCharacter($strName, $strBodyKey, $strFaceKey, $strHairKey);
    }

    $arrCharacter = $this->getCharacterByAccountId($_SESSION['user']['id']);
    $_SESSION['user']['character'] = $arrCharacter[0];
  }

  public function createCharacter($strName, $strBodyKey, $strFaceKey, $strHairKey)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO player
               (name, body_key, face_key, hair_key, account_id)
               VALUES
               (:name, :body_key, :face_key, :hair_key, :account_id);';

    // Set SQL field values
    $arrFields = [
      'name' => $strName,
      'body_key' => $strBodyKey,
      'face_key' => $strFaceKey,
      'hair_key' => $strHairKey,
      'account_id' => $_SESSION['user']['id']
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  public function updateCharacter($strName, $strBodyKey, $strFaceKey, $strHairKey)
  {
    // Set SQL statement
    $strSql = 'UPDATE player
               SET name = :name,
               body_key = :body_key,
               face_key = :face_key,
               hair_key = :hair_key
               WHERE account_id = :account_id;';

    // Set SQL field values
    $arrFields = [
      'name' => $strName,
      'body_key' => $strBodyKey,
      'face_key' => $strFaceKey,
      'hair_key' => $strHairKey,
      'account_id' => $_SESSION['user']['id']
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  /**
  * SELECT STATEMENT (JOIN)
  * Laden aller Characters und die entsprechende Fraction aus der Account Tabelle
  */
  public function getAllPlayerNames($strFraction = null)
  {
    // Set SQL statement
    $strSql = 'SELECT
                p.id,
                p.name,
                a.fraction
              FROM player as p
              LEFT JOIN account AS a ON p.account_id = a.id ';

    $arrFields = [];
    if(!is_null($strFraction)) {
      $strSql .= 'WHERE a.fraction = :fraction;';
      $arrFields = ['fraction' => $strFraction];
    }

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  /**
  * SELECT STATEMENT (JOIN)
  * liest über character Tabelle die Email auf der Account tabelle aus
  */
  public function getPlayerEmail($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT
                a.email
              FROM player as p
              LEFT JOIN account AS a ON p.account_id = a.id
              WHERE p.id = :player_id;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData[0]['email'];
  }

  public function addExperience($numPlayerId, $numExperience)
  {
    // Set SQL statement
    $strSql = 'UPDATE player
               SET experience = experience + :experience
               WHERE id = :player_id;';

    // Set SQL field values
    $arrFields = [
      'experience' => $numExperience,
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  /**
  * SELECT STATEMENT
  * Liest alle Players aus und ordnet diese nach Exp Absteigend.
  */
  public function getExperienceRanking()
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player
               ORDER BY experience DESC;';

    // Execute SQL
    $this->execute($strSql, []);
    $arrData = $this->queryAll();
    return $arrData;
  }
}
