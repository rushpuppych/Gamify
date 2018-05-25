<?php

class ItemNameGenerator
{
    public function getRandomItemName($numRarity)
    {
      // Weapon, Armor, Special, Shield, Helmet
      $numItemType = rand(0, 5);
      switch($numItemType) {
        case 0:
        case 1:
          $numWeapon = rand(0, 2);
          if($numWeapon == 0) {
            $arrItem = ['type' => 'sword', 'name' => $this->getSwordWeaponName($numRarity)];
          } elseif($numWeapon == 1) {
            $arrItem = ['type' => 'bow', 'name' => $this->getBowWeaponName($numRarity)];
          } else {
            $arrItem = ['type' => 'axe', 'name' => $this->getAxeWeaponName($numRarity)];
          }
          break;
        case 2:
          $arrItem = ['type' => 'armor', 'name' => $this->getArmorName($numRarity)];
          break;
        case 3:
          $arrItem = ['type' => 'special', 'name' => $this->getSpecialName($numRarity)];
          break;
        case 4:
          $arrItem = ['type' => 'shield', 'name' => $this->getShieldName($numRarity)];
          break;
        case 5:
          $arrItem = ['type' => 'helmet', 'name' => $this->getHelmetName($numRarity)];
          break;
      }
      return $arrItem;
    }

