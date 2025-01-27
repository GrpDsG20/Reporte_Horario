<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión

require 'conexion.php';

function obtenerNombreMes($mes) {
    $meses = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    ];
    
    return $meses[$mes] ?? 'Mes no válido'; // Si no encuentra el mes, devuelve 'Mes no válido'
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del usuario desde la sesión
    $nombreUsuario = $_SESSION['nombre'];  // Nombre del usuario
    $codigoUsuario = $_SESSION['codigo'];  // Código de trabajador

    $mes = $_POST['mes'];
    $anio = $_POST['anio'];

    // Verificar si el usuario seleccionó un mes y subió una imagen
    if (empty($mes) || empty($anio) || empty($_FILES['imagen']['name'])) {
        header("Location: user.php?error=2"); // Error 2: Datos obligatorios faltantes
        exit;
    }

    // Verificar si ya existe un reporte para el mes, año, usuario_sesion y codigo_usuario
    $sqlVerificacion = "SELECT * FROM reportes WHERE mes = ? AND anio = ? AND usuario_sesion = ? AND codigo_usuario = ?";
    $stmtVerificacion = $conn->prepare($sqlVerificacion);
    $stmtVerificacion->bind_param("siss", $mes, $anio, $nombreUsuario, $codigoUsuario); // Corregir los tipos: s = string, i = integer
    $stmtVerificacion->execute();
    $result = $stmtVerificacion->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe un reporte, redirige con el mes convertido en nombre
        $nombreMes = obtenerNombreMes($mes);
        header("Location: user.php?error=1&mes=$nombreMes"); 
        exit;
    }

    // Manejo de la subida de imagen
    $directorio = "uploads/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
    $rutaImagen = $directorio . $nombreImagen;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        header("Location: user.php?error=3"); // Error 3: Problema al subir la imagen
        exit;
    }

    // Insertar los datos en la tabla reportes, incluyendo los campos de usuario y código
    foreach ($_POST['proyecto'] as $key => $proyecto) {
        $codigo = $_POST['codigo'][$key];
        $horas = $_POST['horas'][$key];
        $porcentaje100 = $_POST['porcentaje100'][$key];
        $porcentaje = $_POST['porcentaje'][$key];

        $sql = "INSERT INTO reportes (nombre_proyecto, codigo_proyecto, horas_efectivas, porcentaje_100, porcentaje, mes, anio, imagen, usuario_sesion, codigo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssddisssss", $proyecto, $codigo, $horas, $porcentaje100, $porcentaje, $mes, $anio, $nombreImagen, $nombreUsuario, $codigoUsuario);
        
        if (!$stmt->execute()) {
            header("Location: user.php?error=4"); // Error 4: Problema al guardar en la BD
            exit;
        }
    }

    // Redirige con éxito, también pasando el nombre del mes
    $nombreMes = obtenerNombreMes($mes);
    header("Location: user.php?success=1&mes=$nombreMes"); 
    exit;
}
?>
