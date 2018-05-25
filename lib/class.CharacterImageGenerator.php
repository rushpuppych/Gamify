<?php

class CharacterImageGenerator extends BaseImageGenerator
{
  private $arrEquipItem = [];
  private $arrCharacter = [];
  private $arrAnimations = [];
  private $arrDurations = [];

  public function CharacterImageGenerator($numSpeedFactor = 1)
  {
    // Add Animation Steps
    $this->arrAnimations = [
      'idle' => [7, 4, 7, 10],
      'walk_up' => [0, 1, 2, 1],
      'walk_right' => [3, 4, 5, 4],
      'walk_down' => [6, 7, 8, 7],
      'walk_left' => [9, 10, 11, 10]
    ];

    // Add Animation Steps Duration
    $this->arrDurations = [
      'idle' => [1000 * $numSpeedFactor, 50 * $numSpeedFactor, 50 * $numSpeedFactor, 50 * $numSpeedFactor],
      'walk_up' => [20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor],
      'walk_right' => [20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor],
      'walk_down' => [20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor],
      'walk_left' => [20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor, 20 * $numSpeedFactor]
    ];
  }

  public function setCharacter($strBodyKey, $strFaceKey, $strHairKey, $strAnimation = 7)
  {
    // Set Animation
    if(isset($this->arrAnimations[$strAnimation])) {
        $this->arrRenderAnimation = $this->arrAnimations[$strAnimation];
        $this->arrRenderDurations = $this->arrDurations[$strAnimation];
    } else {
        $this->arrRenderAnimation = [$strAnimation];
        $this->arrRenderDurations = [1];
    }

    // Set Character
    $this->arrCharacter['body'] = 'body_' . $strBodyKey;
    $this->arrCharacter['face'] = 'face_' . $strFaceKey;
    $this->arrCharacter['hair'] = 'hair_' . $strHairKey;
  }

  public function setEquipment($strArmorKey = null, $strHelmetKey = null, $strSpecialBackKey = null, $strSpecialFrontKey = null)
  {
    $this->arrEquipItem = [];

    // Set Equipment Resources
    if(!is_null($strArmorKey)) {
      $this->arrEquipItem['armor'] = 'armor_' . $strArmorKey;
    }
    if(!is_null($strHelmetKey)) {
      $this->arrEquipItem['helmet'] = 'helmet_' . $strHelmetKey;
    }
    /*
    if(!is_null($strWeaponKey)) {
      $this->arrEquipItem['weapon'] = 'weapon_' . $strWeaponKey;
    }
    if(!is_null($strShieldKey)) {
      $this->arrEquipItem['shield'] = 'shield_' . $strShieldKey;
    }
    */
    if(!is_null($strSpecialBackKey)) {
      $this->arrEquipItem['specialback'] = 'specialback_' . $strSpecialBackKey;
    }
    if(!is_null($strSpecialFrontKey)) {
      $this->arrEquipItem['specialfront'] = 'specialfront_' . $strSpecialFrontKey;
    }
  }

  public function setEquipmentArray($arrEquipmentArray)
  {
    // Set Default Value
    $strArmor = null;
    $strHelmet = null;
    $strSpecialback = null;
    $strSpecialfront = null;

    // Set Equiped Items
    foreach($arrEquipmentArray as $arrRecord) {
      $strImageKey = $arrRecord['image_key'];
      $arrImageKey = explode('/', $strImageKey);

      // Selection
      if($arrImageKey[0] == 'armor') {
        $strArmor = $arrImageKey[1];
      }
      if($arrImageKey[0] == 'helmet') {
        $strHelmet = $arrImageKey[1];
      }
      if($arrImageKey[0] == 'specialback') {
        $strSpecialback = $arrImageKey[1];
      }
      if($arrImageKey[0] == 'specialfront') {
        $strSpecialfront = $arrImageKey[1];
      }
    }

    // Set Equipment
    $this->setEquipment($strArmor, $strHelmet, $strSpecialback, $strSpecialfront);
  }

  public function create($numFrame)
  {
    // Load all needed resources
    $this->loadResources();

    // Set Character image Size
    $this->setImageWidth(72);
    $this->setImageHeight(96);

    // Render Images
    $this->createCharacterLayer($numFrame);
    $this->createEquipmentLayer($numFrame);
  }

