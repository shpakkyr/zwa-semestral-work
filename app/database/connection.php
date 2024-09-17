<?php
$host = 'localhost';
$dbname = 'shpakkyr';
$user = 'shpakkyr';
$pass = 'webove aplikace';
//$host = 'localhost';
//$dbname = 'shpakkyr';
//$user = 'root';
//$pass = 'mysql';
/**
 * <p>Options for connecting to db</p>
 */
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}