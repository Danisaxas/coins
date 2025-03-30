<?php
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
?>