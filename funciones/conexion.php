<?php // Conexión a la base de datos transportes_db xampp
function conexion_db() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'transportes_db';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>
