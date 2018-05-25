<?php

abstract class BaseImageGenerator
{
  private $arrResources = [];
  private $arrImageLayer = [];
  private $numImageWidth = 0;
  private $numImageHeight = 0;
  protected $arrRenderAnimation = [];
  protected $arrRenderDurations = [];

  public function setImageWidth($numImageWidth)
  {
    $this->numImageWidth = $numImageWidth;
  }

  public function setImageHeight($numImageHeight)
  {
    $this->numImageheight = $numImageHeight;
  }

  public function addImageResource($strKey, $strPath, $arrOptions)
  {
    $this->arrResources[$strKey] = [
      'path' => $strPath,
      'options' => $arrOptions
    ];
  }

  public function drawImage($strResourceKey, $numLayer, $numPosX, $numPosY, $numFrame = null)
  {
      // Return false if layer is not nummeric
      if(!is_numeric($numLayer)) {
        return false;
      }

      // Adding image to layer
      $this->arrImageLayer[$numLayer][] = [
        'type' => 'image',
        'resource' => $strResourceKey,
        'pos_x' => $numPosX,
        'pos_y' => $numPosY,
        'frame' => $numFrame
      ];
      ksort($this->arrImageLayer);
      return true;
  }

  private function render()
  {
    // Get All Animation Frames
    $arrFrames = [];
    foreach($this->arrRenderAnimation as $numFrame) {
      $this->arrImageLayer = [];
      $this->create($numFrame);
      $arrFrames[] = $this->generateImage($this->numImageWidth, $this->numImageheight);
    }

    // Get All Frame Durations
    $arrDurations = $this->arrRenderDurations;

    // Create Animated GIF
    $numLoops = 0; // 0 = inifinite gif looping
    $objGifCreator = new GifCreator();
    $objGifCreator->create($arrFrames, $arrDurations, $numLoops);
    $strBinaryImage = $objGifCreator->getGif();
    return $strBinaryImage;
  }

  public function renderToPath($strPath)
  {
    $strBinaryImage = $this->render();

    // Save to File
    $boolStatus = file_put_contents($strPath, $strBinaryImage);
    return $boolStatus;
  }

  public function renderToBase64()
  {
    $strBinaryImage = $this->render();

    // Binary to Base 64 Encoded
    $strBase64Image =  base64_encode($strBinaryImage);
    return $strBase64Image;
  }

  public function renderToResource()
  {
    $strBinaryImage = $this->render();

    // Create Resource from Binary String
    $objImage = imagecreatefromstring($strBinaryImage);
    return $objImage;
  }

  public function renderToResourceAnimated()
  {
    $strBinaryImage = $this->render();
    return $strBinaryImage;
  }

  protected function generateImage($numWidth, $numHeight)
  {
      // Create Empty Image
      $objImage = imagecreate($numWidth, $numHeight);

      // Loop over Layer and Images
      foreach($this->arrImageLayer as $numLayer => $arrLayer) {
        foreach($arrLayer as $arrObject) {
          // Add Image
          if($arrObject['type'] == 'image') {
              $objImage = $this->addImage($objImage, $arrObject, $numWidth, $numHeight);
          }

          // Add Text
          // todo:

          // Add Progress
          // todo:
        }
      }

      // Return Image Resource
      return $objImage;
  }

  protected function getDefaultColors(&$objImage)
  {
    // Setting all Default Colors
    $arrColors = [];
    $arrColors['white'] = ImageColorAllocate ($objImage, 255, 255, 255);
    $arrColors['black'] = ImageColorAllocate ($objImage, 0, 0, 0);
    $arrColors['red'] = ImageColorAllocate ($objImage, 255, 0, 0);
    $arrColors['green'] = ImageColorAllocate ($objImage, 0, 255, 0);
    $arrColors['blue'] = ImageColorAllocate ($objImage, 0, 0, 255);
    $arrColors['transparent_green'] = ImageColorAllocate ($objImage, 32, 156, 0);

    // Return Color Array
    return $arrColors;
  }

  protected function addImage($objImage, $arrObject, $numWidth, $numHeight)
  {
    // Load Image
    $strResourceKey = $arrObject['resource'];
    $arrResource = $this->arrResources[$strResourceKey];
    $objAddImage = imagecreatefrompng($arrResource['path']);

    // Calculate Image Frame Size
    $numFrameWidth = $arrResource['options']['width'];
    if(isset($arrResource['options']['columns'])) {
      $numFrameWidth = $numFrameWidth / $arrResource['options']['columns'];
    }

    $numFrameHeight = $arrResource['options']['height'];
    if(isset($arrResource['options']['rows'])) {
      $numFrameHeight = $numFrameHeight / $arrResource['options']['rows'];
    }

    // Calculate Image Frame Position
    $numRowNumber = intval(($arrObject['frame']) / $arrResource['options']['columns']);
    $numRowFactor = $numRowNumber * ($arrResource['options']['columns'] * $numFrameWidth);
    $numFramePosX = $arrObject['frame'] * $numFrameWidth - $numRowFactor;
    $numFramePosY = $numRowNumber * $numFrameHeight;

    // Create Image Container and Background
    $objImageContainer = imagecreatetruecolor($numWidth, $numHeight);

    // Set transparency
    $strTransparentColor = $this->getDefaultColors($objImageContainer)['transparent_green'];
    imagecolortransparent($objImageContainer, $strTransparentColor);
    imagefill($objImageContainer, 0, 0, $strTransparentColor);

    $strTransparentColor = $this->getDefaultColors($objImage)['transparent_green'];
    imagecolortransparent($objImage, $strTransparentColor);
    imagefill($objImage, 0, 0, $strTransparentColor);

    $strTransparentColor = $this->getDefaultColors($objAddImage)['transparent_green'];
    imagecolortransparent($objAddImage, $strTransparentColor);
    imagefill($objAddImage, 0, 0, $strTransparentColor);

    // Merge Images
    imagecopy($objImageContainer, $objImage, 0, 0, 0, 0, $numWidth, $numHeight);
    imagecopy($objImageContainer, $objAddImage, 0, 0, $numFramePosX, $numFramePosY, $numFrameWidth, $numFrameHeight);

    // Free Memory
    imagedestroy($objImage);
    imagedestroy($objAddImage);

    // Finish and Return Merged Content
    return $objImageContainer;
  }
}
