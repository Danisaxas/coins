<?php
// db/system_user.php

// Conexión a la base de datos
$host = 'gondola.proxy.rlwy.net';
$port = 40901;
$dbname = 'railway';
$user = 'root';
$pass = 'tOdANCqiEPYRhYMpuhaSjiSFkRcgYyfv';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

?>
