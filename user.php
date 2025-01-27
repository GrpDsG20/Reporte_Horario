<?php
session_start();

// Verifica si la sesión del usuario está activa y si el rol es 'usuario'
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.php");
    exit;
}

// Obtener los datos del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];  // Nombre del usuario
$codigoUsuario = $_SESSION['codigo'];  // Código de trabajador

// Incluir el archivo de conexión
include('conexion.php');

// Consultar los proyectos de la base de datos
$sql = "SELECT * FROM proyectos";
$result = $conn->query($sql);
$proyectos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $proyectos[] = $row;
    }
} else {
    $proyectos = [];
}

// Preparar la consulta
$sqlReporte = "SELECT reporte_usuario.*, proyectos.nombre_proyecto 
               FROM reporte_usuario 
               INNER JOIN proyectos ON reporte_usuario.proyecto_id = proyectos.id 
               WHERE reporte_usuario.usuario = ? 
               ORDER BY reporte_usuario.fecha_creacion ASC";

$stmt = $conn->prepare($sqlReporte);
$stmt->bind_param("s", $nombreUsuario);  // 's' indica que el parámetro es una cadena
$stmt->execute();

$resultReporte = $stmt->get_result();
$reportes = [];
if ($resultReporte->num_rows > 0) {
    while ($row = $resultReporte->fetch_assoc()) {
        $reportes[] = $row;
    }
} else {
    $reportes = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proyecto_id = $_POST['proyecto_id'];
    $codigo_proyecto = $_POST['codigo_proyecto'];
    $dia_1 = $_POST['dia_1'];
    $dia_2 = $_POST['dia_2'];
    $dia_3 = $_POST['dia_3'];
    $dia_4 = $_POST['dia_4'];
    $dia_5 = $_POST['dia_5'];
    $dia_6 = $_POST['dia_6'];
    $dia_7 = $_POST['dia_7'];
    $dia_8 = $_POST['dia_8'];
    $dia_9 = $_POST['dia_9'];
    $dia_10 = $_POST['dia_10'];
    $dia_11 = $_POST['dia_11'];
    $dia_12 = $_POST['dia_12'];
    $dia_13 = $_POST['dia_13'];
    $dia_14 = $_POST['dia_14'];
    $dia_15 = $_POST['dia_15'];
    $dia_16 = $_POST['dia_16'];
    $dia_17 = $_POST['dia_17'];
    $dia_18 = $_POST['dia_18'];
    $dia_19 = $_POST['dia_19'];
    $dia_20 = $_POST['dia_20'];
    $dia_21 = $_POST['dia_21'];
    $dia_22 = $_POST['dia_22'];
    $dia_23 = $_POST['dia_23'];
    $dia_24 = $_POST['dia_24'];
    $dia_25 = $_POST['dia_25'];
    $dia_26 = $_POST['dia_26'];
    $dia_27 = $_POST['dia_27'];
    $dia_28 = $_POST['dia_28'];
    $dia_29 = $_POST['dia_29'];
    $dia_30 = $_POST['dia_30'];
    $dia_31 = $_POST['dia_31'];

    // Iterar sobre los proyectos seleccionados
    for ($i = 0; $i < count($proyecto_id); $i++) {
        if (!empty($proyecto_id[$i])) {
            $sqlCheck = "SELECT * FROM reporte_usuario 
                     WHERE proyecto_id = '" . $proyecto_id[$i] . "' 
                     AND codigo_proyecto = '" . $codigo_proyecto[$i] . "'";

            $resultCheck = $conn->query($sqlCheck);

            if ($resultCheck->num_rows > 0) {
                $sqlUpdate = "UPDATE reporte_usuario 
            SET dia_1 = '" . $dia_1[$i] . "', 
                dia_2 = '" . $dia_2[$i] . "', 
                dia_3 = '" . $dia_3[$i] . "', 
                dia_4 = '" . $dia_4[$i] . "', 
                dia_5 = '" . $dia_5[$i] . "', 
                dia_6 = '" . $dia_6[$i] . "', 
                dia_7 = '" . $dia_7[$i] . "', 
                dia_8 = '" . $dia_8[$i] . "', 
                dia_9 = '" . $dia_9[$i] . "', 
                dia_10 = '" . $dia_10[$i] . "', 
                dia_11 = '" . $dia_11[$i] . "', 
                dia_12 = '" . $dia_12[$i] . "', 
                dia_13 = '" . $dia_13[$i] . "', 
                dia_14 = '" . $dia_14[$i] . "', 
                dia_15 = '" . $dia_15[$i] . "', 
                dia_16 = '" . $dia_16[$i] . "', 
                dia_17 = '" . $dia_17[$i] . "', 
                dia_18 = '" . $dia_18[$i] . "', 
                dia_19 = '" . $dia_19[$i] . "', 
                dia_20 = '" . $dia_20[$i] . "', 
                dia_21 = '" . $dia_21[$i] . "', 
                dia_22 = '" . $dia_22[$i] . "', 
                dia_23 = '" . $dia_23[$i] . "', 
                dia_24 = '" . $dia_24[$i] . "', 
                dia_25 = '" . $dia_25[$i] . "', 
                dia_26 = '" . $dia_26[$i] . "', 
                dia_27 = '" . $dia_27[$i] . "', 
                dia_28 = '" . $dia_28[$i] . "', 
                dia_29 = '" . $dia_29[$i] . "', 
                dia_30 = '" . $dia_30[$i] . "', 
                dia_31 = '" . $dia_31[$i] . "', 
                fecha_creacion = NOW(),
                usuario = '" . $nombreUsuario . "', 
                codigo_usuario = '" . $codigoUsuario . "' 
            WHERE proyecto_id = '" . $proyecto_id[$i] . "' 
            AND codigo_proyecto = '" . $codigo_proyecto[$i] . "'";

                // Ejecutar la consulta de actualización
                $conn->query($sqlUpdate);

                // Informar al usuario que el proyecto fue actualizado
                echo "<script>alert('El proyecto ha sido actualizado.');</script>";
            } else {
                // Si el proyecto no existe, insertamos una nueva fila
                $sqlInsert = "INSERT INTO reporte_usuario (proyecto_id, codigo_proyecto, dia_1, dia_2, dia_3, dia_4, dia_5, dia_6, dia_7, dia_8, dia_9, dia_10, dia_11, dia_12, dia_13, dia_14, dia_15, dia_16, dia_17, dia_18, dia_19, dia_20, dia_21, dia_22, dia_23, dia_24, dia_25, dia_26, dia_27, dia_28, dia_29, dia_30, dia_31, fecha_creacion, usuario, codigo_usuario) 
            VALUES ('" . $proyecto_id[$i] . "', '" . $codigo_proyecto[$i] . "', 
                    '" . $dia_1[$i] . "', '" . $dia_2[$i] . "', '" . $dia_3[$i] . "', '" . $dia_4[$i] . "', '" . $dia_5[$i] . "', '" . $dia_6[$i] . "', '" . $dia_7[$i] . "', '" . $dia_8[$i] . "', '" . $dia_9[$i] . "', '" . $dia_10[$i] . "', '" . $dia_11[$i] . "', '" . $dia_12[$i] . "', '" . $dia_13[$i] . "', '" . $dia_14[$i] . "', '" . $dia_15[$i] . "', '" . $dia_16[$i] . "', '" . $dia_17[$i] . "', '" . $dia_18[$i] . "', '" . $dia_19[$i] . "', '" . $dia_20[$i] . "', '" . $dia_21[$i] . "', '" . $dia_22[$i] . "', '" . $dia_23[$i] . "', '" . $dia_24[$i] . "', '" . $dia_25[$i] . "', '" . $dia_26[$i] . "', '" . $dia_27[$i] . "', '" . $dia_28[$i] . "', '" . $dia_29[$i] . "', '" . $dia_30[$i] . "', '" . $dia_31[$i] . "', NOW(), '" . $nombreUsuario . "', '" . $codigoUsuario . "')";

                // Ejecutar la consulta de inserción
                $conn->query($sqlInsert);
            }
        }
    }

    // Redirigir para evitar el reenvío del formulario
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
function getColorClass($valor)
{
    switch (strtoupper($valor)) {
        case 'G':
            return 'G'; // Clase para el color G
        case 'C':
            return 'C'; // Clase para el color C
        case 'B':
            return 'B'; // Clase para el color B
        case 'V':
            return 'V'; // Clase para el color V
        default:
            return ''; // Sin clase si no es una de las letras
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Reporte Mensual de Usuario por Proyecto</title>
    <link rel="stylesheet" type="text/css" href="user.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <div class="panel">
            <h3>Reporte Mensual de Usuario por Proyecto</h3>
        </div>
        <div class="user-info">
            <p>Bienvenido, <?php echo $nombreUsuario; ?><a href="logout.php" class="logout-btn">
                    <i class="fas fa-door-open"></i>
                </a></p>
        </div>
    </header>

    <div class="reporte-contenedor">
        <div class="container-columns">
            <div class="column">
                <h3>Fila "Lugar de trabajo"</h3>
                <ul>
                    <li>- Completar según leyenda.</li>
                    <li>- Se recomienda colocar una X si no se laboró sábado ni/o domingo.</li>
                    <li>- En caso de haber estado en campo e igual trabajó en gabinete para otro proyecto, colocar "C" y las hrs. en la fila de cada proyecto.</li>
                </ul>
            </div>
            <div class="column">
                <h3>Filas de proyectos</h3>
                <ul>
                    <li>- Colocar la cantidad de horas laboradas por proyecto cada día.</li>
                    <li>- Si estaba de bajada/vacaciones, colocar V/B y la cantidad de horas trabajadas según proyecto y día que corresponda.</li>
                </ul>
            </div>
            <div class="column">
                <h3>Leyenda</h3>
                <ul>
                    <table class="custom-table">
                        <tr>
                            <td class="G">G</td>
                            <td>Gabinete</td>
                            <td class="V">V</td>
                            <td>Vacaciones</td>
                        </tr>
                        <tr>
                            <td class="C">C</td>
                            <td>Campo</td>
                            <td class="B">B</td>
                            <td>Bajadas</td>
                        </tr>
                    </table>
                    <ul>
            </div>
        </div>
    </div>

    <form id="formReporte" method="POST" action="">
        <button type="button" id="imprimirBtn" onclick="descargarImagen()">Descargar Tabla</button>
        <button type="submit" id="guardarBtn">Actualizar</button>

        <div class="scroll-container">
            <table id="tablaProyectos">
                <thead>
                    <tr>
                        <th rowspan="2">Proyecto</th>
                        <th rowspan="2">Código</th>
                        <th colspan="31">Días</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>17</th>
                        <th>18</th>
                        <th>19</th>
                        <th>20</th>
                        <th>21</th>
                        <th>22</th>
                        <th>23</th>
                        <th>24</th>
                        <th>25</th>
                        <th>26</th>
                        <th>27</th>
                        <th>28</th>
                        <th>29</th>
                        <th>30</th>
                        <th>31</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contar los reportes para saber si se deben agregar más filas
                    $cantidadReportes = count($reportes);

                    // Mostrar los datos guardados en el formulario
                    foreach ($reportes as $reporte):
                    ?>
                        <tr data-id="<?php echo $reporte['id']; ?>" class="fila-proyecto">

                            <td>
                                <select name="proyecto_id[]" class="proyectoSelect" onchange="actualizarCodigo(this)" required>
                                    <option value="">Seleccionar Proyecto</option>
                                    <?php foreach ($proyectos as $proyecto): ?>
                                        <option value="<?php echo $proyecto['id']; ?>" data-codigo="<?php echo $proyecto['codigo_proyecto']; ?>"
                                            <?php if ($proyecto['id'] == $reporte['proyecto_id']) echo 'selected'; ?>>
                                            <?php echo $proyecto['nombre_proyecto']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="codigo_proyecto[]" class="codigoProducto" value="<?php echo $reporte['codigo_proyecto']; ?>" readonly></td>
                            <td><input type="text" name="dia_1[]" class="dia_1 <?php echo getColorClass($reporte['dia_1']); ?>" value="<?php echo htmlspecialchars($reporte['dia_1']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_2[]" class="dia_2 <?php echo getColorClass($reporte['dia_2']); ?>" value="<?php echo htmlspecialchars($reporte['dia_2']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_3[]" class="dia_3 <?php echo getColorClass($reporte['dia_3']); ?>" value="<?php echo htmlspecialchars($reporte['dia_3']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_4[]" class="dia_4 <?php echo getColorClass($reporte['dia_4']); ?>" value="<?php echo htmlspecialchars($reporte['dia_4']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_5[]" class="dia_5 <?php echo getColorClass($reporte['dia_5']); ?>" value="<?php echo htmlspecialchars($reporte['dia_5']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_6[]" class="dia_6 <?php echo getColorClass($reporte['dia_6']); ?>" value="<?php echo htmlspecialchars($reporte['dia_6']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_7[]" class="dia_7 <?php echo getColorClass($reporte['dia_7']); ?>" value="<?php echo htmlspecialchars($reporte['dia_7']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_8[]" class="dia_8 <?php echo getColorClass($reporte['dia_8']); ?>" value="<?php echo htmlspecialchars($reporte['dia_8']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_9[]" class="dia_9 <?php echo getColorClass($reporte['dia_9']); ?>" value="<?php echo htmlspecialchars($reporte['dia_9']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_10[]" class="dia_10 <?php echo getColorClass($reporte['dia_10']); ?>" value="<?php echo htmlspecialchars($reporte['dia_10']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_11[]" class="dia_11 <?php echo getColorClass($reporte['dia_11']); ?>" value="<?php echo htmlspecialchars($reporte['dia_11']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_12[]" class="dia_12 <?php echo getColorClass($reporte['dia_12']); ?>" value="<?php echo htmlspecialchars($reporte['dia_12']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_13[]" class="dia_13 <?php echo getColorClass($reporte['dia_13']); ?>" value="<?php echo htmlspecialchars($reporte['dia_13']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_14[]" class="dia_14 <?php echo getColorClass($reporte['dia_14']); ?>" value="<?php echo htmlspecialchars($reporte['dia_14']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_15[]" class="dia_15 <?php echo getColorClass($reporte['dia_15']); ?>" value="<?php echo htmlspecialchars($reporte['dia_15']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_16[]" class="dia_16 <?php echo getColorClass($reporte['dia_16']); ?>" value="<?php echo htmlspecialchars($reporte['dia_16']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_17[]" class="dia_17 <?php echo getColorClass($reporte['dia_17']); ?>" value="<?php echo htmlspecialchars($reporte['dia_17']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_18[]" class="dia_18 <?php echo getColorClass($reporte['dia_18']); ?>" value="<?php echo htmlspecialchars($reporte['dia_18']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_19[]" class="dia_19 <?php echo getColorClass($reporte['dia_19']); ?>" value="<?php echo htmlspecialchars($reporte['dia_19']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_20[]" class="dia_20 <?php echo getColorClass($reporte['dia_20']); ?>" value="<?php echo htmlspecialchars($reporte['dia_20']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_21[]" class="dia_21 <?php echo getColorClass($reporte['dia_21']); ?>" value="<?php echo htmlspecialchars($reporte['dia_21']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_22[]" class="dia_22 <?php echo getColorClass($reporte['dia_22']); ?>" value="<?php echo htmlspecialchars($reporte['dia_22']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_23[]" class="dia_23 <?php echo getColorClass($reporte['dia_23']); ?>" value="<?php echo htmlspecialchars($reporte['dia_23']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_24[]" class="dia_24 <?php echo getColorClass($reporte['dia_24']); ?>" value="<?php echo htmlspecialchars($reporte['dia_24']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_25[]" class="dia_25 <?php echo getColorClass($reporte['dia_25']); ?>" value="<?php echo htmlspecialchars($reporte['dia_25']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_26[]" class="dia_26 <?php echo getColorClass($reporte['dia_26']); ?>" value="<?php echo htmlspecialchars($reporte['dia_26']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_27[]" class="dia_27 <?php echo getColorClass($reporte['dia_27']); ?>" value="<?php echo htmlspecialchars($reporte['dia_27']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_28[]" class="dia_28 <?php echo getColorClass($reporte['dia_28']); ?>" value="<?php echo htmlspecialchars($reporte['dia_28']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_29[]" class="dia_29 <?php echo getColorClass($reporte['dia_29']); ?>" value="<?php echo htmlspecialchars($reporte['dia_29']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_30[]" class="dia_30 <?php echo getColorClass($reporte['dia_30']); ?>" value="<?php echo htmlspecialchars($reporte['dia_30']); ?>" oninput="validarEntrada(event)"></td>
                            <td><input type="text" name="dia_31[]" class="dia_31 <?php echo getColorClass($reporte['dia_31']); ?>" value="<?php echo htmlspecialchars($reporte['dia_31']); ?>" oninput="validarEntrada(event)"></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Agregar una fila vacía si no hay reportes -->
                    <tr class="fila-proyecto_delete" data-id="" data-filtro="no">
                        <td>
                            <select name="proyecto_id[]" class="proyectoSelect" onchange="actualizarCodigo(this)">
                                <option value="">Seleccionar Proyecto</option>
                                <?php foreach ($proyectos as $proyecto): ?>
                                    <option value="<?php echo $proyecto['id']; ?>" data-codigo="<?php echo $proyecto['codigo_proyecto']; ?>">
                                        <?php echo $proyecto['nombre_proyecto']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" name="codigo_proyecto[]" class="codigoProducto" value="" readonly></td>
                        <td><input type="text" name="dia_1[]" class="dia_1" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_2[]" class="dia_2" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_3[]" class="dia_3" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_4[]" class="dia_4" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_5[]" class="dia_5" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_6[]" class="dia_6" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_7[]" class="dia_7" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_8[]" class="dia_8" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_9[]" class="dia_9" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_10[]" class="dia_10" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_11[]" class="dia_11" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_12[]" class="dia_12" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_13[]" class="dia_13" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_14[]" class="dia_14" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_15[]" class="dia_15" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_16[]" class="dia_16" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_17[]" class="dia_17" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_18[]" class="dia_18" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_19[]" class="dia_19" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_20[]" class="dia_20" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_21[]" class="dia_21" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_22[]" class="dia_22" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_23[]" class="dia_23" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_24[]" class="dia_24" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_25[]" class="dia_25" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_26[]" class="dia_26" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_27[]" class="dia_27" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_28[]" class="dia_28" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_29[]" class="dia_29" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_30[]" class="dia_30" value="" oninput="validarEntrada(event)"></td>
                        <td><input type="text" name="dia_31[]" class="dia_31" value="" oninput="validarEntrada(event)"></td>
                    </tr>
                <tfoot>
                    <tr>
                        <td class="table2" colspan="2">Sub Total Diario</td>
                        <td id="totalDia_1"></td>
                        <td id="totalDia_2"></td>
                        <td id="totalDia_3"></td>
                        <td id="totalDia_4"></td>
                        <td id="totalDia_5"></td>
                        <td id="totalDia_6"></td>
                        <td id="totalDia_7"></td>
                        <td id="totalDia_8"></td>
                        <td id="totalDia_9"></td>
                        <td id="totalDia_10"></td>
                        <td id="totalDia_11"></td>
                        <td id="totalDia_12"></td>
                        <td id="totalDia_13"></td>
                        <td id="totalDia_14"></td>
                        <td id="totalDia_15"></td>
                        <td id="totalDia_16"></td>
                        <td id="totalDia_17"></td>
                        <td id="totalDia_18"></td>
                        <td id="totalDia_19"></td>
                        <td id="totalDia_20"></td>
                        <td id="totalDia_21"></td>
                        <td id="totalDia_22"></td>
                        <td id="totalDia_23"></td>
                        <td id="totalDia_24"></td>
                        <td id="totalDia_25"></td>
                        <td id="totalDia_26"></td>
                        <td id="totalDia_27"></td>
                        <td id="totalDia_28"></td>
                        <td id="totalDia_29"></td>
                        <td id="totalDia_30"></td>
                        <td id="totalDia_31"></td>

                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </form>
    <h3 class="label_h3">Reporte Estadístico</h3>
    <form class="form_second" action="reporte.php" method="post" enctype="multipart/form-data">

        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 30px;">

            <label class="labels" for="mes">Mes:</label>
            <select class="box-labels" id="mes" name="mes" required>
                <option value="">Seleccionar</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <!-- Combobox de Año -->
            <label class="labels" for="anio">Año:</label>
            <select class="box-labels" id="anio" name="anio" required>
                <option value="">Seleccionar</option>
                <?php
                $anio_actual = date("Y");
                for ($i = 2024; $i <= 2029; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>

            <!-- Input para cargar imagen (opcional) -->
            <label class="labels" for="imagen">Cargar:</label>
            <input class="labels" type="file" id="imagen" name="imagen" accept="image/*" required>

            <!-- Botón para guardar -->
            <button id=guardarReporte type="submit">Enviar Reporte</button>
        </div>

        <div class="container_table-second">
            <table>
                <thead>
                    <tr>
                        <th class="table2">Proyecto</th>
                        <th class="table2">Código</th>
                        <th class="table2">Horas Efectivas por Proyecto</th>
                        <th class="table2">% / 100</th>
                        <th class="table2">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Variables para almacenar totales y proyectos
                    $totalHorasAcumuladas = 0;
                    $proyectos = [];
                    $porcentajes = [];
                    $sumaPorcentaje100 = 0;
                    $sumaPorcentaje = 0;

                    // Calcular el total de horas acumuladas
                    foreach ($reportes as $reporte) {
                        $totalHoras = 0;
                        for ($i = 1; $i <= 31; $i++) {
                            if (isset($reporte["dia_" . $i])) {
                                $valorDia = $reporte["dia_" . $i];

                                // Si el valor es un número, lo sumamos
                                if (is_numeric($valorDia)) {
                                    $totalHoras += $valorDia;
                                }
                                // Si el valor es "V", lo tratamos como 8 horas
                                elseif (strtoupper($valorDia) === 'V') {
                                    $totalHoras += 8;
                                }
                            }
                        }
                        $totalHorasAcumuladas += $totalHoras;
                    }

                    // Mostrar los reportes y calcular porcentajes
                    foreach ($reportes as $reporte):
                        $totalHoras = 0;
                        for ($i = 1; $i <= 31; $i++) {
                            if (isset($reporte["dia_" . $i])) {
                                $valorDia = $reporte["dia_" . $i];

                                // Si el valor es un número, lo sumamos
                                if (is_numeric($valorDia)) {
                                    $totalHoras += $valorDia;
                                }
                                // Si el valor es "V", lo tratamos como 8 horas
                                elseif (strtoupper($valorDia) === 'V') {
                                    $totalHoras += 8;
                                }
                            }
                        }

                        // Calcular el porcentaje del total
                        $proporcionRedondeada = 0;
                        if ($totalHorasAcumuladas > 0 && $totalHoras > 0) {
                            $proporcion = ($totalHoras / $totalHorasAcumuladas) * 100;
                            $proporcionRedondeada = round($proporcion, 2);
                        }

                        // Calcular el porcentaje % / 100 (horas efectivas / total acumulado mensual)
                        $porcentajeRedondeado100 = 0;
                        if ($totalHorasAcumuladas > 0 && $totalHoras > 0) {
                            $porcentajeRedondeado100 = round($totalHoras / $totalHorasAcumuladas, 4);
                        }

                        // Acumulamos los porcentajes
                        $sumaPorcentaje100 += $porcentajeRedondeado100;
                        $sumaPorcentaje += $proporcionRedondeada;

                        // Guardar los datos para el gráfico circular
                        $proyectos[] = $reporte['nombre_proyecto'];
                        $porcentajes[] = $proporcionRedondeada;
                    ?>
                        <tr>
                            <td class="content"><?php echo $reporte['nombre_proyecto']; ?></td>
                            <td class="content"><?php echo $reporte['codigo_proyecto']; ?></td>
                            <td class="content"><?php echo $totalHoras; ?></td>
                            <td class="content"><?php echo $porcentajeRedondeado100; ?></td>
                            <td class="content"><?php echo round($proporcionRedondeada, 2); ?>%</td>

                            <!-- Campos ocultos para enviar al servidor -->
                            <input type="hidden" name="proyecto[]" value="<?php echo $reporte['nombre_proyecto']; ?>">
                            <input type="hidden" name="codigo[]" value="<?php echo $reporte['codigo_proyecto']; ?>">
                            <input type="hidden" name="horas[]" value="<?php echo $totalHoras; ?>">
                            <input type="hidden" name="porcentaje100[]" value="<?php echo $porcentajeRedondeado100; ?>">
                            <input type="hidden" name="porcentaje[]" value="<?php echo $proporcionRedondeada; ?>">
                        </tr>
                    <?php endforeach; ?>

                    <!-- Fila Total Acumulado Mensual -->
                    <tr>
                        <td class="table2" colspan="2">Total Acumulado Mensual</td>
                        <td class="content"><?php echo $totalHorasAcumuladas; ?></td>
                        <td class="content"><?php echo round($sumaPorcentaje100, 4); ?></td>
                        <td class="content"><?php echo round($sumaPorcentaje, 2); ?>%</td>
                    </tr>
                </tbody>
            </table>


            <!-- Contenedor del gráfico -->
            <div style="display: flex; align-items: center;height:250px; width:55rem; padding:0 0 0 40px">
                <canvas id="graficoCircular"></canvas>

                <!-- Contenedor para la leyenda -->
                <div id="leyenda" style="margin-left:22px; display: flex; flex-direction: column;font-size:0.9rem; font-family: 'Poppins', sans-serif; font-weight: 500;">
                </div>
            </div>
        </div>
    </form>


    <!-- Agregar Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>



    <script>
        // Datos dinámicos provenientes de PHP
        const proyectos = <?php echo json_encode($proyectos); ?>;
        const porcentajes = <?php echo json_encode($porcentajes); ?>;

        // Colores proporcionados
        const colores = ['#739bd7', '#dfe3e8', '#b2b3b4', '#646363', '#235c94', '#2e2e51', '#4872af', '#95b3d9', '#8a8a8a', '#94dcfc'];

        // Crear el gráfico circular con Chart.js
        const ctx = document.getElementById('graficoCircular').getContext('2d');
        const graficoCircular = new Chart(ctx, {
            type: 'doughnut', // Tipo de gráfico (Donut)
            data: {
                labels: proyectos, // Nombres de los proyectos
                datasets: [{
                    label: 'Porcentaje de horas por Proyecto',
                    data: porcentajes, // Porcentajes de cada proyecto
                    backgroundColor: colores, // Colores proporcionados
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false, // Desactivar la leyenda predeterminada
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%'; // Mostrar con 2 decimales
                            }
                        }
                    },
                    datalabels: {
                        display: false, // No mostrar etiquetas directamente en el gráfico
                    }
                }
            }
        });

        // Crear la leyenda a la derecha con el nombre del proyecto y el porcentaje
        const leyendaContainer = document.getElementById('leyenda');
        proyectos.forEach((proyecto, index) => {
            const legendItem = document.createElement('div');
            legendItem.classList.add('legend-item');

            // Crear un pequeño círculo con el color correspondiente
            const colorBox = document.createElement('div');
            colorBox.classList.add('legend-color');
            colorBox.style.backgroundColor = colores[index]; // Asignar el color al cuadro

            // Crear el texto con el nombre del proyecto y su porcentaje
            const label = document.createElement('span');
            label.innerHTML = `<span style="color: ${colores[index]}">●</span> ${proyecto}`;

            // Agregar el círculo de color y el texto a la leyenda
            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            leyendaContainer.appendChild(legendItem);
        });

        // Función para actualizar el código y verificar duplicados
        function actualizarCodigo(selectElement) {
            const previousValue = selectElement.getAttribute('data-prev-value') || selectElement.value;
            const codigo = selectElement.options[selectElement.selectedIndex].getAttribute('data-codigo');
            const rowId = selectElement.closest('tr').querySelector('.codigoProducto');
            rowId.value = codigo;

            // Verificar si el proyecto ya está seleccionado en otras filas, excepto el "1" o vacío
            checkProyectoExist(selectElement, previousValue);
        }

        function checkProyectoExist(selectElement, previousValue) {
            const selectedValue = selectElement.value; // Valor del select actual (nombre del proyecto)
            let proyectoDuplicado = false;

            // Obtener todas las celdas de select de proyectos
            const allSelects = document.querySelectorAll('.proyectoSelect');

            allSelects.forEach(select => {
                // Comprobar si el proyecto ya está seleccionado en otro select
                if (select !== selectElement && select.value === selectedValue) {
                    proyectoDuplicado = true;
                }
            });

            // Si el proyecto ya existe en otra fila, mostrar el modal
            if (proyectoDuplicado) {
                mostrarModal(); // Función para mostrar el modal con la advertencia de duplicado
                // Restaurar el valor anterior del select
                setTimeout(() => {
                    selectElement.value = previousValue; // Restaura el valor anterior
                    selectElement.setAttribute('data-prev-value', previousValue); // Asegura que el valor anterior se mantenga
                }, 0);
            } else {
                // Si no está duplicado, actualizar el valor previo
                selectElement.setAttribute('data-prev-value', selectedValue);
            }
        }
        // Función para mostrar el modal
        function mostrarModal() {
            const modal = document.getElementById('errorModal');
            modal.style.display = 'flex';

            // Después de 3 segundos, actualizar la página
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            const exito = urlParams.get('success');
            const mes = urlParams.get('mes');

            const modal = document.getElementById('errorModal2');
            const modalMessage = document.getElementById('modalMessage');

            // Mostrar el mensaje correspondiente en el modal
            if (error === "1" || exito === "1") {
                modalMessage.innerHTML = error === "1" ? `El reporte del mes de ${mes} ya fue enviado.` : `Reporte de ${mes} enviado con éxito.`;
                modal.style.display = "flex";
                setTimeout(() => modal.style.display = "none", 3000);
            }

            // Limpiar la URL para evitar que el modal se muestre al recargar
            window.history.replaceState({}, document.title, window.location.pathname);
        });


        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[class^="dia_"]');

            inputs.forEach(input => {
                let valor = input.value.toUpperCase();
                const td = input.closest('td');

                // Limpiar las clases anteriores
                td.classList.remove('G', 'V', 'C', 'B', 'numero');

                // Aplicar las clases de color según el valor inicial
                if (valor === 'G') {
                    td.classList.add('G');
                } else if (valor === 'C') {
                    td.classList.add('C');
                } else if (valor === 'B') {
                    td.classList.add('B');
                } else if (valor === 'V') {
                    td.classList.add('V');
                } else if (/^(?:[1-9]|1[0-9]|2[0-4])$/.test(valor)) {
                    td.classList.add('numero'); // Para los números del 1 al 24
                }
            });
        });




        // Tu función validarEntrada sigue igual
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los inputs de tipo 'dia_1' a 'dia_31'
            const inputs = document.querySelectorAll('input[class^="dia_"]');

            inputs.forEach(input => {
                // Escucha el evento de entrada para cambiar el valor a mayúsculas
                input.addEventListener('input', function() {
                    let valor = input.value.toUpperCase();
                    input.value = valor;

                    // Validar solo si el campo tiene algo escrito
                    if (valor !== '') {
                        if (validarValor(valor)) {
                            actualizarColor(input);
                        } else {
                            // Si el valor no es válido, borrar el valor y mostrar alerta
                            input.value = '';
                            alert('Solo puedes ingresar números del 1 al 24 o las letras G, C, B, V');
                        }
                    } else {
                        // Si el valor está vacío, no hacemos nada
                        input.classList.remove('G', 'V', 'C', 'B', 'numero');
                    }
                });

                // Llamada para aplicar las clases de color al cargar la página
                let valor = input.value.toUpperCase();
                if (valor !== '' && validarValor(valor)) {
                    actualizarColor(input);
                }
            });
        });

        function actualizarColor(input) {
            let valor = input.value.toUpperCase(); // Convierte el valor a mayúsculas
            const td = input.closest('td');

            // Limpiar las clases anteriores
            td.classList.remove('G', 'V', 'C', 'B', 'numero');

            // Aplicar las clases de color según el valor actualizado
            if (valor === 'G') {
                td.classList.add('G');
            } else if (valor === 'C') {
                td.classList.add('C');
            } else if (valor === 'B') {
                td.classList.add('B');
            } else if (valor === 'V') {
                td.classList.add('V');
            } else if (/^(?:[1-9]|1[0-9]|2[0-4])$/.test(valor)) {
                td.classList.add('numero'); // Para los números del 1 al 24
            }
        }

        function validarValor(valor) {
            // Validar que el valor sea un número entre 1 y 24 o una de las letras G, C, B, V
            return /^(?:[1-9]|1[0-9]|2[0-4]|[GCVB])$/.test(valor);
        }

        // Detectar cambios en los campos de días
        document.querySelectorAll('.dia_1, .dia_2, .dia_3, .dia_4, .dia_5, .dia_6, .dia_7, .dia_8, .dia_9, .dia_10, .dia_11, .dia_12, .dia_13, .dia_14, .dia_15, .dia_16, .dia_17, .dia_18, .dia_19, .dia_20, .dia_21, .dia_22, .dia_23, .dia_24, .dia_25, .dia_26, .dia_27, .dia_28, .dia_29, .dia_30, .dia_31').forEach(input => {
            input.addEventListener('input', function(event) {
                actualizarDatosFila(event);
            });
        });


        // Detectar clic derecho sobre una fila para eliminarla
        document.querySelectorAll('.fila-proyecto').forEach(fila => {
            fila.addEventListener('contextmenu', function(event) {
                event.preventDefault(); // Evita el menú contextual predeterminado

                // Confirmar si el usuario realmente desea eliminar la fila
                const confirmar = confirm("¿Seguro que deseas eliminar esta fila?");
                if (confirmar) {
                    eliminarFila(fila); // Eliminar fila del front-end y del back-end
                }
            });
        });

        // Función para eliminar la fila del front-end y el back-end
        function eliminarFila(fila) {
            const filaId = fila.getAttribute('data-id');

            // Eliminar la fila del front-end
            fila.remove();

            // Eliminar la fila del back-end (base de datos)
            eliminarFilaBackEnd(filaId);
        }

        // Función para eliminar la fila de la base de datos
        function eliminarFilaBackEnd(filaId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'eliminar_fila.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Aquí puedes manejar la respuesta del servidor si es necesario
                    console.log(xhr.responseText);
                }
            };
            // Enviar el ID de la fila a eliminar
            xhr.send('id=' + filaId);
        }


        function calcularTotales() {
            let totales = Array(31).fill(0); // Crear un array para almacenar los totales de cada día (31 días)

            // Recorrer todas las filas de la tabla
            document.querySelectorAll('.fila-proyecto').forEach(fila => {
                for (let i = 1; i <= 31; i++) {
                    const valor = fila.querySelector(`.dia_${i}`).value.toUpperCase(); // Obtener el valor de la celda

                    // Si el valor es "V", sumamos 8, si no, sumamos el valor numérico
                    if (valor === 'V') {
                        totales[i - 1] += 8;
                    } else {
                        totales[i - 1] += parseFloat(valor) || 0;
                    }
                }
            });

            // Actualizar los totales en el pie de la tabla
            totales.forEach((total, index) => {
                // Solo actualizar si el total es mayor que 0
                document.getElementById(`totalDia_${index + 1}`).textContent = total > 0 ? Math.floor(total) : '';
            });
        }

        // Configuración de los eventos
        document.querySelectorAll('input').forEach(input => input.addEventListener('input', calcularTotales));
        window.onload = calcularTotales;



        function descargarImagen() {
            let tabla = document.getElementById("tablaProyectos");

            // Obtener el mes actual del sistema
            const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const fechaActual = new Date();
            const mesActual = meses[fechaActual.getMonth()]; // Obtener el mes actual como nombre

            // Crear el nombre del archivo con el mes actual
            let nombreArchivo = `tabla-${mesActual}.png`;

            // Crear el canvas con una escala mayor para obtener mayor resolución
            html2canvas(tabla, {
                scale: 4 // Esto aumenta la calidad de la imagen, 4 es un buen valor para 4K.
            }).then(canvas => {
                let link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = nombreArchivo; // Usar el nombre del archivo con el mes actual
                link.click();
            });
        }
    </script>

    <!-- Modal de error -->
    <div id="errorModal" style="display: none;">
        <div class="modal-content">
            <p>Este proyecto ya está seleccionado en otra fila.</p>
        </div>
    </div>
    <!-- Modal de error -->
    <div id="errorModal2" style="display: none;">
        <div class="modal-content">
            <p id="modalMessage">Mensaje del reporte</p>
        </div>
    </div>

    </div>

    <footer style="background-color: #000; color: #fff; padding: 10px 0; text-align: center; font-size: 0.8rem; width: 100%;">
        <div style="margin: 0 auto;">
            <p>&#169; Derechos Reservados 2025 Hecho por ❤️ Tu cachero</p>
        </div>
    </footer>
</body>

</html>