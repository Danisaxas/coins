<?php
// templates/shell.php
if (!isset($_SESSION['usuario_id']) || $_SESSION['username'] !== 'AstroOwn') {
    header("Location: index.php?page=home");
    exit();
}

require_once(__DIR__ . '/../db/system_user.php'); // Corrige la ruta al archivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $recompensa = $_POST['recompensa'];
    $creada_por = $_SESSION['username'];

    $resultado_creacion = crearCodigo($pdo, $codigo, $recompensa, $creada_por);

    if ($resultado_creacion === true) {
        echo "<div class='bg-green-500/20 border border-green-400 text-green-300 p-4 rounded-md mb-4 text-center' role='alert'>
                <strong class='font-bold'>Éxito:</strong>
                <span class='block sm:inline'>Código creado con éxito.</span>
            </div>";
    } else {
        echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4 text-center' role='alert'>
                <strong class='font-bold'>Error:</strong>
                <span class='block sm:inline'>$resultado_creacion</span>
            </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Códigos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Fondo oscuro */
            color: #e2e8f0; /* Texto claro */
            line-height: 1.5;
        }
        .container {
            max-width: 800px; /* Ancho máximo */
            margin: 0 auto; /* Centrar horizontalmente */
            padding: 2rem;
        }
        .terminal-window {
            background-color: #1e293b;
            border: 1px solid #4b5563;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
            overflow-x: auto;
            font-family: monospace;
            font-size: 1rem;
            line-height: 1.75rem;
        }
        .terminal-prompt {
            color: #6ee7b7;
            margin-right: 0.5rem;
        }
        .terminal-input {
            background-color: transparent;
            border: none;
            color: #f8fafc;
            width: 100%;
            font-family: monospace;
            font-size: 1rem;
            line-height: 1.75rem;
            outline: none;
        }
        .terminal-output {
            color: #e2e8f0;
            white-space: pre-wrap;
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #cbd5e0;
            margin-bottom: 0.5rem;
        }
        .form-input {
            background-color: #334155;
            border: 1px solid #6b7280;
            border-radius: 0.375rem;
            width: 100%;
            padding: 0.75rem;
            color: #f8fafc;
            font-size: 1rem;
            transition: border-color 0.2s ease;
            outline: none;
        }
        .form-input:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.3);
        }
        .btn-primary {
            background-image: linear-gradient(to-r, #8b5cf6, #d946ef);
            color: #f8fafc;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .btn-primary:hover {
            background-image: linear-gradient(to-r, #7c3aed, #c946e3);
            transform: scale(1.05);
        }
        .btn-secondary {
            color: #e2e8f0;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #6b7280;
            background-color: #334155;
            width: 100%;
            text-align: center;
            margin-top: 1rem;
        }
        .btn-secondary:hover{
           background-color: #4b5563;
           transform: scale(1.05);
        }

        .text-green-500 { color: #6ee7b7; }
        .text-red-500 { color: #f87171; }

        .mt-8 { margin-top: 2rem; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 1rem; }
        .font-bold { font-weight: 600; }
        .block { display: block; }
        .sm\:inline {
            display: inline;
        }
    </style>
</head>
<body class="bg-gray-900">
    <div class="container">
        <div class="terminal-window">
            <div class="terminal-prompt">AstroOwn:</div>
            <div  class="terminal-output">Administración de Códigos</div>
            <form method="post" action="index.php?page=shell" class="mt-4">
                <div class="form-group">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código (ej: CODE123)" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="recompensa" class="form-label">Recompensa:</label>
                    <input type="number" id="recompensa" name="recompensa" placeholder="Ingrese la recompensa (ej: 100)" required class="form-input">
                </div>
                <button type="submit" class="btn-primary">Crear Código</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $codigo = $_POST['codigo'];
                $recompensa = $_POST['recompensa'];
                $creada_por = $_SESSION['username'];

                $resultado_creacion = crearCodigo($pdo, $codigo, $recompensa, $creada_por);

                if ($resultado_creacion === true) {
                    echo "<div class='terminal-output text-green-500'>Código creado con éxito.</div>";
                } else {
                    echo "<div class='terminal-output text-red-500'>Error: $resultado_creacion</div>";
                }
            }
            ?>
        </div>
         <div class="text-center">
            <a href="index.php?page=monedas" class="btn-secondary">Volver a Monedas</a>
        </div>
    </div>
</body>
</html>
