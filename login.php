<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];  // Código de trabajador
    $password = $_POST['password']; // Contraseña

    // Consulta para validar las credenciales
    $query = "SELECT * FROM usuarios WHERE codigo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuarioData = $result->fetch_assoc();

        if (password_verify($password, $usuarioData['password'])) {
            $_SESSION['user_id'] = $usuarioData['id'];
            $_SESSION['nombre'] = $usuarioData['nombre'];
            $_SESSION['codigo'] = $usuarioData['codigo'];
            $_SESSION['rol'] = $usuarioData['rol'];

            if ($_SESSION['rol'] == 'administrador') {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit;
        } else {
            $error = "Código de trabajador o contraseña incorrectos.";
        }
    } else {
        $error = "Código de trabajador o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pasión del Inka</title>
    <link rel="icon" type="image/png" href="logo.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 70%;
            max-width: 350px;
            height: 350px;
            text-align: center;
        }

        .login-container h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #222;
        }

        .login-container .subtitle {
            font-size: 0.9rem;
            margin-bottom: 30px;
            color: #666;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
            color: #333;
            outline: none;
            box-sizing: border-box;
        }

        .input-group .icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            font-size: 22px;
            color: #888;
        }

        .login-container button {
            width: 100%;
            background-color: #000;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #333;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>HUALCA</h1>
        <p class="subtitle">Bienvenido, por favor inicia sesión</p>
        <form action="login.php" method="POST">
            <div class="input-group">
                <i class='bx bx-user icon'></i>
                <input type="text" name="codigo" placeholder="Código de Trabajador" required>
            </div>
            <div class="input-group">
                <i class='bx bx-lock-alt icon'></i>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>

</html>
