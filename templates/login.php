<?php
// templates/login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-white/10 p-8 rounded-xl shadow-lg backdrop-blur-md w-full max-w-md">
        <h2 class="text-3xl font-semibold text-white mb-6 text-center">Iniciar Sesión</h2>
        <?php
        //  No se inicia la sesión aquí, se inicia en index.php
        if (isset($_SESSION['login_error'])) {
            echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4' role='alert'>
                <strong class='font-bold'>Error:</strong>
                <span class='block sm:inline'>".$_SESSION['login_error']."</span>
            </div>";
            unset($_SESSION['login_error']); // Limpia el error después de mostrarlo
        }
        ?>
        <form method="post" action="index.php?page=login" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-300 text-sm font-bold mb-2">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario" required class="shadow appearance-none border rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/90">
            </div>
            <div>
                <label for="contrasena" class="block text-gray-300 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required class="shadow appearance-none border rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/90">
            </div>
            <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out">Iniciar Sesión</button>
        </form>
        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">¿No tienes una cuenta? <a href="index.php?page=register" class="text-blue-400 hover:text-blue-300 font-semibold transition duration-200 ease-in-out">Regístrate</a></p>
        </div>
    </div>
</body>
</html>
<?php
    require_once(__DIR__ . '/../db/system_user.php'); // Asegúrate de que la ruta sea correcta
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $contrasena = $_POST['contrasena'];

        $resultado_inicio_sesion = iniciarSesion($pdo, $username, $contrasena); // Usa la función iniciarSesion
        if ($resultado_inicio_sesion) {
            // Iniciar sesión exitosa, guardar datos del usuario en sesión
            $_SESSION['usuario_id'] = $resultado_inicio_sesion['id'];
            $_SESSION['username'] = $resultado_inicio_sesion['username'];
            $_SESSION['monedas'] = $resultado_inicio_sesion['monedas'];
            $_SESSION['ban'] = $resultado_inicio_sesion['ban'];
            header("Location: index.php?page=monedas"); // Redirige a la página de monedas
            exit(); // Importante: Detener la ejecución del script después de la redirección
        } else {
            // Error al iniciar sesión
            $_SESSION['login_error'] = "Credenciales inválidas. Por favor, inténtelo de nuevo.";
            header("Location: index.php?page=login"); // Redirige de nuevo al formulario de login
            exit();
        }
    }
?>
