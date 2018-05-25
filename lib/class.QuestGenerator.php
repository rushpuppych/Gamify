<?php

class QuestGenerator
{
    private $arrDefaultOptions = [];
    private $arrPriority = [];

    public function QuestGenerator()
    {
        $this->arrPriority = [
            0 => 'Low',
            1 => 'Medium',
            2 => 'High',
            3 => 'Superior'
        ];

        $this->arrDefaultOptions = [
            'exp' => 100,
            'prio' => 0,
            'prio_factor' => 0.5,
            'item_slot_change' => 0.25
        ];
    }

    public function getQuestHtmlBtn($strTitle, $arrOption = [])
    {
        $arrQuest = $this->generateQuest($strTitle, $arrOption);
        $strBase64 = $this->getBase64Info($arrQuest);
        $strHtml = $this->getHtmlTemplate($arrQuest, $strBase64);
        return $strHtml;
    }

    public function getQuestArray($strTitle, $arrOption = [])
    {
        $arrQuest = $this->generateQuest($strTitle, $arrOption);
        return $arrQuest;
    }

    private function generateQuest($strTitle, $arrOption)
    {
        // Experience Berechnen
        $numExp = $this->getValue($arrOption, 'exp', $this->arrDefaultOptions['exp']);
        $numPrio = $this->getValue($arrOption, 'prio', $this->arrDefaultOptions['prio']);
        $numPrioFactor = $this->getValue($arrOption, 'prio_factor', $this->arrDefaultOptions['prio_factor']);
        if($numPrio > 0) {
            $numExp += $numExp * ($numPrio * $numPrioFactor);
        }

        // Calculate Items
        $arrItems = [];
        $numSlotChange = $this->getValue($arrOption, 'item_slot_change', $this->arrDefaultOptions['item_slot_change']);
        if($numPrio > 0) {
            $numSlotChange +=  (($numPrioFactor * $numPrio) / 2);
        }
        if(rand(1, 100) <= 100 * $numSlotChange) {
            $arrItems[] = $this->addItem();
        }
        if(rand(1, 100) <= 100 * $numSlotChange) {
            $arrItems[] = $this->addItem();
        }
        if(rand(1, 100) <= 100 * $numSlotChange) {
            $arrItems[] = $this->addItem();
        }

        // Generate Quest
        $arrQuest = [
            'title' => $strTitle,
            'exp' => $numExp,
            'prio' => $numPrio,
            'items' => $arrItems
        ];
        return $arrQuest;
    }

    private function addItem()
    {
        $numRarity = $this->getRarity();
        $objItem = new ItemNameGenerator();
        $arrGeneratedItem = $objItem->getRandomItemName($numRarity);
        $arrStats = $this->getStatsFromRarity($numRarity, $arrGeneratedItem['type']);

        // Special Items
        $strType = $arrGeneratedItem['type'];
        if($strType == 'special') {
          $arrSpecial = ['specialback', 'specialfront'];
          $strType = $arrSpecial[rand(0,1)];
        }

        $arrItem = [];
        $arrItem['name'] = $arrGeneratedItem['name'];
        $arrItem['type'] = $strType;
        $arrItem['image_key'] = $this->getItemImage($strType, $numRarity);
        $arrItem['rarity'] = $numRarity;
        $arrItem['stats'] = $arrStats['stats'];
        $arrItem['stats_factor'] = $arrStats['stats_factor'];

        return $arrItem;
    }

    private function getStatsFromRarity($numRarity, $strType)
    {
      $arrStats = [];

      $arrStats['stats'] = ['health' => 0, 'attack' => 0, 'defence' => 0, 'agility' => 0, 'luck' => 0];

      if($strType == 'sword' || $strType == 'bow' ||$strType == 'axe') {
        $arrStats['stats']['attack'] = round(rand(10 + $numRarity, 20 + $numRarity) * ($numRarity + 1));
      }

      if($strType == 'armor') {
        $arrStats['stats']['health'] = round(rand(10 + $numRarity, 20 + $numRarity) * ($numRarity + 1));
      }

      if($strType == 'shield' || $strType == 'helmet') {
        $arrStats['stats']['defence'] = round(rand(10 + $numRarity, 20 + $numRarity) * ($numRarity + 1));
      }

      if(substr($strType, 0, 7) == 'special') {
        $arrStats['stats']['agility'] = round(rand(10 + $numRarity, 20 + $numRarity) * ($numRarity + 1));
      }

      // Additional Luck
      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats']['luck'] = rand(1, ($numRarity + 1) * 2);
      }

