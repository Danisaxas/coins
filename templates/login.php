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
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-black">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Inicio de Sesión</h2>
        <?php
        session_start(); // Asegurar que la sesión está iniciada
        if (isset($_SESSION['login_error'])) {
            echo "<p class='text-red-500 text-sm mt-2'>".$_SESSION['login_error']."</p>";
            unset($_SESSION['login_error']); // Limpia el error después de mostrarlo
        }
        ?>
        <form method="post" action="">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="contrasena" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Iniciar Sesión</button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">¿No tienes una cuenta? <a href="index.php?page=register" class="text-blue-500 hover:text-blue-700 font-semibold">Regístrate</a></p>
        </div>
    </div>
</body>
</html>
<?php
    require_once('../db/system_user.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $contrasena = $_POST['contrasena'];
        $resultado_inicio_sesion = iniciarSesion($pdo, $username, $contrasena);
        if ($resultado_inicio_sesion) {
            // Iniciar sesión exitosa, guardar datos del usuario en sesión
            $_SESSION['usuario_id'] = $resultado_inicio_sesion['id'];
            $_SESSION['username'] = $resultado_inicio_sesion['username'];
            $_SESSION['monedas'] = $resultado_inicio_sesion['monedas'];
            $_SESSION['ban'] = $resultado_inicio_sesion['ban'];
            header("Location: index.php?page=monedas");
            exit();
        } else {
            $_SESSION['login_error'] = "Credenciales inválidas. Por favor, intenta de nuevo.";
            header("Location: index.php?page=login");
            exit();
        }
    }
?>
