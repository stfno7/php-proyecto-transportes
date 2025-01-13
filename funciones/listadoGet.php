<?php
// Funcion para transporte_carga.php. Obtener las marcas para los camiones.
function ListarMarcas($conexion) {
    $sql = "SELECT id, denominacion FROM marcas ORDER BY denominacion";
    $resultado = mysqli_query($conexion, $sql);
    $marcas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $marcas[] = $fila;
    }
    return $marcas;
}

// Funcion para transporte_carga.php. Obtener los cuatro tipos de transportes.
function ListarTipos($conexion) {
    $sql = "SELECT id, denominacion FROM tipos_transportes ORDER BY denominacion";
    $resultado = mysqli_query($conexion, $sql);
    $tipos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tipos[] = $fila;
    }
    return $tipos;
}

// Funcion para viaje_carga.php. Se estan utilizando alias ya que varias tablas en la consulta tienen la columna id
function ListarTransportes($conexion)
{
    $sql = "SELECT t.id, t.marca_id, t.tipo_id, t.patente, t.modelo, t.disponible, t.combustible, t.fecha_carga, 
                   m.denominacion AS marca, tipo.denominacion AS tipo
            FROM transportes t
            LEFT JOIN marcas m ON t.marca_id = m.id
            LEFT JOIN tipos_transportes tipo ON t.tipo_id = tipo.id";

    // Ejecutar consulta
    $respuesta = mysqli_query($conexion, $sql);

    // Verificar error en la respuesta
    if (!$respuesta) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Array para almacenar los resultados
    $Listado = array();

    // Búcle para recorrer los resultados y obtenerlos
    while ($data = mysqli_fetch_assoc($respuesta)) {
        $Listado[] = array(
            'id' => $data['id'],
            'marca_id' => $data['marca_id'],
            'tipo_id' => $data['tipo_id'],
            'patente' => $data['patente'],
            'modelo' => $data['modelo'],
            'disponible' => $data['disponible'],
            'combustible' => $data['combustible'],
            'fecha_carga' => $data['fecha_carga'],
            'marca' => $data['marca'],
            'tipo' => $data['tipo']
        );
    }
    mysqli_free_result($respuesta);
    return $Listado;
}


function ListarChoferes($conexion)
{
    // Consulta SQL ajustada para seleccionar solo choferes (nivel_id = 3) activos. Aunque imagen no se esta utilizando
    $sql = "SELECT id, apellido, nombre, dni, activo, nivel_id, fecha_creacion, imagen 
            FROM usuarios 
            WHERE activo = 1 AND nivel_id = 3";  // Solo choferes activos

    $respuesta = mysqli_query($conexion, $sql);
    $Listado = array();

    // Recorrer array y almacenar los choferes
    while ($data = mysqli_fetch_assoc($respuesta)) {
        $Listado[] = array(
            'id' => $data['id'],
            'apellido' => $data['apellido'],
            'nombre' => $data['nombre'],
            'dni' => $data['dni'],
            'activo' => $data['activo'],
            'nivel_id' => $data['nivel_id'],
            'fecha_creacion' => $data['fecha_creacion'],
            'imagen' => $data['imagen']
        );
    }
    return $Listado;
}

function ListarDestinos($conexion){
    // Consulta para obtener la ciudad (denominacion)
    $sql = "SELECT * FROM `destinos` ORDER BY denominacion"; 

    $respuesta = mysqli_query($conexion, $sql);
    $Listado = array();

    while ($data = mysqli_fetch_assoc($respuesta)) {
        $Listado[] = array(
            'id' => $data['id'],  
            'denominacion' => $data['denominacion'] 
        );
    }
    return $Listado;
}


// Funcion para listado de viajes
function ListarViajes($conexion)
{
    // Consulta para obtener los viajes con los choferes y los detalles correspondientes, ordenados por fecha ascendente
    $sql = "
    SELECT 
        viajes.fecha_viaje AS FECHA_VIAJE,
        destinos.denominacion AS NOM_CIUDAD,
        tipos_transportes.denominacion AS NOM_MARCA,  
        transportes.modelo AS NOM_MODELO,  
        transportes.patente AS PATENTE,
        viajes.costo AS COSTO_VIAJE,
        viajes.porcentaje_costo AS PORCENTAJE_CHOFER,
        usuarios.nombre AS NOMBRE,
        usuarios.apellido AS APELLIDO
    FROM 
        viajes
    INNER JOIN 
        destinos ON viajes.destino_id = destinos.id
    INNER JOIN 
        transportes ON viajes.transporte_id = transportes.id
    INNER JOIN 
        tipos_transportes ON transportes.tipo_id = tipos_transportes.id 
    INNER JOIN 
        marcas ON transportes.marca_id = marcas.id
    INNER JOIN 
        usuarios ON viajes.chofer_id = usuarios.id AND usuarios.nivel_id = 3
    ORDER BY 
        viajes.fecha_viaje ASC;  
    "; // ORDER BY, Ordenar de forma ascendente.
    // Aplicar clausula WHERE para filtrar viajes por chofer.

    $respuesta = mysqli_query($conexion, $sql);
    if (!$respuesta) {
        // Manejo de errores
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    $Listado = array();

    // Recorrer el array con el bucle
    while ($data = mysqli_fetch_assoc($respuesta)) {
        $Listado[] = array(
            'FECHA_VIAJE' => $data['FECHA_VIAJE'],
            'NOM_CIUDAD' => $data['NOM_CIUDAD'],
            'NOM_MARCA' => $data['NOM_MARCA'],
            'NOM_MODELO' => $data['NOM_MODELO'],
            'PATENTE' => $data['PATENTE'],
            'COSTO_VIAJE' => $data['COSTO_VIAJE'],
            'PORCENTAJE_CHOFER' => $data['PORCENTAJE_CHOFER'],
            'NOMBRE' => $data['NOMBRE'],
            'APELLIDO' => $data['APELLIDO'],
        );
    }

    return $Listado;
}
