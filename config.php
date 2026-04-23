<?php
$host='localhost';
$dbname='demo';
$user='root';
$pass='004047';

$conn=new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error."<br>");
}

// $conn->set_charset("utf8mb4"); 





?>