    public function getSwordWeaponName($numRarity)
    {
      $arrItem = $this->getSwordWeapon();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getBowWeaponName($numRarity)
    {
      $arrItem = $this->getBowWeapon();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getAxeWeaponName($numRarity)
    {
      $arrItem = $this->getAxeWeapon();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getArmorName($numRarity)
    {
      $arrItem = $this->getArmor();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getSpecialName($numRarity)
    {
      $arrItem = $this->getSpecial();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getShieldName($numRarity)
    {
      $arrItem = $this->getShield();
      return $this->getItemName($arrItem, $numRarity);
    }

    public function getHelmetName($numRarity)
    {
      $arrItem = $this->getHelmet();
      return $this->getItemName($arrItem, $numRarity);
    }

    private function getItemName($arrItem, $numRarity)
    {
        // Get Text Blocks and Template
        $strTemplate = $this->getItemNameTemplate($numRarity);
        $arrPers = $this->getPersonal($numRarity);
        $strMaterial = $this->getMaterials($numRarity);

        // Build Replace Array
        $arrReplace = [
            'material' => $strMaterial,
            'item_the' => $arrItem['the'],
            'item' => $arrItem['val'],
            'adj_1' => $this->getAdjective($numRarity),
            'adj_2' => $this->getAdjective($numRarity),
            'pers_the' => $arrPers['the'],
            'pers' => $arrPers['val'],
        ];

        // Replace
        $strName = $strTemplate;
        foreach($arrReplace as $strKey => $strValue) {
            $strName = str_replace('[' . $strKey . ']', $strValue, $strName);
        }
        return ucfirst($strName);
    }

    private function getItemNameTemplate($numRarity = null, $boolReturnAll = false)
    {
        $arrTpl = [];
        $arrTpl[] = '[material] [item]';
        $arrTpl[] = '[item_the] [adj_1] [material] [item]';
        $arrTpl[] = '[item_the] [material] [item] [pers_the] [pers]';
        $arrTpl[] = '[item_the] [material] [item] [pers_the] [adj_2]n [pers]';
        $arrTpl[] = '[item_the] [adj_1] [material] [item] [pers_the] [adj_2]n [pers]';

        return $this->getTplReturn($arrTpl, $boolReturnAll);
    }

    private function getMaterials($numRarity = null, $boolReturnAll = false)
    {
        $arrTxt = [];

        // Poor (Gray)
        $arrTxt[0][] = 'Holz';
        $arrTxt[0][] = 'Bronze';
        $arrTxt[0][] = 'Stein';
        $arrTxt[0][] = 'Gummi';

        // Common (White)
        $arrTxt[1][] = 'Stahl';
        $arrTxt[1][] = 'Eisen';

        // Uncommon (Green)
        $arrTxt[2][] = 'Silber';
        $arrTxt[2][] = 'Gold';

        // Epic (Purple)
        $arrTxt[3][] = 'Titan';
        $arrTxt[3][] = 'Kristal';
        $arrTxt[3][] = 'Diamant';

        // Legendary (Orange)
        $arrTxt[4][] = 'Mithril';
        $arrTxt[4][] = 'Adamantium';
        $arrTxt[4][] = 'Carbonit';

        // Divine (Yellow)
        $arrTxt[5][] = 'Arkanium';
        $arrTxt[5][] = 'Eternium';
        $arrTxt[5][] = 'Materium';

        return $this->getTxtReturn($arrTxt, $numRarity, $boolReturnAll);
    }

    private function getAdjective($numRarity = null, $boolReturnAll = false)
    {
        $arrTxt = [];

        // Poor (Gray)
        $arrTxt[0][] = 'schleimige';
        $arrTxt[0][] = 'rostende';
        $arrTxt[0][] = 'bröckelnde';
        $arrTxt[0][] = 'müffelnde';
        $arrTxt[0][] = 'gamlige';
        $arrTxt[0][] = 'lädierte';

        // Common (White)
        $arrTxt[1][] = 'polierte';
        $arrTxt[1][] = 'gepflegte';

        // Uncommon (Green)
        $arrTxt[2][] = 'spezielle';
        $arrTxt[2][] = 'seltene';
        $arrTxt[2][] = 'vergiftete';
        $arrTxt[2][] = 'grausame';
        $arrTxt[2][] = 'stolze';

        // Epic (Purple)
        $arrTxt[3][] = 'epische';
        $arrTxt[3][] = 'barbarische';
        $arrTxt[3][] = 'königliche';

        // Legendary (Orange)
        $arrTxt[4][] = 'legendäre';
        $arrTxt[4][] = 'gigantische';

        // Divine (Yellow)
        $arrTxt[5][] = 'göttliche';
        $arrTxt[5][] = 'ultimative';
        $arrTxt[5][] = 'unantastbare';

        return $this->getTxtReturn($arrTxt, $numRarity, $boolReturnAll);
    }

    private function getPersonal($numRarity, $boolReturnAll = false)
    {
        $arrTxt = [];

        // Poor (Gray)
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Lauchs'];
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Träumers'];
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Dorftrotels'];
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Tölpels'];
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Winzling'];
        $arrTxt[0][] = ['the' => 'des', 'val' => 'Weichei'];

        // Common (White)
        $arrTxt[1][] = ['the' => 'des', 'val' => 'Holzfällers'];
        $arrTxt[1][] = ['the' => 'des', 'val' => 'Ritters'];

        // Uncommon (Green)
        $arrTxt[2][] = ['the' => 'des', 'val' => 'Anführers'];
        $arrTxt[2][] = ['the' => 'des', 'val' => 'Wehrwolfes'];
        $arrTxt[2][] = ['the' => 'des', 'val' => 'Aggressor'];

        // Epic (Purple)
        $arrTxt[3][] = ['the' => 'des', 'val' => 'Dämonen'];
        $arrTxt[3][] = ['the' => 'der', 'val' => 'Macht'];

        // Legendary (Orange)
        $arrTxt[4][] = ['the' => 'des', 'val' => 'Inkubus'];
        $arrTxt[4][] = ['the' => 'des', 'val' => 'Sukubus'];

        // Divine (Yellow)
        $arrTxt[5][] = ['the' => 'des', 'val' => 'Erzengels'];
        $arrTxt[5][] = ['the' => 'des', 'val' => 'Teufels'];
        $arrTxt[5][] = ['the' => 'des', 'val' => 'Gottes'];

        return $this->getTxtReturn($arrTxt, $numRarity, $boolReturnAll);
    }

    private function getSwordWeapon($boolReturnAll = false)
    {
        $arrTxt = [];
        $arrTxt[] = ['the' => 'die', 'val' => 'Klinge'];
        $arrTxt[] = ['the' => 'das', 'val' => 'Schwert'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Schlizer'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Spalter'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Zweihänder'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Degen'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Säbel'];

        return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getBowWeapon($boolReturnAll = false)
    {
        $arrTxt = [];
        $arrTxt[] = ['the' => 'der', 'val' => 'Bogen'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Jagtbogen'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Kompositbogen'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Langbogen'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Kurzbogen'];

        return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getAxeWeapon($boolReturnAll = false)
    {
        $arrTxt = [];
        $arrTxt[] = ['the' => 'die', 'val' => 'Axt'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Spalter'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Drescher'];
        $arrTxt[] = ['the' => 'der', 'val' => 'Keiler'];

        return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getArmor($boolReturnAll = false)
    {
      $arrTxt = [];
      $arrTxt[] = ['the' => 'die', 'val' => 'Rüstung'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Platte'];
      $arrTxt[] = ['the' => 'das', 'val' => 'Kettenhemd'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Schutzweste'];

      return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getSpecial($boolReturnAll = false)
    {
      $arrTxt = [];
      $arrTxt[] = ['the' => 'der', 'val' => 'Segen'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Ergänzung'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Mutation'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Veränderung'];

      return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getShield($boolReturnAll = false)
    {
      $arrTxt = [];
      $arrTxt[] = ['the' => 'das', 'val' => 'Schild'];
      $arrTxt[] = ['the' => 'der', 'val' => 'Blocker'];
      $arrTxt[] = ['the' => 'der', 'val' => 'Rundschild'];
      $arrTxt[] = ['the' => 'der', 'val' => 'Verteidiger'];

      return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getHelmet($boolReturnAll = false)
    {
      $arrTxt = [];
      $arrTxt[] = ['the' => 'der', 'val' => 'Helm'];
      $arrTxt[] = ['the' => 'die', 'val' => 'Kappe'];
      $arrTxt[] = ['the' => 'der', 'val' => 'Kopfschutz'];

      return $this->getTplReturn($arrTxt, $boolReturnAll);
    }

    private function getTplReturn($arrTxt, $boolReturnAll)
    {
        if(!$boolReturnAll) {
            $numIndex = rand(0, count($arrTxt) -1);
            return $arrTxt[$numIndex];
        } else {
            return $arrTxt;
        }
    }

    private function getTxtReturn($arrTxt, $numRarity, $boolReturnAll)
    {
        if(!$boolReturnAll) {
            if(is_null($numRarity)) {
                $numRarity = rand(0, 5);
            }
            $numIndex = rand(0, count($arrTxt[$numRarity]) -1);
            return $arrTxt[$numRarity][$numIndex];
        } else {
            return $arrTxt;
        }
    }
}
