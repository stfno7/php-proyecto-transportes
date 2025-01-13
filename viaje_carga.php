<?php
include_once "includes/head_s.php";
?>
<body>
<?php
include_once "includes/header_s.php";
include_once "includes/sidebar_s.php";

require_once "funciones/conexion.php";
include_once "funciones/listadoGet.php";
include_once "funciones/validarViaje.php";

// Conexión a la base de datos
$MiConexion = conexion_db();

$ListadoChofer = ListarChoferes($MiConexion);
$ListadoTransporte = ListarTransportes($MiConexion);
$ListadoDestino = ListarDestinos($MiConexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['BotonRegistrar'])) {
    // Llamar a la función para registrar el viaje
    $registroExitoso = insertarViajes($MiConexion);
    if ($registroExitoso) {
        echo "<p>Viaje registrado correctamente.</p>"; // No se imprime
    } else {
        echo "<p>Error al registrar el viaje.</p>";
    }
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Registrar un nuevo viaje</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Viajes</li>
                <li class="breadcrumb-item active">Carga</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ingresa los datos</h5>

                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="bi bi-info-circle me-1"></i>
                            Los campos indicados con (*) son requeridos
                        </div>

                        <form class="row g-3" method="POST"> <!-- Formulario metodo post -->

                        <!-- Chofer -->
                            <div class="col-12">
                                <label for="chofer" class="form-label">Chofer (*)</label>
                                <select class="form-select" aria-label="Selector" id="chofer" name="CHOFER">
                                    <option value="">Selecciona una opción</option>
                                    <?php foreach ($ListadoChofer as $chofer) { ?>
                                        <option value="<?php echo $chofer["id"]; ?>" <?php echo (!empty($_POST["CHOFER"]) && $_POST["CHOFER"] == $chofer["id"]) ? "selected" : ''; ?>>
                                            <?php echo $chofer["nombre"]. ', '.$chofer["apellido"]. ' - (DNI '.$chofer["dni"].')'; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <!-- Transporte -->
                            <div class="col-12">
                                <label for="transporte" class="form-label">Transporte Habilitado (*)</label>
                                <select class="form-select" aria-label="Selector" id="transporte" name="TRANSPORTE">
                                    <option value="">Selecciona una opción</option>
                                    <?php foreach ($ListadoTransporte as $transporte) { ?>
                                        <option value="<?php echo $transporte["id"]; ?>" 
                                        <?php echo (!empty($_POST["TRANSPORTE"]) && $_POST["TRANSPORTE"] == $transporte["patente"]) ? "selected" : ''; ?>>
                                            <?php echo $transporte["marca"].' - '.$transporte["modelo"]. ' - '.$transporte["patente"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Fecha programada -->
                            <div class="col-12">
                                <label for="fecha" class="form-label">Fecha programada (*)</label>
                                <input type="date" class="form-control" id="fecha" name="FECHA" value="<?php echo !empty($_POST['FECHA']) ? $_POST['FECHA'] : ''; ?>">
                            </div>

                            <!-- Destino / Ciudad -->
                            <div class="col-12">
                                <label for="destino" class="form-label">Destino (*)</label>
                                <select class="form-select" aria-label="Selector" id="destino" name="DESTINO">
                                    <option value="">Selecciona una opcion</option>
                                    <?php foreach ($ListadoDestino as $destino) { ?>
                                        <option value="<?php echo $destino["id"]; ?>" <?php echo (!empty($_POST["DESTINO"]) && $_POST["DESTINO"] == $destino["id"]) ? "selected" : ''; ?>>
                                            <?php echo $destino["denominacion"]; ?>
                                        </option>
                                    <?php } ?>                    
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="col-12">
                                <label for="costo" class="form-label">Costo (*)</label>
                                <input type="text" class="form-control" id="costo" name="COSTO" value="<?php echo !empty($_POST['COSTO']) ? $_POST['COSTO'] : ''; ?>">
                            </div>

                            <!-- Porcentaje chofer -->
                            <div class="col-12">
                                <label for="porcentaje" class="form-label">Porcentaje chofer (*)</label>
                                <input type="text" class="form-control" id="porcentaje" name="PORCENTAJE" value="<?php echo !empty($_POST['PORCENTAJE']) ? $_POST['PORCENTAJE'] : ''; ?>">
                            </div>

                            <!-- Botones -->
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Registrar" name="BotonRegistrar">Registrar</button>
                                <button type="reset" class="btn btn-secondary">Limpiar Campos</button>
                                <a href="index.php" class="text-primary fw-bold">Volver al index</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->


</body>
<?php include_once "includes/footer_s.php"?>
</html>