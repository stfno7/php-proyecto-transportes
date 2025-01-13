<?php
function DatosLogin($usuario, $clave, $conexion)
{
    $Usuario = array();

    // Consulta datos del user
    $sql = "SELECT id AS ID, activo AS ESTADO, nivel_id AS NIVEL, nombre AS NOMBRE, apellido AS APELLIDO, clave AS CLAVE
            FROM usuarios 
            WHERE dni = '$usuario'"; // El usuario se loguea con el dni

    $resultado = mysqli_query($conexion, $sql); // Funcion SELECT para ejecutar consulta

    // Verificación para encontrar el usuario
    if ($resultado && mysqli_num_rows($resultado) == 1) { // Si la consulta $resultado es correcta, se devuelve que se encontro un unico usuario que coincide con el dni dado.
        $data = mysqli_fetch_assoc($resultado); // Encontrar usuario y almacenar en $data. La clave es el nombre de la columna de la tabla usuarios.

        // Comparar la clave ingresada con la clave almacenada
        if ($data['CLAVE'] === $clave) { 
            $Usuario['ESTADO'] = $data['ESTADO'];
            $Usuario['NIVEL'] = $data['NIVEL'];
            $Usuario['APELLIDO'] = $data['APELLIDO'];
            $Usuario['NOMBRE'] = $data['NOMBRE'];
        }
    }

    return $Usuario; // Retornar datos del usuario o un array vacío si no coincide
}
?>
