<?php
// templates/monedas.php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?page=login");
    exit();
}
if ($_SESSION['ban'] == 1) {
    echo "Usuario Baneado";
    exit();
}

require_once('../db/system_user.php'); // Incluye el archivo de la base de datos

function canjearCodigo($pdo, $codigo, $usuario_id) {
    try {
        $pdo->beginTransaction();

        // 1. Verificar si el código existe y no ha sido usado
        $sql = "SELECT id, recompensa FROM codes WHERE codigo = :codigo AND usuario IS NULL AND usado = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $code = $stmt->fetch();

        if (!$code) {
            $pdo->rollBack();
            return "Código inválido o ya utilizado.";
        }

        // 2. Actualizar la tabla 'users' para añadir las monedas
        $recompensa = $code['recompensa'];
        $sql_update_user = "UPDATE users SET monedas = monedas + :recompensa WHERE id = :usuario_id";
        $stmt_update_user = $pdo->prepare($sql_update_user);
        $stmt_update_user->bindParam(':recompensa', $recompensa, PDO::PARAM_INT);
        $stmt_update_user->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt_update_user->execute();

        // 3. Actualizar la tabla 'codes' para marcar el código como usado
        $sql_update_code = "UPDATE codes SET usuario = :usuario_id, usado = 1 WHERE id = :code_id";
        $stmt_update_code = $pdo->prepare($sql_update_code);
        $stmt_update_code->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt_update_code->bindParam(':code_id', $code['id'], PDO::PARAM_INT);
        $stmt_update_code->execute();

        $pdo->commit();
        return $recompensa; // Devuelve la recompensa para mostrarla al usuario
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error al canjear código: " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Monedas</title>
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
        <div class="flex justify-between items-start mb-6">
            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['username'] === 'AstroOwn'): ?>
                <a href="index.php?page=shell" class="bg-blue-500/20 border border-blue-400 text-blue-300 font-semibold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 ease-in-out hover:scale-105 text-left">
                    Terminal </>
                </a>
            <?php endif; ?>
            <a href="index.php?page=logout" class="bg-red-500/20 border border-red-400 text-red-300 font-semibold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 ease-in-out hover:scale-105 text-right">Cerrar Sesión</a>
        </div>
        <h2 class="text-3xl font-semibold text-white mb-6 text-center">Sistema de Monedas</h2>
        <p class="text-gray-400 text-center mb-4">Bienvenido, <?php echo $_SESSION['username']; ?>!</p>
        <p class="text-gray-400 text-center mb-6">Tienes <strong><?php echo $_SESSION['monedas']; ?></strong> monedas.</p>

        <form method="post" action="" class="space-y-4">
            <div>
                <label for="codigo" class="block text-gray-300 text-sm font-bold mb-2">Código:</label>
                <input type="text" id="codigo" name="codigo" placeholder="Ingrese su código" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <button type="submit" id="canjear" class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out hover:scale-105">Canjear</button>
        </form>

        <div id="mensaje" class="mt-6 text-gray-400 text-center">
             <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $codigo = $_POST['codigo'];
                $usuario_id = $_SESSION['usuario_id'];
        
                $resultado_canjeo = canjearCodigo($pdo, $codigo, $usuario_id);
        
                if (is_numeric($resultado_canjeo)) {
                    $_SESSION['monedas'] += $resultado_canjeo;
                    echo "<p class='text-green-400 text-lg'>¡Código canjeado con éxito! Se han añadido $resultado_canjeo monedas.</p>";
                     echo "<script>
                        const monedasSpan = document.getElementById('monedas');
                        monedasSpan.textContent = `Monedas:  <?php echo $_SESSION['monedas']; ?>`;
                        const codigoInput = document.getElementById('codigo');
                        codigoInput.disabled = true;
                        const canjearButton = document.getElementById('canjear');
                        canjearButton.disabled = true;
                    </script>";
                } else {
                    echo "<p class='text-red-400 text-lg'>$resultado_canjeo</p>";
                }
            }
            ?>
        </div>
    </div>

    <script>
        const monedasSpan = document.getElementById("monedas");
        const codigoInput = document.getElementById("codigo");
        const canjearButton = document.getElementById("canjear");


        let monedas = <?php echo $_SESSION['monedas']; ?>;

        
    </script>
</body>
</html>
