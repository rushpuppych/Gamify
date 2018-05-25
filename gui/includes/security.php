
<?php

SESSION_START();

if(empty($_SESSION['user'])) {
  header('location:login.php');
}
