<?php
// Conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estudiantes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar la acción enviada desde JavaScript
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    // INSERTAR
    if ($accion == 'Insertar') {
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $programa = $_POST['programa'];

        $sql = "INSERT INTO estudiantes (nombre, edad, programa) VALUES ('$nombre', '$edad', '$programa')";
        $conn->query($sql);

    // ACTUALIZAR
    } elseif ($accion == 'Actualizar') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $programa = $_POST['programa'];

        $sql = "UPDATE estudiantes SET nombre='$nombre', edad='$edad', programa='$programa' WHERE id='$id'";
        $conn->query($sql);

    // ELIMINAR
    } elseif ($accion == 'Eliminar') {
        $id = $_POST['id'];

        $sql = "DELETE FROM estudiantes WHERE id='$id'";
        $conn->query($sql);
    }
}

// CONSULTAR
if (isset($_GET['accion']) && $_GET['accion'] == 'Consultar') {
    $sql = "SELECT * FROM estudiantes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Programa</th>
                    <th>Acciones</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td><input type='text' id='nombre_" . $row["id"] . "' value='" . $row["nombre"] . "'></td>
                    <td><input type='number' id='edad_" . $row["id"] . "' value='" . $row["edad"] . "'></td>
                    <td><input type='text' id='programa_" . $row["id"] . "' value='" . $row["programa"] . "'></td>
                    <td>
                        <button onclick='actualizarEstudiante(" . $row["id"] . ")'>Actualizar</button>
                        <button onclick='eliminarEstudiante(" . $row["id"] . ")'>Eliminar</button>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No hay estudiantes registrados.";
    }
}

$conn->close();
?>