  private function createCharacterLayer($numFrame)
  {
    if(!empty($this->arrCharacter)) {
      $this->drawImage($this->arrCharacter['body'], 2, 0, 0, $numFrame);
      $this->drawImage($this->arrCharacter['face'], 3, 0, 0, $numFrame);

      // Draw Hair Only if there is no Helmet
      if(!isset($this->arrEquipItem['helmet'])) {
        $this->drawImage($this->arrCharacter['hair'], 4, 0, 0, $numFrame);
      }
    }
  }

  private function createEquipmentLayer($numFrame)
  {
    if(!empty($this->arrEquipItem)) {
      // Special back = Layer 5 or 10
      if(isset($this->arrEquipItem['specialback'])) {
        if($numFrame < 6 || $numFrame > 8) {
          $this->drawImage($this->arrEquipItem['specialback'], 10, 0, 0, $numFrame);
        } else {
          $this->drawImage($this->arrEquipItem['specialback'], 5, 0, 0, $numFrame);
        }
      }

      // Special front = Layer 5 or 10
      if(isset($this->arrEquipItem['specialfront'])) {
        if($numFrame < 3) {
          $this->drawImage($this->arrEquipItem['specialfront'], 5, 0, 0, $numFrame);
        } else {
          $this->drawImage($this->arrEquipItem['specialfront'], 10, 0, 0, $numFrame);
        }
      }

      // Armor = Layer 6
      if(isset($this->arrEquipItem['armor'])) {
        $this->drawImage($this->arrEquipItem['armor'], 6, 0, 0, $numFrame);
      }

      // Helmet = Layer 7
      if(isset($this->arrEquipItem['helmet'])) {
        $this->drawImage($this->arrEquipItem['helmet'], 7, 0, 0, $numFrame);
      }

      // Shield = Layer 8
      if(isset($this->arrEquipItem['shield'])) {
        // no Shield (because looks stupid)
        //$this->drawImage($this->arrEquipItem['shield'], 8, 0, 0, $numFrame);
      }

      // Weapon = Layer 9
      if(isset($this->arrEquipItem['weapon'])) {
        // no weapon (because looks stupid)
        //$this->drawImage($this->arrEquipItem['weapon'], 9, 0, 0, $numFrame);
      }
    }
  }

  private function loadResources()
  {
    // Set Character Resources
    $arrOptions = [
      'width' => 216,
      'height' => 384,
      'columns' => 3,
      'rows' => 4
    ];

    // Load Character Resources
    $this->addImageResource($this->arrCharacter['body'], '../assets/images/character/body/' . substr($this->arrCharacter['body'], 5) . '.png', $arrOptions);
    $this->addImageResource($this->arrCharacter['face'], '../assets/images/character/face/' . substr($this->arrCharacter['face'], 5) . '.png', $arrOptions);
    $this->addImageResource($this->arrCharacter['hair'], '../assets/images/character/hair/' . substr($this->arrCharacter['hair'], 5) . '.png', $arrOptions);

    // Load Equipment Resources
    if(isset($this->arrEquipItem['armor'])) {
      $this->addImageResource($this->arrEquipItem['armor'], '../assets/images/character/armor/' . substr($this->arrEquipItem['armor'], 6) . '.png', $arrOptions);
    }
    if(isset($this->arrEquipItem['helmet'])) {
      $this->addImageResource($this->arrEquipItem['helmet'], '../assets/images/character/helmet/' . substr($this->arrEquipItem['helmet'], 7) . '.png', $arrOptions);
    }
    if(isset($this->arrEquipItem['weapon'])) {
      $this->addImageResource($this->arrEquipItem['weapon'], '../assets/images/character/weapon/' . substr($this->arrEquipItem['weapon'], 7) . '.png', $arrOptions);
    }
    if(isset($this->arrEquipItem['shield'])) {
      $this->addImageResource($this->arrEquipItem['shield'], '../assets/images/character/shield/' . substr($this->arrEquipItem['shield'], 7) . '.png', $arrOptions);
    }
    if(isset($this->arrEquipItem['specialback'])) {
      $this->addImageResource($this->arrEquipItem['specialback'], '../assets/images/character/specialback/' . substr($this->arrEquipItem['specialback'], 12) . '.png', $arrOptions);
    }
    if(isset($this->arrEquipItem['specialfront'])) {
      $this->addImageResource($this->arrEquipItem['specialfront'], '../assets/images/character/specialfront/' . substr($this->arrEquipItem['specialfront'], 13) . '.png', $arrOptions);
    }
  }
}
