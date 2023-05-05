<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "company_duct";

  $connect = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$connect){
    echo "Database connection error".mysqli_connect_error();
  }
?>