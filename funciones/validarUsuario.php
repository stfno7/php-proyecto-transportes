<?php
function Validar_Datos()
{ // Cargar datos para chofer. Funcion para validar que los datos cumplan las siguientes condiciones.
    $Mensaje = "";
    // Condicion para Apellido y nombre al menos 3 caracteres. Dni rango entre 7 y 10.
    if (strlen($_POST['APELLIDO']) < 3) {
        $Mensaje .= 'Debes ingresar un Apellido con al menos 3 caracteres. <br />';
    }
    if (strlen($_POST['NOMBRE']) < 3) {
        $Mensaje .= 'Debes ingresar un Nombre con al menos 3 caracteres. <br />';
    }
    if (strlen($_POST['DNI']) < 7 || strlen($_POST['DNI']) > 10) {
        $Mensaje .= 'Ingresa un DNI válido (Entre 7 y 10 caracteres). <br />';
    }    
    if (strlen($_POST['PASSWORD']) == 0) {
        $Mensaje .= 'Debes crear una clave. <br />';
    } elseif (strlen($_POST['PASSWORD']) < 5) {
        $Mensaje .= 'La clave debe tener al menos 5 caracteres. <br />';
    } elseif (!preg_match('/[0-9]/', $_POST['PASSWORD'])) {
        $Mensaje .= 'La clave debe contener al menos un número. <br />';
    }
    return $Mensaje;
}

function DatoRequerido()
{
    $DatoFaltante = Validar_Datos();
    if (strpos($DatoFaltante, "APELLIDO") !== false) {
        $DatoFaltante = "APELLIDO"; // No se esta tomando el mensaje?
    } elseif (strpos($DatoFaltante, "NOMBRE") !== false) {
        $DatoFaltante = "NOMBRE"; // No se esta tomando el mensaje?
    } elseif (strpos($DatoFaltante, "DNI") !== false) {
        $DatoFaltante = "DNI"; // Se toma el mensaje
    } else $DatoFaltante = "";

    return $DatoFaltante;
}

// Funcion inserción de datos para la tabla usuarios 
// Falta imagen de perfil (assets/img). No sé si esta mal, ya que se esta alojando el dato del chofer, en la tabla de usuarios. A lo mejor sería mejor crear una tabla "choferes" para evitar redundancia.
function InsertarUsuarios($conexion){
    $SQL_Insert = "INSERT INTO usuarios (apellido, nombre, dni, clave, activo, nivel_id, fecha_creacion)
    VALUES ('".$_POST['APELLIDO']."', '".$_POST['NOMBRE']."', '".$_POST['DNI']."', '".$_POST['PASSWORD']."', 1, 3, NOW())"; // nivel_id = 3 (chofer; todo registro será para un nivel_id = 3 (chofer), tabla usuarios)
    if (!mysqli_query($conexion, $SQL_Insert)) {
        die('<h4>Error al intentar insertar el registro.</h4>');
    }

    return true;
}
?>