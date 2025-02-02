<?php

    $host = 'localhost';
    $dbname = 'reservationform';
    $dbusername = 'root';
    $dbpassword = '';

    // connecting on the db using php data object
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection Failed: " . $e->getMessage());
    }