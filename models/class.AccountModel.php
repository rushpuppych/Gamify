<?php

class AccountModel extends BaseModel
{
  /**
  * SELECT STATEMENT
  * Kontrolliert ob mit der gegebenen Email, Password Kombination ob
  * bereits ein Account angelegt ist. Wenn der Account existiert wird
  * TRUE zurück gegeben wenn nicht dann FALSE
  */
  public function checkLogin($strEmail, $strPassword)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM account
               WHERE email = :email
               AND password = :password;';

    // Set SQL field values
    $arrFields = [
      'email' => $strEmail,
      'password' => $strPassword
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    // Check for Data
    if(empty($arrData)) {
      return false;
    }
    return true;
  }

  /**
  * SELECT statement
  * Liest einen Account anhand der account_id aus und gibt diesen zurück.
  */
  public function getAccountByAccountId($numAccountId)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM account
               WHERE id = :account_id;';

    // Set SQL field values
    $arrFields = [
      'account_id' => $numAccountId
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll()[0];
    $arrData['password'] = '***SECRET***';
    return $arrData;
  }

  /**
  * SELECT STATEMENT
  * Liest einen Account anhand von email und password aus
  * der Datenbank aus und gibt diese zurück.
  */
  public function getAccountByCredentials($strEmail, $strPassword)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM account
               WHERE email = :email
               AND password = :password;';

    // Set SQL field values
    $arrFields = [
      'email' => $strEmail,
      'password' => $strPassword
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();
    return $arrData;
  }

  /**
  * SELECT STATEMENT
  * Kontrolliert ob mit der gegebenen Email ob
  * bereits ein Account angelegt ist. Wenn der Account existiert wird
  * TRUE zurück gegeben wenn nicht dann FALSE
  */
  public function checkEmail($strEmail)
  {
    // Set SQL statement
    $strSql = 'SELECT * FROM account
               WHERE email = :email;';

    // Set SQL field values
    $arrFields = [
      'email' => $strEmail
    ];

    // Execute SQL
    $this->execute($strSql, $arrFields);
    $arrData = $this->queryAll();

    // Check for Data
    if(empty($arrData)) {
      return false;
    }
    return true;
  }

  /**
  * INSERT STATEMENT
  * Legt einen neuen Benutzer Account an.
  * Die Daten email, password und fraction werden hierbei abgefüllt.
  */
  public function createAccount($strEmail, $strPassword, $strFraction)
  {
    // Set SQL statement
    $strSql = 'INSERT INTO account
              (email, password, fraction)
              VALUES
              (:email, :password, :fraction);';

    // Set SQL field values
    $arrFields = [
      'email' => $strEmail,
      'password' => $strPassword,
      'fraction' => $strFraction
    ];

    // Execute Insert SQL
    $this->execute($strSql, $arrFields);
  }

  /**
  * UPDATE STATEMENT
  * Setzt das neue Password bei dem Account mit der angegebenen Email
  * Adresse.
  */
  public function resetPasswordByEmail($strEmail, $strPassword)
  {
    // Set SQL statement
    $strSql = 'UPDATE account
               SET password = :password
               WHERE email = :email;';

    // Set SQL field values
    $arrFields = [
      'email' => $strEmail,
      'password' => $strPassword
    ];

    // Execute Insert SQL
    $this->execute($strSql, $arrFields);
  }
}
