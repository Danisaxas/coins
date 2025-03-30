<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'home', 'logout'];

// Obtiene la ruta desde la URL
$ruta = isset($_GET['page']) ? $_GET['page'] : '';

// Determina a qué página ir
if (isset($_SESSION['usuario_id'])) {
    // Si el usuario tiene una sesión iniciada
    if ($ruta === 'logout') {
        include 'templates/logout.php';
    } else {
        // Redirige al usuario a la página de inicio (monedas)
        header("Location: index.php?page=monedas");
        exit();
    }
} else {
    // Si el usuario no tiene una sesión iniciada
    if ($ruta === 'register') {
        include 'templates/register.php';
    } else {
        // Muestra la página de inicio de sesión
        include 'templates/login.php';
    }
}

ob_end_flush();
?>
