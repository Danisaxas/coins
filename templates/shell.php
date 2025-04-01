<?php
// templates/shell.php
if (!isset($_SESSION['usuario_id']) || $_SESSION['username'] !== 'AstroOwn') {
    header("Location: index.php?page=home");
    exit();
}

require_once(__DIR__ . '/../db/system_user.php'); // Corrige la ruta al archivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comando = $_POST['comando'];
    $respuesta = ejecutarComando($pdo, $comando);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
            line-height: 1.75;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .terminal-window {
            background-color: #1e293b;
            border: 2px solid #4b5563;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
            overflow-x: auto;
            font-family: monospace;
            font-size: 1rem;
            line-height: 1.75rem;
            display: flex;
            flex-direction: column;
            min-height: 100px;
            height: auto;
        }
        .terminal-prompt {
            color: #6ee7b7;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        .terminal-input-container{
            display: flex;
            align-items: center;
            border-radius: 1rem;
            background-color: #0f172a;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border: 2px solid #6b7280;
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
            flex-grow: 1;
        }
        .terminal-input:focus{
            outline: none;
        }
        .terminal-output {
            color: #e2e8f0;
            white-space: pre-wrap;
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 0;
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
                    
                    <div class="terminal-input-container">
                         <span class="terminal-prompt"> > </span>
                         <input type="text" id="comando" name="comando" placeholder="Ingrese el comando (ej: coins 100 CODIGO)" required class="terminal-input">
                    </div>
                   
                </div>
               
            </form>
            <?php if (isset($respuesta)): ?>
                <div class="terminal-output"><?php echo htmlspecialchars($respuesta); ?></div>
            <?php endif; ?>
        </div>
         <div class="text-center">
            <a href="index.php?page=monedas" class="btn-secondary">Volver a Monedas</a>
        </div>
    </div>
</body>
</html>
