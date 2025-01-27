<?php
// Incluir archivo de conexión a la base de datos
include('conexion.php');

// Verifica si se ha recibido el parámetro 'proyecto_id'
if (isset($_GET['proyecto_id'])) {
    $proyecto_id = $_GET['proyecto_id'];

    // Consulta SQL para obtener el código del proyecto
    $sql = "SELECT codigo_proyecto FROM proyectos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $proyecto_id);
    $stmt->execute();
    $stmt->bind_result($codigo);
    $stmt->fetch();

    // Devolver el código del proyecto
    echo $codigo;
} else {
    echo "No se recibió el ID del proyecto.";
}
?>
