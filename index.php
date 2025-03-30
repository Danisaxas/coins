**index.php:**

```php
<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier salida
session_start();
// Incluye el archivo de la base de datos
$db_file_path = 'db/system_user.php'; // Define la ruta del archivo
if (file_exists($db_file_path)) {
    require_once $db_file_path;
} else {
    die("Error: No se pudo encontrar el archivo de la base de datos en: " . $db_file_path);
}

// Determina qué página cargar
$page = isset($_GET['page']) ? $_GET['page'] : 'register'; // Por defecto a la página de registro

if ($page === 'register') {
    include 'templates/register.php';
} elseif ($page === 'login') {
    include 'templates/login.php';
} elseif ($page === 'monedas') {
    include 'templates/monedas.php';
} elseif ($page === 'logout') {
    include 'templates/logout.php';
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}
?>

```
