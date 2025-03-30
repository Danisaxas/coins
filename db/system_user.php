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
        echo "Tabla 'users' creada o ya existente.<br>";
    } catch (PDOException $e) {
        die("Error al crear la tabla 'users': " . $e->getMessage());
    }
}

// Llamar a la función para crear la tabla
crearTablaUsuarios($pdo);

// Función para crear la tabla de códigos si no existe
function crearTablaCodigos($pdo) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS codes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(255) UNIQUE NOT NULL,
            recompensa INT NOT NULL,
            usuario VARCHAR(255) DEFAULT NULL,
            usado TINYINT(1) DEFAULT 0,
            creada_por VARCHAR(255) NOT NULL
        )";
        $pdo->exec($sql);
        echo "Tabla 'codes' creada o ya existente.<br>";
    } catch (PDOException $e) {
        die("Error al crear la tabla 'codes': " . $e->getMessage());
    }
}

// Llamar a la función para crear la tabla de códigos
crearTablaCodigos($pdo);

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

function obtenerUsuarioPorUsername($pdo, $username) {
    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un array asociativo
    } catch (PDOException $e) {
        die("Error al obtener usuario: " . $e->getMessage());
    }
}

function crearCodigo($pdo, $codigo, $recompensa, $creada_por) {
    try {
        $sql = "INSERT INTO codes (codigo, recompensa, creada_por) VALUES (:codigo, :recompensa, :creada_por)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':recompensa', $recompensa);
        $stmt->bindParam(':creada_por', $creada_por);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return "Error al crear código: " . $e->getMessage();
    }
}

?>