      // Factors Only for items with a rarity bigger or equal than 3
      $arrStats['stats_factor'] = ['health' => 0, 'attack' => 0, 'defence' => 0, 'agility' => 0, 'luck' => 0];
      if($numRarity <= 3) {
        return $arrStats;
      }

      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats_factor']['attack'] = rand(($numRarity - 2) * 2, 10);
      }
      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats_factor']['health'] = rand(($numRarity - 2) * 2, 10);
      }
      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats_factor']['defence'] = rand(($numRarity - 2) * 2, 10);
      }
      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats_factor']['agility'] = rand(($numRarity - 2) * 2, 10);
      }
      if($this->isBetween(0, 50, rand(0, 100))) {
        $arrStats['stats_factor']['luck'] = rand(($numRarity - 2) * 2, 10);
      }

      return $arrStats;
    }

    private function getRarity()
    {
      $numRarityFactor = 60;

      if($this->isBetween(0, $numRarityFactor, rand(0, 100))) {
        $numRarity = RARITY_POOR;
      } else {
        if($this->isBetween(0, $numRarityFactor, rand(0, 100))) {
          $numRarity = RARITY_COMMON;
        } else {
          if($this->isBetween(0, $numRarityFactor, rand(0, 100))) {
            $numRarity = RARITY_UNCOMMON;
          } else {
            if($this->isBetween(0, $numRarityFactor, rand(0, 100))) {
              $numRarity = RARITY_EPIC;
            } else {
              if($this->isBetween(0, $numRarityFactor, rand(0, 100))) {
                $numRarity = RARITY_LEGENDARY;
              } else {
                $numRarity = RARITY_DIVINE;
              }
            }
          }
        }
      }
      return $numRarity;
    }

    private function getValue($arrData, $strKey, $mixDefault)
    {
        if(isset($arrData[$strKey])) {
            return $arrData[$strKey];
        }
        return $mixDefault;
    }

    private function isBetween($numFrom, $numTo, $numValue)
    {
      if($numValue >= $numFrom && $numValue <= $numTo) {
        return true;
      }
      return false;
    }

    private function getBase64Info($arrData) {
        $arrPackage = [
            'data' => $arrData,
            'hash' => md5(json_encode($arrData) . '-' . getConfig('security')['salt'])
        ];
        $strBase64 = base64_encode(json_encode($arrPackage));
        return $strBase64;
    }

    private function getHtmlTemplate($arrQuest, $strBase64)
    {

      // "Poor" (Grey) < "Common" (White) < "Uncommon" (Green) < "Epic" (Purple) < "Legendary" (Orange) < "Divine" (Yellow)
      $arrTemplate = ['color' => 'rgba(0,0,0,0.5)', 'border' => 'rgba(0,0,0,1)', 'img' => ''];
      $arrItem[0] = $arrTemplate;
      $arrItem[1] = $arrTemplate;
      $arrItem[2] = $arrTemplate;
      $arrItem[3] = $arrTemplate;
      foreach($arrQuest['items'] as $numItem => $arrRecord) {
        if($arrRecord['rarity'] == 0) {$arrItem[$numItem]['color'] = 'rgba(100,100,100,0.5)';}
        if($arrRecord['rarity'] == 0) {$arrItem[$numItem]['border'] = 'rgba(100,100,100,1)';}
        if($arrRecord['rarity'] == 1) {$arrItem[$numItem]['color'] = 'rgba(255,255,255,0.5)';}
        if($arrRecord['rarity'] == 1) {$arrItem[$numItem]['border'] = 'rgba(255,255,255,1)';}
        if($arrRecord['rarity'] == 2) {$arrItem[$numItem]['color'] = 'rgba(0,255,0,0.5)';}
        if($arrRecord['rarity'] == 2) {$arrItem[$numItem]['border'] = 'rgba(0,255,0,1)';}
        if($arrRecord['rarity'] == 3) {$arrItem[$numItem]['color'] = 'rgba(190,0,160,0.5)';}
        if($arrRecord['rarity'] == 3) {$arrItem[$numItem]['border'] = 'rgba(190,0,160,1)';}
        if($arrRecord['rarity'] == 4) {$arrItem[$numItem]['color'] = 'rgba(200,100,0,0.5)';}
        if($arrRecord['rarity'] == 4) {$arrItem[$numItem]['border'] = 'rgba(200,100,0,1)';}
        if($arrRecord['rarity'] == 5) {$arrItem[$numItem]['color'] = 'rgba(199,199,0,0.5)';}
        if($arrRecord['rarity'] == 5) {$arrItem[$numItem]['border'] = 'rgba(199,199,0,1)';}

        $arrItem[$numItem]['img'] = $arrRecord['image_key'];
      }

      $strHtml = '';
      $strHtml .= '<div style="position: relative; font-family: arial; color: #ffffff; padding: 20px; border: 1px solid #aaaaaa; width: 476px; height: 175px; background-image: url(' . getConfig('server')['root_path'] . '/gui/assets/images/ui/bg2.jpg); background-size: 600px 100px; border-radius: 10px;">';
      $strHtml .= '  <div style="position: relative; width: 457px; background-color: rgba(0,0,0,0.5); padding: 5px; border-radius: 5px; font-size: 23px;">';
      $strHtml .= '    &nbsp;&nbsp;' . $arrQuest['title'];
      $strHtml .= '  </div>';
      $strHtml .= '  <div style="position: relative; width: 174px; padding: 20px; height: 87px; background-color: rgba(0,0,0,0.5); margin-top: 10px; margin-right: 10px; border-radius: 10px; float: left;">';
      $strHtml .= '    <b>Priority:</b><br>' . $this->arrPriority[$arrQuest['prio']] . '<hr>';
      $strHtml .= '    <b>Experience:</b><br>' . $arrQuest['exp'];
      $strHtml .= '  </div>';
      $strHtml .= '  <div style="position: relative; border: 1px solid ' . $arrItem[0]['border'] . '; width: 62px; padding: 5px; height: 62px; background-color: ' . $arrItem[0]['color'] . '; margin-top: 10px; margin-right: 10px; border-radius: 10px; float: left;">';
      if(!empty($arrItem[0]['img'])) {
        $strHtml .= '    <img src="' . getConfig('server')['root_path'] . '/assets/images/character/' . $arrItem[0]['img'] . '.png" width="64px;">';
      }
      $strHtml .= '  </div>';
      $strHtml .= '  <div style="position: relative; border: 1px solid ' . $arrItem[1]['border'] . '; width: 62px; padding: 5px; height: 62px; background-color: ' . $arrItem[1]['color'] . '; margin-top: 10px; margin-right: 10px; border-radius: 10px; float: left;">';
      if(!empty($arrItem[1]['img'])) {
        $strHtml .= '    <img src="' . getConfig('server')['root_path'] . '/assets/images/character/' . $arrItem[1]['img'] . '.png" width="64px;">';
      }
      $strHtml .= '  </div>';
      $strHtml .= '  <div style="position: relative; border: 1px solid ' . $arrItem[2]['border'] . '; width: 62px; padding: 5px; height: 62px; background-color: ' . $arrItem[2]['color'] . '; margin-top: 10px; margin-right: 10px; border-radius: 10px; float: left;">';
      if(!empty($arrItem[2]['img'])) {
        $strHtml .= '    <img src="' . getConfig('server')['root_path'] . '/assets/images/character/' . $arrItem[2]['img'] . '.png" width="64px;">';
      }
      $strHtml .= '  </div>';
      $strHtml .= '  <div style="cursor: pointer; text-align: center; color:#ffffff;position: relative; width: 242px; padding-top: 12px; height: 30px; background-color: #428bca; margin-top: 10px; margin-right: 10px; border-radius: 10px; float: left;">';
      $strHtml .= '    Quest Abschliessen';
      $strHtml .= '  </div>';
      $strHtml .= '</div>';
      return $strHtml;
    }

    private function getItemImage($strType, $numRarity)
    {
      // Get Random Image form Type Folder
      $arrItems = scandir('../assets/images/character/' . $strType . '/');
      unset($arrItems[0]); // ..
      unset($arrItems[1]); // .

      // Nur Items in der Rarity Klasse
      $arrRarityItems = [];
      foreach($arrItems as $numIndex => $strItemKey) {
        if(intval(substr($strItemKey, 0, 1)) == $numRarity) {
          $arrRarityItems[] = $strItemKey;
        }
      }

      // Random Item Image ermitteln
      $numItem = rand(0, count($arrRarityItems) - 1);
      $numCount = 0;
      foreach($arrRarityItems as $strItemKey) {
        if($numItem == $numCount) {
          return $strType . '/' . substr($strItemKey,0, strlen($strItemKey) - 4);
        }
        $numCount++;
      }
      return '';
    }
}
