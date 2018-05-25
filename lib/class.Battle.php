<?php

class Battle
{
    public function fight(Character $objCharA, Character $objCharB)
    {
      // Turn Based Fight
      $numTurn = 0;
      $boolEndBattle = false;
      $arrCharacters = [
        'A' => ['obj' => $objCharA, 'health' => $this->getCharEquipStats($objCharA, 'health')],
        'B' => ['obj' => $objCharB, 'health' => $this->getCharEquipStats($objCharB, 'health')]
      ];

      // Generate Fight Story
      $arrAttackStory = [];
      do {
        // Get Turn Actions
        $numTurn++;
        $arrSequence = $this->calculateSequence($objCharA, $objCharB, $numTurn);

        // Set Attacker and Defender
        $objAttacker = $arrCharacters[$arrSequence['attacker']]['obj'];
        $objDefender = $arrCharacters[$arrSequence['defender']]['obj'];

        // Execute Attack
        $arrAttack = $this->calculateAttack($objCharA, $objCharB, $numTurn);
        $arrCharacters[$arrSequence['defender']]['health'] -= $arrAttack['damage'];

        // Write Attack Story
        $arrAttack['attacker'] = $arrSequence['attacker'];
        $arrAttack['attacker_health'] = $arrCharacters[$arrSequence['attacker']]['health'];
        $arrAttack['defender'] = $arrSequence['defender'];
        $arrAttack['defender_health'] = $arrCharacters[$arrSequence['defender']]['health'];
        $arrAttack['text'] = $this->generateFightText($arrAttack);
        $arrAttackStory[] = $arrAttack;

        // End Fight when one character dies
        if($arrCharacters[$arrSequence['defender']]['health'] <= 0) {
          $boolEndBattle = true;
        }
      } while(!$boolEndBattle);

      return $arrAttackStory;
    }

    private function calculateSequence($objCharA, $objCharB, $numTurn)
    {
      // Get Character Speeds
      $arrCharA = $objCharA->getStats();
      $arrCharB = $objCharB->getStats();
      $numSpeedA = $this->getCharEquipStats($objCharA, 'agility') + 1;
      $numSpeedB = $this->getCharEquipStats($objCharA, 'agility') + 1;

      $arrSequence = [];
      for($numCount = 1; $numCount <= $numTurn; $numCount++) {
          // Player A
          $numKey = (floatval($numCount * $numSpeedB) + 0.0) * 10;
          $arrSequence[$numKey] = 'A';

          // Player B
          $numKey = (floatval($numCount * $numSpeedA) + 0.1) * 10;
          $arrSequence[$numKey] = 'B';
      }
      ksort($arrSequence);

      $numCount = 1;
      foreach($arrSequence as $strPlayer) {
          if($numCount == $numTurn) {
              if($strPlayer == 'A') {
                return ['attacker' => 'A', 'defender' => 'B'];
              }
              if($strPlayer == 'B') {
                return ['attacker' => 'B', 'defender' => 'A'];
              }
          }
          $numCount++;
      }
    }

    private function calculateAttack($objCharAtt, $objCharDef, $numTurn)
    {
      $numAttack = $this->getCharEquipStats($objCharAtt, 'attack');
      $numDefence = $this->getCharEquipStats($objCharDef, 'defence');
      $numAttack += $objCharAtt->getStats()['attack'];
      $numDefence += $objCharDef->getStats()['defence'];

      // Calculate Damange
      $numTotal = ($numAttack + $numDefence);
      $numDefencePercent = round(100 / $numTotal * $numDefence);
      $numDamage = $numAttack;
      if($numDefencePercent > 0) {
        $numDamage = round($numAttack / 100 * $numDefencePercent);
      }

      // Min Damage of 1
      if($numDamage == 0) {
        $numDamage = 1;
      }

      // Calculate Block and Critt Change
      $boolCritt = false;
      $boolBlock = false;
      $numCritt = $this->getCharEquipStats($objCharAtt, 'luck');
      $numBlock = $this->getCharEquipStats($objCharDef, 'luck');
      $numTotal = ($numBlock + $numCritt) * 2;

      if($numCritt > rand(0, $numTotal)) {
        $boolCritt = true;
        $numDamage = $numDamage * 2;
      }
      if($numBlock > rand(0, $numTotal)) {
        //$boolBlock = true;
        //$numDamage = 0;
      }

      $arrAttack = ['defence' => $numDefence, 'damage' => $numDamage, 'block' => $boolBlock, 'critt' => $boolCritt];
      return $arrAttack;
    }

    private function getCharEquipStats($objChar, $strStat)
    {
      // Get Attack Character Informations
      $arrCharStats = $objChar->getStats();
      $arrCharEquip = $objChar->getEquip();

      // Calculate Attack
      $numStatFactor = 1;
      $numStatPower = $arrCharStats[$strStat];
      foreach($arrCharEquip as $arrItem) {
        $numStatPower += $arrItem['stats_fix'][$strStat];
        $numStatFactor += $arrItem['stats_factor'][$strStat];
      }
      if($numStatFactor > 0) {
        $numStatPower = $numStatPower * $numStatFactor;
      }

      return $numStatPower;
    }

    private function generateFightText($arrAttack)
    {
      $strStoryText = '';
      // todo: Generate Story Text from Vorlage :-)
      return $strStoryText;
    }
}
