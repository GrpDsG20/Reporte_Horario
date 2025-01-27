<?php
session_start();

// Verifica si la sesión del usuario está activa y si el rol es 'administrador'
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit;
}

// Obtener los datos del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];  // Nombre del usuario
$codigoUsuario = $_SESSION['codigo'];  // Código de trabajador

require 'conexion.php';

// Obtener todos los usuarios
$result = $conn->query("SELECT * FROM usuarios");

// Función para generar el código de trabajador
function generarCodigo($nombre, $apellidos)
{
    // Se separan los apellidos en palabras
    $apellidosArray = explode(" ", $apellidos);

    // Tomamos la inicial del primer nombre
    $codigo = strtoupper(substr($nombre, 0, 1));

    // Tomamos la inicial del primer apellido
    $codigo .= strtoupper(substr($apellidosArray[0], 0, 1));

    // Si existe un segundo apellido, agregar su inicial
    if (isset($apellidosArray[1])) {
        $codigo .= strtoupper(substr($apellidosArray[1], 0, 1));
    }

    return $codigo;
}

// Verifica si se ha enviado el formulario de registro o edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    // Registro de nuevo usuario o actualización de usuario existente
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos']; // Usamos el campo 'apellidos'
    $empresa = $_POST['empresa'];
    $rol = $_POST['rol'];
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $codigo = generarCodigo($nombre, $apellidos);

    // Verifica si el código de trabajador ha cambiado
    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Si el código de trabajador ha cambiado, verificar si ya existe en la base de datos
        $id = $_POST['id'];
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigo = ? AND id != ?");
        $stmt->bind_param("si", $codigo, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si el código ya existe, mostrar alerta
            echo "<script>alert('El código de trabajador ya existe. Por favor, ingresa otro código.'); window.location.href = 'registrar_usuario.php';</script>";
            exit;
        }
    } else {
        // Verificar si el código de trabajador ya existe en la base de datos para nuevo usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigo = ?");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si ya existe, mostrar alerta
            echo "<script>alert('El código de trabajador ya existe. Por favor, ingresa otro código.'); window.location.href = 'registrar_usuario.php';</script>";
            exit;
        }
    }

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Actualizar usuario
        $id = $_POST['id'];
        if ($password) {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido=?, codigo=?, rol=?, empresa=?, password=? WHERE id=?");
            $stmt->bind_param("ssssssi", $nombre, $apellidos, $codigo, $rol, $empresa, $password, $id);
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido=?, codigo=?, rol=?, empresa=? WHERE id=?");
            $stmt->bind_param("sssssi", $nombre, $apellidos, $codigo, $rol, $empresa, $id);
        }
        $stmt->execute();
        echo "<script>alert('Usuario actualizado con éxito'); window.location.href = 'registrar_usuario.php';</script>";
    } else {
        // Registrar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, codigo, rol, empresa, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellidos, $codigo, $rol, $empresa, $password);
        $stmt->execute();
        // Si el registro fue exitoso, mostrar el modal
        echo "<script>mostrarModal('Usuario creado con éxito'); window.location.href = 'registrar_usuario.php';</script>";
    }

    $conn->close();
}


// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Usuario eliminado con éxito'); window.location.href = 'registrar_usuario.php';</script>";
    exit;
}

