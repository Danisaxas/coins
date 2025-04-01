<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier otra salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'home', 'logout', 'admin_codes'];

// Obtiene la ruta desde la URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Output buffering
ob_start();

// Determina a qué página ir
if (isset($_SESSION['usuario_id'])) {
    // Si el usuario tiene una sesión iniciada
    if ($page === 'register' || $page === 'login') {
        // Redirige al usuario a la página de inicio (monedas)
        header("Location: index.php?page=home");
        exit();
    } elseif ($page === 'logout') {
        include 'templates/logout.php';
    } elseif ($page === 'admin_codes') {
        // Verificar si el usuario es un OWNER
        if ($_SESSION['username'] === 'AstroOwn') {
            include 'templates/admin_codes.php';
        } else {
            header("Location: index.php?page=home");
            exit();
        }
    } else {
        include 'templates/monedas.php'; // Muestra la página de monedas
    }
} else {
    // Si el usuario no tiene una sesión iniciada
    if ($page === 'monedas') {
        header("Location: index.php?page=login");
        exit();
    }  else {
        include 'templates/'. $page . '.php';
    }
}

ob_end_flush();
?>
