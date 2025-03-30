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



// Función para registrar un nuevo usuario
function registrarUsuario($pdo, $username, $correo, $contrasena) {
    try {
        $sql = "INSERT INTO users (username, correo, contrasena) VALUES (:username, :correo, :contrasena)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena); // La contraseña se almacena sin encriptar
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Manejar el error de manera más específica (por ejemplo, usuario o correo ya existen)
        if ($e->getCode() == 23000) {
            return "Error: El nombre de usuario o el correo electrónico ya están en uso.";
        } else {
            return "Error al registrar usuario: " . $e->getMessage(); // Mensaje de error genérico
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

        if ($user && $user['contrasena'] === $contrasena) { // La contraseña se compara sin encriptación
            return $user; // Devuelve el registro del usuario
        } else {
            return false; // Credenciales inválidas
        }
    } catch (PDOException $e) {
        die("Error al iniciar sesión: " . $e->getMessage());
    }
}



?>