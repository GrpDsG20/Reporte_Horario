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

// Consulta para obtener los datos de los reportes
$sql = "SELECT * FROM reportes ORDER BY anio DESC, mes DESC"; // Ordena por año y mes

// Verificar si la conexión fue exitosa
if ($conn) {
    $result = $conn->query($sql); // Ejecuta la consulta
    if ($result === false) {
        // Si la consulta falla, muestra el error de la base de datos
        echo "Error en la consulta: " . $conn->error;
        exit;
    }
} else {
    // Si la conexión falla, muestra el error de conexión
    echo "Error de conexión a la base de datos.";
    exit;
}

// Función para obtener el nombre del mes a partir del número del mes
function obtenerNombreMes($mes)
{
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
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

</head>

<body>

    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <div class="panel">
            <h3>Panel de Administración</h3>
        </div>
        <div class="user-info">
            <p>Bienvenido, <?php echo $nombreUsuario; ?><a href="logout.php" class="logout-btn">
                    <i class="fas fa-door-open"></i>
                </a></p>
        </div>
    </header>
    <div class="container">
        <div class="botones">
            <!-- Botones a la izquierda -->
            <div class="botones-izquierda">
                <a href="registrar_usuario.php" class="btn">Registrar Usuario</a>
                <a href="registrar_proyecto.php" class="btn">Agregar Proyecto</a>
            </div>

            <!-- Elementos centrados -->
            <div class="buscar-centro">
                <input type="text" class="buscar" placeholder="Buscar...">
            </div>

            <!-- Filtros a la derecha -->
            <div class="elementos-derecha">
            <a href="#" class="btn" id="descargarExcel">Descargar</a>
                <select class="box-labels" id="mes" name="mes">
                    <option value="">Seleccionar mes</option>
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
                <select class="box-labels" id="anio" name="anio">
                    <option value="">Seleccionar año</option>
                    <?php
                    for ($i = 2024; $i <= 2029; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>


    <!-- Tabla para mostrar los reportes -->
    <div class="tabla-reportes">
    <table id="tablaReportes" border="1" class="reportes-table">
    <thead>
        <tr>
            <th>Proyecto</th>
            <th>Código</th>
            <th>Horas Efectivas</th>
            <th>%/100</th>
            <th>Porcentaje %</th>
            <th>Nombre Usuario</th>
            <th>Código Usuario</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Verificar si hay resultados
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mesNumero = str_pad($row['mes'], 2, '0', STR_PAD_LEFT); // Asegurar dos dígitos
                $mesNombre = obtenerNombreMes($mesNumero); // Función que convierte el mes en nombre
                echo "<tr>
                    <td>" . $row['nombre_proyecto'] . "</td>
                    <td>" . $row['codigo_proyecto'] . "</td>
                    <td>" . $row['horas_efectivas'] . "</td>
                    <td>" . $row['porcentaje_100'] . "</td>
                    <td>" . $row['porcentaje'] . "%</td>
                    <td>" . $row['usuario_sesion'] . "</td>
                    <td>" . $row['codigo_usuario'] . "</td>
                    <td data-mes='$mesNumero'>" . $mesNombre . "</td>
                    <td>" . $row['anio'] . "</td>
                    <td><img src='uploads/" . $row['imagen'] . "' alt='Imagen' width='100' style='cursor: pointer;'></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No se encontraron reportes</td></tr>";
        }
        ?>
    </tbody>
</table>


    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector(".buscar");
            const mesSelect = document.getElementById("mes");
            const anioSelect = document.getElementById("anio");
            const tableRows = document.querySelectorAll(".reportes-table tbody tr");

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const selectedMes = mesSelect.value; // El select ya tiene valores "01", "02", etc.
                const selectedAnio = anioSelect.value;

                tableRows.forEach(row => {
                    const proyecto = row.cells[0].textContent.toLowerCase();
                    const codigo = row.cells[1].textContent.toLowerCase();
                    const nombreUsuario = row.cells[5].textContent.toLowerCase();
                    const codigoUsuario = row.cells[6].textContent.toLowerCase();
                    const mes = row.cells[7].getAttribute("data-mes"); // Ahora usamos el atributo data-mes
                    const anio = row.cells[8].textContent.trim();

                    const matchesSearch = proyecto.includes(searchText) || codigo.includes(searchText) || nombreUsuario.includes(searchText) || codigoUsuario.includes(searchText);
                    const matchesMes = selectedMes === "" || mes === selectedMes;
                    const matchesAnio = selectedAnio === "" || anio === selectedAnio;

                    if (matchesSearch && matchesMes && matchesAnio) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            searchInput.addEventListener("input", filterTable);
            mesSelect.addEventListener("change", filterTable); // Usamos "change" en lugar de "input" para select
            anioSelect.addEventListener("change", filterTable);
        });



        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("modalImagen");
            const imagenAmpliada = document.getElementById("imagenAmpliada");
            const cerrar = document.querySelector(".cerrar");

            // Hacer clic en una imagen de la tabla para abrir el modal
            document.querySelectorAll(".reportes-table img").forEach(img => {
                img.addEventListener("click", function() {
                    imagenAmpliada.src = this.src;
                    modal.style.display = "flex"; // Mostrar el modal centrado
                });
            });

            // Cerrar al hacer clic en la "X"
            cerrar.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Cerrar al hacer clic fuera de la imagen
            modal.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });




        document.getElementById('descargarExcel').addEventListener('click', function(event) {
    event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
    
    // Obtener los datos de la tabla
    var tabla = document.getElementById('tablaReportes');
    
    // Convertir la tabla HTML a un libro de trabajo Excel
    var wb = XLSX.utils.table_to_book(tabla, { sheet: "Reportes" });

    // Generar el archivo Excel y disparar la descarga
    XLSX.writeFile(wb, "reportes.xlsx");
});
    </script>
    <!-- Modal para mostrar la imagen en grande -->
    <div id="modalImagen" class="modal">
        <span class="cerrar">&times;</span>
        <img class="modal-contenido" id="imagenAmpliada">
    </div>

</body>


</html>