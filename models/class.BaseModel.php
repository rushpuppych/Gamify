<?php

class BaseModel
{
  protected $objDb = null;
  protected $objStatement = null;

  public function BaseModel()
  {
    $arrDb = getConfig('database');
    $objPdo = new PDO('mysql:host=' . $arrDb['host'] . ':' . $arrDb['port'] . ';dbname=' . $arrDb['database'], $arrDb['user'], $arrDb['password']);
    $this->objDb = $objPdo;
  }

  public function execute($strSql, $arrParams)
  {
    // Build statement
    $objStatement = $this->objDb->prepare($strSql);

    // Build fields
    $arrField = [];
    foreach($arrParams as $strKey => $strValue) {
      $arrField[':' . $strKey] = $strValue;
    }
    $objStatement->execute($arrField);
    $this->objStatement = $objStatement;
  }

  public function queryAll()
  {
    $arrResult = [];
    while($arrRow = $this->objStatement->fetch()) {
      $arrResult[] = $arrRow;
    }
    return $arrResult;
  }
}
