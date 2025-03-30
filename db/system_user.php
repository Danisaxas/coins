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

// Función para crear la tabla de usuarios si no existe
function crearTablaUsuarios($pdo) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) UNIQUE NOT NULL,
            correo VARCHAR(255) UNIQUE NOT NULL,
            contrasena VARCHAR(255) NOT NULL,
            monedas INT DEFAULT 0,
            ban TINYINT(1) DEFAULT 0
        )";
        $pdo->exec($sql);
        // No imprimir directamente aquí.  La creación de la tabla no es parte de la respuesta HTTP principal.
    } catch (PDOException $e) {
        die("Error al crear la tabla 'users': " . $e->getMessage());
    }
}

// Llamar a la función para crear la tabla
crearTablaUsuarios($pdo);

// Función para registrar un nuevo usuario
function registrarUsuario($pdo, $username, $correo, $contrasena) {
    try {
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
        $sql = "INSERT INTO users (username, correo, contrasena) VALUES (:username, :correo, :hashed_password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Manejar el error de manera más específica
        if ($e->getCode() == 23000) {
            return "Error: El nombre de usuario o el correo electrónico ya están en uso.";
        } else {
            return "Error al registrar usuario: " . $e->getMessage();
        }
    }
}

// Función para iniciar sesión de usuario
function iniciarSesion($pdo, $username, $contrasena) {
    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            return $user;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Error al iniciar sesión: " . $e->getMessage());
    }
}
?>