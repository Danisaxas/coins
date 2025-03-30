<?php
// db/system_user_queries.php

function iniciarSesion($pdo, $username, $contrasena) {
    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && $user['contrasena'] === $contrasena) {
            return $user;
        } else {
            return false;
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
