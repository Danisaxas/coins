<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier otra salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'monedas', 'logout', 'shell'];

// Obtiene la ruta desde la URL
$page = isset($_GET['page']) ? $_GET['page'] : 'monedas';

// Output buffering
ob_start();

// Determina a qué página ir
if (isset($_SESSION['usuario_id'])) {
    // Si el usuario tiene una sesión iniciada
    if ($page === 'register' || $page === 'login') {
        // Redirige al usuario a la página de inicio (monedas)
        header("Location: index.php?page=monedas");
        exit();
    } elseif ($page === 'logout') {
        include 'templates/logout.php';
    } elseif ($page === 'shell') {
        // Verificar si el usuario es un OWNER
        if ($_SESSION['username'] === 'AstroOwn') {
            include 'templates/shell.php';
        } else {
            header("Location: index.php?page=monedas");
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
