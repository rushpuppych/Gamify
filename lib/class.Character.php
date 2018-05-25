<?php

class Character
{
  private $arrExpLevelSystem = [];
  private $arrStats = [];
  private $arrEquip = [];

  public function Character($arrCharacterDbRecord, $arrEquipment)
  {
    // Set Equipment
    $this->initEquipment();
    $this->setEquipment($arrEquipment);

    // Set ExpLevelSystem
    $this->calculateLevel($arrCharacterDbRecord['experience']);
    $this->calculateStats();
  }

  public function getExpLevelSystem()
  {
    return $this->arrExpLevelSystem;
  }

  public function getStats()
  {
    return $this->arrStats;
  }

  public function getEquip()
  {
    return $this->arrEquip;
  }

  private function calculateLevel($numExp)
  {
    // Level Calculations
    $numExpFirstLevel = 100; // The exp needed for the first level.
    $numLevelFactor = 1.9;   // The higher this value the easier to gain level
    $numLevel = intval(sqrt($numExp / $numExpFirstLevel) * $numLevelFactor);
    $numNextLevelExp = $this->getExpByLevel($numLevel + 1, $numLevelFactor, $numExpFirstLevel);
    $numLastLevelExp = $this->getExpByLevel($numLevel, $numLevelFactor, $numExpFirstLevel);
    $numNextLevelProgress = round(100 / ($numNextLevelExp - $numLastLevelExp) * ($numExp - $numLastLevelExp), 2);
    //$numNextLevelExp = intval(pow(($numLevel) / $numLevelFactor, 2) * $numExpFirstLevel);

    if($numNextLevelProgress == 100) {
      $numNextLevelProgress = 0;
      $numNextLevelExp = $this->getExpByLevel($numLevel + 2, $numLevelFactor, $numExpFirstLevel);
      $numLevel++;
    }

    // Set ExpLevelSystem
    $this->arrExpLevelSystem = [
      'exp' => $numExp,
      'level' => $numLevel,
      'next_level_exp' => $numNextLevelExp,
      'next_level_progress' => $numNextLevelProgress // <- in %
    ];
  }

  private function getExpByLevel($numLevel, $numLevelFactor, $numExpFirstLevel)
  {
    return intval(pow(($numLevel) / $numLevelFactor, 2) * $numExpFirstLevel);
  }

  private function calculateStats()
  {
    // Set Stats Factors
    $arrFactors = [
      "health" => 10,
      "attack" => 0.4,
      "defence" => 0.1,
      "agility" => 0.2,
      "luck" => 0.5
    ];

    // Calculate Stats
    $numCharacterLevel = $this->arrExpLevelSystem['level'];
    $arrStats = [
      "health" => $numCharacterLevel + round($numCharacterLevel * $arrFactors['health']),
      "attack" => $numCharacterLevel + round($numCharacterLevel * $arrFactors['attack']),
      "defence" => $numCharacterLevel + round($numCharacterLevel * $arrFactors['defence']),
      "agility" => $numCharacterLevel + round($numCharacterLevel * $arrFactors['agility']),
      "luck" => $numCharacterLevel + round($numCharacterLevel * $arrFactors['luck'])
    ];
    $this->arrStats = $arrStats;
  }

  private function initEquipment()
  {
    $arrEquip = [
      "key" => '',
      "name" => '',
      "description" => '',
      "font_color" => '',
      "item_image" => '',
      "stats_fix" => ["health" => 0, "attack" => 0, "defence" => 0, "agility" => 0, "luck" => 0],
      "stats_factor" => ["health" => 0, "attack" => 0, "defence" => 0, "agility" => 0, "luck" => 0]
    ];

    $this->arrEquip['armor'] = $arrEquip;
    $this->arrEquip['helmet'] = $arrEquip;
    $this->arrEquip['weapon'] = $arrEquip;
    $this->arrEquip['weapon'] = $arrEquip;
    $this->arrEquip['weapon'] = $arrEquip;
    $this->arrEquip['shield'] = $arrEquip;
    $this->arrEquip['specialfront'] = $arrEquip;
    $this->arrEquip['specialback'] = $arrEquip;
  }

  private function setEquipment($arrEquipment)
  {
    foreach($arrEquipment as $arrRecord) {
      $arrEquip = [
        "key" => $arrRecord['id'],
        "name" => $arrRecord['name'],
        "description" => "",
        "font_color" => "",
        "item_image" => $arrRecord['image_key'],
        "stats_fix" => ["health" => $arrRecord['fix_health'], "attack" => $arrRecord['fix_attack'], "defence" => $arrRecord['fix_defence'], "agility" => $arrRecord['fix_agility'], "luck" => $arrRecord['fix_luck']],
        "stats_factor" => ["health" => $arrRecord['factor_health'], "attack" => $arrRecord['factor_attack'], "defence" => $arrRecord['factor_defence'], "agility" => $arrRecord['factor_agility'], "luck" => $arrRecord['factor_luck']]
      ];

      switch($arrRecord['type']) {
        case 'armor':
          $this->arrEquip['armor'] = $arrEquip;
          break;
        case 'helmet':
          $this->arrEquip['helmet'] = $arrEquip;
          break;
        case 'bow':
          $this->arrEquip['weapon'] = $arrEquip;
          break;
        case 'sword':
          $this->arrEquip['weapon'] = $arrEquip;
          break;
        case 'axe':
          $this->arrEquip['weapon'] = $arrEquip;
          break;
        case 'shield':
          $this->arrEquip['shield'] = $arrEquip;
          break;
        case 'specialfront':
          $this->arrEquip['specialfront'] = $arrEquip;
          break;
        case 'specialback':
          $this->arrEquip['specialback'] = $arrEquip;
          break;
      }
    }
  }
}
