<?php
$servername = 'remotemysql.com';
$username = 'Bi25Netqw8';
$password = 'mlFm8N0546';
$bdname = 'Bi25Netqw8';
$charset = 'utf8mb4';

$dsn = "mysql:host=$servername;dbname=$bdname;charset=$charset";
$conn = new PDO($dsn, $username, $password);
?>
