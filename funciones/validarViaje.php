<?php
function InsertarViajes($conexion){
    $chofer_id = $_POST['CHOFER'];
    $transporte_id = $_POST['TRANSPORTE'];
    var_dump($_POST['FECHA']);
    $fecha_viaje = $_POST['FECHA']; 
    $destino_id = $_POST['DESTINO'];
    $costo = $_POST['COSTO'];
    $porcentaje_costo = $_POST['PORCENTAJE'];
    $registrado_por = $_SESSION['Usuario_Nombre'];

    // Validar si los campos obligatorios están vacíos
    if (empty($chofer_id) || empty($transporte_id) || empty($fecha_viaje) || empty($destino_id) || empty($costo) || empty($porcentaje_costo)) {
        echo '<h4>Faltan datos obligatorios. Por favor, completa todos los campos.</h4>';
        return false;
    }

    // Verificar que el nombre del registrador existe en la tabla usuarios
    $query = "SELECT id FROM usuarios WHERE nombre = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $registrado_por); 
    $stmt->execute();
    $stmt->bind_result($registrado_por);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se encontró el usuario
    if (empty($registrado_por)) {
        echo '<h4>El nombre del registrador no existe.</h4>';
        return false;
    }

    // Intentar insertar el nuevo viaje
    try {
        $query = "
            INSERT INTO viajes (chofer_id, transporte_id, fecha_viaje, destino_id, costo, porcentaje_costo, registrado_por)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $conexion->prepare($query);
        if ($stmt === false) {
            throw new Exception('Error al insertar datos.');
        }

        $stmt->bind_param("iissdds", $chofer_id, $transporte_id, $fecha_viaje, $destino_id, $costo, $porcentaje_costo, $registrado_por); // int

        if (!$stmt->execute()) {
            throw new Exception('Error al intentar insertar el viaje: ' . $stmt->error);
        }

        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo '<h4>' . $e->getMessage() . '</h4>';
        return false;
    }
}



/* FUNCION NO UTILIZADA PARA MOSTRAR MENSAJES
function Validar_Datos()
{
    $mensaje = "";
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);

        if (empty($_POST[$Id])) {
            $mensaje .= 'El campo ' . $Id . ' no puede estar vacío.<br>';
        }
    }
    return $mensaje;
}
*/ 
?>
