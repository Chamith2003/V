<?php
$host='localhost';
$dbname='demo';
$user='root';
$pass='';

try {
    $conn=new mysqli($host, $user, $pass, $dbname);
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage() . "<br>");
}

// $conn->set_charset("utf8mb4"); 





?>