<?php

class ItemModel extends BaseModel
{
  /**
  * INSERT STATEMENT
  * Fügt einem Spieler ein Neues Item hinzu.
  */
  public function addItemToPlayer($numPlayerId, $arrItem)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO player_item
               (name, player_id, is_equiped, rarity, type, image_key, fix_health, fix_attack, fix_defence, fix_agility, fix_luck, factor_health, factor_attack, factor_defence, factor_agility, factor_luck)
               VALUES
               (:name, :player_id, :is_equiped, :rarity, :type, :image_key, :fix_health, :fix_attack, :fix_defence, :fix_agility, :fix_luck, :factor_health, :factor_attack, :factor_defence, :factor_agility, :factor_luck);';

    // Set SQL field values
    $arrFields = [
      'name' => $arrItem['name'],
      'player_id' => $numPlayerId,
      'is_equiped' => false,
      'rarity' => $arrItem['rarity'],
      'type' => $arrItem['type'],
      'image_key' => $arrItem['image_key'],
      'fix_health' => $arrItem['stats']['health'],
      'fix_attack' => $arrItem['stats']['attack'],
      'fix_defence' => $arrItem['stats']['defence'],
      'fix_agility' => $arrItem['stats']['agility'],
      'fix_luck' => 0, //$arrItem['stats']['luck'], // TODO: Luck existier nicht dafür SPEED ?!!!
      'factor_health' => $arrItem['stats_factor']['health'],
      'factor_attack' => $arrItem['stats_factor']['attack'],
      'factor_defence' => $arrItem['stats_factor']['defence'],
      'factor_agility' => $arrItem['stats_factor']['agility'],
      'factor_luck' => 0, //$arrItem['stats_factor']['luck'] // TODO: Luck existier nicht
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  /**
  * SELECT STATMENT
  * Laden eines Items nach Item Id
  */
  public function loadItemByItemId($numItemId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player_item
               WHERE id = :item_id;';

    // Set SQL field values
    $arrFields = [
      'item_id' => $numItemId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    return $arrData[0];
  }

  /**
  * SELECT STATEMENT
  * Ermitteln aller Player Items eines bestimmten Typen.
  * und gibt diese zurück.
  */
  public function loadItemsByType($numPlayerId, $mixType)
  {
    // Build Type
    if(is_array($mixType)) {
      $strType = '"' . implode('","',$mixType) . '"';
    } else {
      $strType = '"' . $mixType . '"';
    }

    // Set SQL statement
    $strSql = 'SELECT * FROM player_item
               WHERE player_id = :player_id
               AND type IN (' . $strType . ')
               ORDER BY rarity DESC;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    return $arrData;
  }

  public function getEquipedItems($numPlayerId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM player_item
               WHERE player_id = :player_id
               AND is_equiped = true;';

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
  * UPDATE STATEMENT
  * Setzt alle Items des selben Types auf unequiped
  */
  public function unequipItemByType($numPlayerId, $mixType)
  {
    // Build Type
    if(is_array($mixType)) {
      $strType = '"' . implode('","',$mixType) . '"';
    } else {
      $strType = '"' . $mixType . '"';
    }

    // Set SQL statement
    $strSql = 'UPDATE player_item
               SET is_equiped = false
               WHERE player_id = :player_id
               AND type IN (' . $strType . ');';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }

  /**
  * UPDATE STATEMENT
  * Setzt das Item mit der angegebenen item_id auf Equiped.
  */
  public function equipItemById($numPlayerId, $numItemId)
  {
    // Set SQL statement
    $strSql = 'UPDATE player_item
               SET is_equiped = true
               WHERE player_id = :player_id
               AND id = :id;';

    // Set SQL field values
    $arrFields = [
      'player_id' => $numPlayerId,
      'id' => $numItemId,
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
  }
}
