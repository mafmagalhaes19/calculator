<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.php');
  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../calculator.class.php');

  $result = Calculator::computeCalculation($db,$_GET['operation']);

  echo json_encode($result);
?>