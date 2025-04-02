<?php
// templates/register.php
require_once(__DIR__ . '/../db/system_user.php'); // Incluye el archivo de la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            width: 24px;
            height: 24px;
            z-index: 10;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }
        .password-toggle:hover {
            opacity: 1;
        }
        .password-input {
            padding-right: 2.75rem;
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-black/20 p-8 rounded-xl shadow-lg backdrop-blur-md w-full max-w-md border border-white/10">
        <h2 class="text-3xl font-semibold text-white mb-6 text-center">Regístrate</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $confirmar_contrasena = $_POST['confirmar_contrasena'];

            // Validaciones del lado del servidor
            if (strlen($username) < 6 || strlen($username) > 16 || !preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4' role='alert'>
                        <strong class='font-bold'>Error:</strong>
                        <span class='block sm:inline'>El nombre de usuario debe tener entre 6 y 16 caracteres y contener solo letras y números.</span>
                    </div>";
            } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4' role='alert'>
                        <strong class='font-bold'>Error:</strong>
                        <span class='block sm:inline'>El correo electrónico no es válido.</span>
                    </div>";
            } else if (strlen($contrasena) < 6 || !preg_match('/^[A-Z]/', $contrasena) || !preg_match('/\d/', $contrasena) || !preg_match('/[^a-zA-Z\d]/', $contrasena)) {
                echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4' role='alert'>
                        <strong class='font-bold'>Error:</strong>
                        <span class='block sm:inline'>La contraseña debe tener al menos 6 caracteres, comenzar con una letra mayúscula, contener números y signos.</span>
                    </div>";
            } else if ($contrasena != $confirmar_contrasena) {
                echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4' role='alert'>
                        <strong class='font-bold'>Error:</strong>
                        <span class='block sm:inline'>Las contraseñas no coinciden.</span>
                    </div>";
            } else {
                // Si todas las validaciones pasan, intenta registrar al usuario
                $resultado_registro = registrarUsuario($pdo, $username, $correo, $contrasena);
                if ($resultado_registro === true) {
                    echo "<div class='bg-green-500/20 border border-green-400 text-green-300 p-4 rounded-md mb-4' role='alert'>
                            <strong class='font-bold'>Éxito:</strong>
                            <span class='block sm:inline'>Registro exitoso. Ahora puedes iniciar sesión.</span>
                        </div>";
                    header("Location: index.php?page=login"); // Redirige al usuario a la página de inicio de sesión
                    exit();
                } else {
                    echo "<p class='text-red-500 text-sm mt-2'>$resultado_registro</p>"; // Muestra el mensaje de error devuelto por la función
                }
            }
        }
        ?>
        <form method="post" action="index.php?page=register" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-300 text-sm font-bold mb-2">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <div>
                <label for="correo" class="block text-gray-300 text-sm font-bold mb-2">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <div class="password-container">
                 <label for="contrasena" class="block text-gray-300 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required class="password-input shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
                <img id="togglePassword" src="resource/hide_password.png" alt="Ocultar contraseña" class="password-toggle">
            </div>
            <div>
                <label for="confirmar_contrasena" class="block text-gray-300 text-sm font-bold mb-2">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirme su contraseña" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <button type="submit" class="bg-white text-gray-900 font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out hover:scale-105 text-lg">Registrarse</button>
        </form>
        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">¿Ya tienes una cuenta? <a href="index.php?page=login" class="text-blue-400 hover:text-blue-300 font-semibold transition duration-200 ease-in-out">Inicia sesión</a></p>
        </div>
    </div>
     <script>
        const passwordInput = document.getElementById('contrasena');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.src = "resource/show_password.png";
                togglePasswordButton.alt = "Mostrar contraseña";
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.src = "resource/hide_password.png";
                togglePasswordButton.alt = "Ocultar contraseña";
            }
        });
    </script>
</body>
</html>
