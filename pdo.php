<?php
$msg = "";
try {
    $conn = new pdo('mysql:host=localhost;port=8888;dbname=flight','php','phpdb');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $msg = "Connection Err!";
}

?>