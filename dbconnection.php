<?php

$dbuser="root1";
$dbpass="";
$dbhost="localhost";
$db="Medbazaar"; 

$conn=mysqli_connect($dbhost, $dbuser, $dbpass, $db) or die("Connection Failed".mysqli_connect_error());

?>