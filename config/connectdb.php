<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_crud";

$dsn = "mysql:host=$servername;dbname=$dbname";

try {
  $conn = new PDO($dsn, $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //   echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// เก็บ session 
session_start();
