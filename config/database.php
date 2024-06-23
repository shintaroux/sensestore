<?php
$dsn = 'mysql:host=localhost;dbname=lisensi_aktivasi_db';
$username = 'senseadmin';
$password = 'okezone123';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
