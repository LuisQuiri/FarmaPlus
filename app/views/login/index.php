<?php
$config = require __DIR__ . '/../../../config/app.php';
$baseUrl = rtrim($config['base_url'], '/') . '/';
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - FarmaPlus</title>
    <link rel="stylesheet" href="<?= $baseUrl ?>public/assets/css/style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef5f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-contenedor {
            width: 380px;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .login-contenedor h1 {
            margin-bottom: 10px;
            text-align: center;
            color: #0f766e;
        }

        .login-contenedor p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .login-grupo {
            margin-bottom: 18px;
        }

        .login-grupo label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        .login-grupo input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #0f766e;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #115e59;
        }

        .login-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-contenedor">
        <h1>FarmaPlus</h1>
        <p>Ingrese sus credenciales</p>

        <?php if ($error): ?>
            <div class="login-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= $baseUrl ?>login/autenticar" method="POST">
            <div class="login-grupo">
                <label for="usuario">Usuario o correo</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <div class="login-grupo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Ingresar</button>
        </form>
    </div>

</body>
</html>