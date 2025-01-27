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

// Incluir el archivo de conexión
include('conexion.php');

// Función para generar el código del proyecto con las iniciales (si decides volver a usarla)
function generarCodigoProyecto($nombreProyecto)
{
    $palabras = explode(" ", $nombreProyecto);
    $codigo = '';
    foreach ($palabras as $palabra) {
        $codigo .= strtoupper(substr($palabra, 0, 1)); // Obtener la primera letra de cada palabra
    }
    return $codigo;
}

// Manejar el formulario de registro y edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {  // Si estamos editando un proyecto
        $idProyecto = $_POST['id'];
        $nombreProyecto = $_POST['nombre_proyecto'];
        $codigoProyecto = $_POST['codigo_proyecto']; // Obtener el código del formulario (ya no se genera automáticamente)

        // Actualizar el proyecto en la base de datos
        $sql = "UPDATE proyectos SET nombre_proyecto = '$nombreProyecto', codigo_proyecto = '$codigoProyecto' WHERE id = $idProyecto";
        if ($conn->query($sql) === TRUE) {
            echo "Proyecto actualizado exitosamente";
            header("Location: registrar_proyecto.php");
            exit();
        } else {
            echo "Error al actualizar el proyecto: " . $conn->error;
        }
    } else {  // Si estamos registrando un nuevo proyecto
        $nombreProyecto = $_POST['nombre_proyecto'];
        $codigoProyecto = $_POST['codigo_proyecto']; // Obtener el código del formulario (ya no se genera automáticamente)

        // Insertar el proyecto en la base de datos
        $sql = "INSERT INTO proyectos (nombre_proyecto, codigo_proyecto) VALUES ('$nombreProyecto', '$codigoProyecto')";
        if ($conn->query($sql) === TRUE) {
            echo "Proyecto registrado exitosamente";
            header("Location: registrar_proyecto.php");
            exit();
        } else {
            echo "Error al registrar el proyecto: " . $conn->error;
        }
    }
}

// Manejar la edición de un proyecto
if (isset($_GET['editar'])) {
    $idProyecto = $_GET['editar'];

    // Obtener los datos del proyecto a editar
    $sql = "SELECT * FROM proyectos WHERE id = $idProyecto";
    $result = $conn->query($sql);
    $proyecto = $result->fetch_assoc();
}

// Manejar la eliminación de un proyecto
if (isset($_GET['eliminar'])) {
    $idProyecto = $_GET['eliminar'];

    // Verificar si el proyecto está siendo utilizado en la tabla reporte_usuario
    $sqlVerificarUso = "SELECT COUNT(*) AS count FROM reporte_usuario WHERE proyecto_id = $idProyecto";
    $resultVerificarUso = $conn->query($sqlVerificarUso);
    $row = $resultVerificarUso->fetch_assoc();

    if ($row['count'] > 0) {
        // El proyecto está en uso, mostrar un mensaje de error
        echo "<script>alert('Este proyecto está en uso por uno o más usuarios y no se puede eliminar.');</script>";
        echo "<script>window.location.href = 'registrar_proyecto.php';</script>";
    } else {
        // El proyecto no está en uso, proceder a eliminarlo
        $sql = "DELETE FROM proyectos WHERE id = $idProyecto";
        if ($conn->query($sql) === TRUE) {
            echo "Proyecto eliminado exitosamente";
            header("Location: registrar_proyecto.php");
            exit();
        } else {
            echo "Error al eliminar el proyecto: " . $conn->error;
        }
    }
}


// Obtener todos los proyectos para mostrarlos
$sql = "SELECT * FROM proyectos";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $proyectos = [];
} else {
    $proyectos = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Registrar Proyecto</title>
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







        .container {
            padding: 30px;
            border-radius: 5px;
            width: 95%;
            text-align: center;
            margin: auto;
        }

        .back-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 20px;
            background-color: #2196F3;
            color: white;
            padding: 10px;
            border-radius: 50%;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #1976D2;
        }

        h2 {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .form-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 20px;



        }

        .form-container .inputs {
            padding: 10px;
            width: 250px;
            font-size: 0.8rem;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            border-radius: 0.5rem;
            box-sizing: border-box;
            font-weight: 300;
        }


        .form-container input[type="text"]:focus {
            outline: none;

        }

        .btn {
            background-color: #c4c4cc;
            color: #000;
            padding: 10px 50px;
            text-decoration: none;
            border-radius: 0.5rem;
            width: auto;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            border: 1px solid #150e18;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .btn:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease-in-out
        }

        table {

            border-collapse: collapse;
            text-align: left;
            width: 100%;
            margin: auto;
            margin-top: 30px;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }

        table,
        th,
        td {
            padding: 8px 10px;
            border: 1.2px solid #150e18;
        }

        th,
        td {
            padding: 8px;
        }

        th {
            background-color: #c4c4cc;
            color: #150e18;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 10px;
        }

        td {
            background-color: #f9f9f9;
        }

        .actions button {
            padding: 8px 40px;
            text-align: center;
            cursor: pointer;
            background-color: #c4c4cc;
            color: #000;
            text-decoration: none;
            border-radius: 0.5rem;
            width: auto;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            border: 1px solid #150e18;
            transition: all 0.3s ease-in-out;
        }

        .actions button:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease-in-out
        }

        .actions {

            width: 300px;
        }
    </style>
</head>

<body>
    <header>
        <a href="javascript:history.back()" class="logo"><i class="fa-solid fa-arrow-left"></i></a>

        <div class="panel">
            <h3>Registrar Proyecto</h3>
        </div>
        <div class="user-info">
            <p>Bienvenido, <?php echo $nombreUsuario; ?><a href="logout.php" class="logout-btn">
                    <i class="fas fa-door-open"></i>
                </a></p>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <form action="registrar_proyecto.php" method="POST">
                <input class="inputs" type="text" name="nombre_proyecto" id="nombre_proyecto" required placeholder="Nombre del Proyecto" value="<?php echo isset($proyecto) ? $proyecto['nombre_proyecto'] : ''; ?>">
                <input class="inputs" type="text" name="codigo_proyecto" id="codigo_proyecto" required placeholder="Código del Proyecto" value="<?php echo isset($proyecto) ? $proyecto['codigo_proyecto'] : ''; ?>">
                <input type="submit" value="<?php echo isset($proyecto) ? 'Actualizar Proyecto' : 'Registrar Proyecto'; ?>" class="btn">
                <?php if (isset($proyecto)): ?>
                    <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
                <?php endif; ?>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Proyecto</th>
                    <th>Código</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar todos los proyectos si existen
                if (empty($proyectos)) {
                    echo "<tr><td colspan='3'>No hay proyectos registrados.</td></tr>";
                } else {
                    foreach ($proyectos as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre_proyecto'] . "</td>";
                        echo "<td>" . $row['codigo_proyecto'] . "</td>";
                        echo "<td class='actions'>
                            <a href='registrar_proyecto.php?editar=" . $row['id'] . "'><button>Editar</button></a>
                            <a href='registrar_proyecto.php?eliminar=" . $row['id'] . "'><button>Eliminar</button></a>
                          </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>