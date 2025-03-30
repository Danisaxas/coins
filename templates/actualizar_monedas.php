<?php
// actualizar_monedas.php
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevasMonedas = $_POST['monedas'];
    $usuarioId = $_SESSION['usuario_id'];

    try {
        $sql = "UPDATE users SET monedas = :monedas WHERE id = :usuarioId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':monedas', $nuevasMonedas, PDO::PARAM_INT);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        // Actualizar la variable de sesión
        $_SESSION['monedas'] = $nuevasMonedas;

        echo "Monedas actualizadas con éxito"; // Enviar una respuesta de éxito
    } catch (PDOException $e) {
        http_response_code(500); // Establecer código de error
        echo "Error al actualizar las monedas: " . $e->getMessage(); // Enviar mensaje de error
    }
} else {
    http_response_code(400); // Establecer código de error para solicitud incorrecta
    echo "Solicitud incorrecta";
}
?>