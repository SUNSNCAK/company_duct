<?php
session_start();

if (!isset($_SESSION['user_login'])) {
      echo 0;
      exit;
}

$iduser = $_SESSION['user_login'];
$mysqli = new mysqli('localhost', 'root', '', 'company_duct');
$sql = "SELECT SUM(quantity) FROM cart WHERE user_id = $iduser";
$result = $mysqli->query($sql);
list($count) = $result->fetch_row();
echo $count;
$mysqli->close();
?>