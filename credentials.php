<?php 

$servername = "localhost";
$username = "User_1";
$password = "8pBolu4sp03YgvtO";
$dbname = "hiit_appDB";

$username = "jakesega_User_1";
$password = "8pBolu4sp03YgvtO";
$dbname = "jakesega_hitt_appdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

?>