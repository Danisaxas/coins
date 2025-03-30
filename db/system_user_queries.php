**db/system_user_queries.php:**

```php
<?php
// db/system_user_queries.php

// Función para iniciar sesión de usuario
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
?>
```