// Si se pasa un ID por GET, cargar los datos del usuario para editar
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Registrar Usuario</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }


        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #000;
            color: #f4f4f9;
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        header .logo {
            width: 400px;
            color: #fff;
            font-size: 1.2rem;

        }

        header .logo:focus {

            outline: none;
            /* Evita el contorno predeterminado */

        }

        .fa-solid {
            padding-left: 10px;
        }

        .user-info {
            text-align: right;
            width: 400px;
        }

        .user-info p {
            margin: 5px 0;

        }

        .panel {
            margin: auto;
            text-align: center;
        }

        .panel h3 {
            font-size: 0.9rem;
            font-weight: 300;
        }

        .logout-btn {
            color: #f4f4f9;
            padding: 10px;
            border: none;
            font-size: 1.2rem;
            text-align: center;
            cursor: pointer;
        }

        .logout-btn:focus {
            outline: none;
        }

        .user-table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        .user-table th,
        .user-table td {
            padding: 10px 10px;
            text-align: center;
            border: 1.2px solid #150e18;
        }

        .user-table th {
            background-color: #c4c4cc;
            color: #150e18;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 10px;
        }

        .container {
            width: 95%;
            margin: auto;
            padding: 20px 0;
            /* Espacio interno para que no se pegue a los bordes */
            box-sizing: border-box;
            /* Evita que el padding afecte el tamaño total */
        }

        .divs {
            flex: 1 1 300px;
            /* Se ajusta al ancho disponible, mínimo 300px antes de bajar */
            display: flex;
            flex-direction: column;


        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            padding: 20px 0;

        }

        .divs label {
            display: block;
            margin-bottom: 5px;
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            font-size: 0.8rem;

        }

        form input,
        form select,
        form button {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 16px;
            padding: 10px;
            box-sizing: border-box;
            /* Mantiene el tamaño correcto con padding */
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            outline: none;
            font-size: 0.8rem;
        }

        .divs_btn {
            flex: 1 140px;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: flex-end;

        }

        form button {
            background-color: #c4c4cc;
            border: 1px solid #150e18;
            cursor: pointer;
            width: auto;
            padding: 10px 40px;
        }

        form button:hover {
            transform: scale(1.04);
            transition: transform 0.3s ease-in-out
        }


        .actions a {
            padding: 8px 20px;
            text-align: center;
            cursor: pointer;
            background-color: #c4c4cc;
            color: #000;
            text-decoration: none;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            border: 1px solid #150e18;
            transition: all 0.3s ease-in-out;
            display: inline-block;
            transition: transform 0.3s ease-in-out;
        }

        .actions a:hover {
            transform: scale(1.03);
        }

        .actions {

            width: 220px;
        }

        @media (max-width: 1100px) {
            form button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>

        <a href="javascript:history.back()" class="logo"><i class="fa-solid fa-arrow-left"></i></a>

        <div class="panel">
            <h3>Registrar Usuario</h3>
        </div>
        <div class="user-info">
            <p>Bienvenido, <?php echo $nombreUsuario; ?><a href="logout.php" class="logout-btn">
                    <i class="fas fa-door-open"></i>
                </a></p>
        </div>
    </header>
    <div class="container">
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id'] ?? ''; ?>">

            <div class="divs">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre'] ?? ''; ?>" oninput="generarCodigoTrabajador()" placeholder="Ingresa el nombre" required>
            </div>

            <div class="divs">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario['apellido'] ?? ''; ?>" oninput="generarCodigoTrabajador()" placeholder="Ingresa los apellidos" required>
            </div>

            <div class="divs">
                <label for="codigo">Código de Trabajador:</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo $usuario['codigo'] ?? ''; ?>" placeholder="Código generado" readonly>
            </div>

            <div class="divs">
                <label for="empresa">Empresa:</label>
                <select name="empresa">
                    <option value="Hualca" <?php echo (isset($usuario) && $usuario['empresa'] == 'Hualca') ? 'selected' : ''; ?>>Hualca</option>
                    <option value="HTOP" <?php echo (isset($usuario) && $usuario['empresa'] == 'HTOP') ? 'selected' : ''; ?>>HTOP</option>
                    <option value="CFCSL" <?php echo (isset($usuario) && $usuario['empresa'] == 'CFCSL') ? 'selected' : ''; ?>>CFCSL</option>
                </select>
            </div>

            <div class="divs">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" placeholder="Ingresa la contraseña" <?php echo isset($usuario) ? '' : 'required'; ?>>
            </div>

            <div class="divs">
                <label for="rol">Rol:</label>
                <select name="rol">
                    <option value="usuario" <?php echo (isset($usuario) && $usuario['rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="administrador" <?php echo (isset($usuario) && $usuario['rol'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>

            <div class="divs_btn">
                <button type="submit" name="registrar" class="btn">
                    <?php echo isset($usuario) ? 'Actualizar Usuario' : 'Registrar Usuario'; ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de usuarios -->
    <table class="user-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Código</th>
                <th>Empresa</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['empresa']; ?></td>
                    <td><?php echo $row['rol']; ?></td>
                    <td class="actions">
                        <a href="?editar=<?php echo $row['id']; ?>">Editar</a>
                        <a href="?eliminar=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <script>
        // Función para generar el código de trabajador en tiempo real
        function generarCodigoTrabajador() {
            const nombre = document.getElementById("nombre").value;
            const apellidos = document.getElementById("apellidos").value;

            let codigo = nombre.charAt(0).toUpperCase(); // Inicial del primer nombre
            const apellidosArray = apellidos.split(" "); // Separamos los apellidos

            // Inicial del primer apellido
            codigo += apellidosArray[0].charAt(0).toUpperCase();

            // Si existe un segundo apellido, agregar su inicial
            if (apellidosArray[1]) {
                codigo += apellidosArray[1].charAt(0).toUpperCase();
            }

            document.getElementById("codigo").value = codigo;
        }
    </script>
    <br>
</body>

</html>