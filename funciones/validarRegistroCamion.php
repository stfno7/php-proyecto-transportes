<?php
// Funcion por si falta un dato. VALIDACIONES
function DatoFaltante() {
    if (empty($_POST['MARCA'])) {
        return "Marca";
    }
    if (empty($_POST['TIPO'])) {
        return "Tipo";
    }
    if (empty($_POST['PATENTE'])) {
        return "Patente";
    }
    if (!isset($_POST['DISPONIBLE'])) {
        return "Disponibilidad";
    }
    if (empty($_POST['COMBUSTIBLE'])) {
        return "Combustible";
    }
    return ""; // Si no falta ningún dato
}

function Validar_Datos() {
    $mensaje = "";
    // Bucle para recorrer los datos enviados en $_POST, elimina espacios al principio y final. (y etiquetas)
    foreach ($_POST as $id => $valor) {
        $_POST[$id] = trim($_POST[$id]);
        $_POST[$id] = strip_tags($_POST[$id]); // Solo para que no se envíen scripts "innecesarios" en el form
    }

    // Condicional para validar los datos
    if (empty($_POST['MARCA'])) {
        $mensaje .= 'Debe seleccionar una Marca. <br />';
    }
    if (empty($_POST['TIPO'])) {
        $mensaje .= 'Debe seleccionar un Tipo. <br />';
    }
    if (!empty($_POST['MODELO']) && strlen($_POST['MODELO']) > 50) { // Funcion para devolver la longitud del string 
        $mensaje .= 'El Modelo no puede superar los 50 caracteres. <br />';
    }
    if (empty($_POST['PATENTE']) || !preg_match('/^[A-Za-z0-9]{6,7}$/', $_POST['PATENTE'])) { // Funcion matchear, si no lo encuentra (debe ingresar una patente válida)
        $mensaje .= 'Debe ingresar una Patente válida (6-7 caracteres alfanuméricos). <br />';
    }    
    if (empty($_POST['DISPONIBLE'])) {
        $mensaje .= 'Debe marcar "Habilitado". <br />';
    }
    if (empty($_POST['COMBUSTIBLE']) || !in_array($_POST['COMBUSTIBLE'], ['GNC', 'Gasoil'])) {
        $mensaje .= 'Debe seleccionar un tipo de Combustible. <br />';
    }
    return $mensaje;
}

// Función para la inserción de datos en la columna transportes de la base de datos. Fecha_carga esta utilizando current_timestamp()	
function InsertarCamiones($conexion) {
    // Recibir datos directamente desde $_POST
    $marca = $_POST['MARCA'];
    $tipo = $_POST['TIPO'];
    $modelo = $_POST['MODELO'];
    $patente = $_POST['PATENTE'];
    $disponible = isset($_POST['DISPONIBLE']) ? 1 : 0;
    $combustible = $_POST['COMBUSTIBLE'];

    // Crear consulta SQL para insertar datos en la bd
    $sql = "INSERT INTO transportes (marca_id, tipo_id, modelo, patente, disponible, combustible)
            VALUES ('$marca', '$tipo', '$modelo', '$patente', '$disponible', '$combustible')";

    // Ejecutar consulta y verificar si tuvo éxito
    if ($conexion->query($sql)) {
        return true;
    } else {
        echo "Error en la consulta SQL: " . $sql . "<br>";
        echo "Error en la base de datos: " . $conexion->error;
        return false;
    }
}

?>