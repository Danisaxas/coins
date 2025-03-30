<?php
// templates/register.php
require_once('../db/system_user.php'); // Incluye el archivo de la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Registro</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $confirmar_contrasena = $_POST['confirmar_contrasena'];

            // Validaciones del lado del servidor
            if (strlen($username) < 6 || strlen($username) > 16 || !preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                echo "<p class='text-red-500 text-sm mt-2'>El nombre de usuario debe tener entre 6 y 16 caracteres y contener solo letras y números.</p>";
            } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='text-red-500 text-sm mt-2'>El correo electrónico no es válido.</p>";
            } else if (strlen($contrasena) < 6 || !preg_match('/^[A-Z]/', $contrasena) || !preg_match('/\d/', $contrasena) || !preg_match('/[^a-zA-Z\d]/', $contrasena)) {
                echo "<p class='text-red-500 text-sm mt-2'>La contraseña debe tener al menos 6 caracteres, comenzar con una letra mayúscula, contener números y signos.</p>";
            } else if ($contrasena != $confirmar_contrasena) {
                echo "<p class='text-red-500 text-sm mt-2'>Las contraseñas no coinciden.</p>";
            } else {
                // Si todas las validaciones pasan, intenta registrar al usuario
                $resultado_registro = registrarUsuario($pdo, $username, $correo, $contrasena);
                if ($resultado_registro === true) {
                    echo "<p class='text-green-500 text-sm mt-2'>Registro exitoso. Ahora puedes iniciar sesión.</p>";
                    // Iniciar sesión automáticamente después del registro
                    $user = iniciarSesion($pdo, $username, $contrasena);
                    if ($user) {
                        session_start();
                        $_SESSION['usuario_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['monedas'] = $user['monedas'];
                        $_SESSION['ban'] = $user['ban'];
                        header("Location: index.php?page=monedas");
                        exit();
                    }
                    header("Location: index.php?page=login"); // Redirige a la página de inicio de sesión
                    exit();
                } else {
                    echo "<p class='text-red-500 text-sm mt-2'>$resultado_registro</p>"; // Muestra el mensaje de error devuelto por la función
                }
            }
        }
        ?>
        <form method="post" action="index.php?page=register">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="contrasena" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="confirmar_contrasena" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirme su contraseña" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Registrarse</button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">¿Ya tienes una cuenta? <a href="index.php?page=login" class="text-blue-500 hover:text-blue-700 font-semibold">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>