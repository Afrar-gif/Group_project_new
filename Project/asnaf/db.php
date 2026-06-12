<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "edl";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if(!$conn){

    die("Database Connection Failed");

}

?>