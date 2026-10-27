<?php
$host = 'localhost';
$user = 'YOUR_DB_USERNAME';
$password = 'YOUR_DB_PASSWORD';
$database = 'studentapp';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    exit('Database connection failed.');
}