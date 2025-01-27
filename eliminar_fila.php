<?php
// Iniciar sesión y verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.php");
    exit;
}

// Obtener el ID de la fila a eliminar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Incluir archivo de conexión
    include('conexion.php');

    // Eliminar la fila de la base de datos
    $sqlDelete = "DELETE FROM reporte_usuario WHERE id = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Fila eliminada con éxito";
    } else {
        echo "Error al eliminar la fila: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "ID no válido";
}
?>
