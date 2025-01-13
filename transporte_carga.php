<?php require_once "includes/head_s.php"; ?>
<body>
   <?php
      include_once "includes/header_s.php";
      include_once "includes/sidebar_s.php";
      require_once "funciones/conexion.php";
      require_once "funciones/validarRegistroCamion.php";
      require_once "funciones/listadoGet.php";
      
      $MiConexion = conexion_db();
      $ListadoMarcas = ListarMarcas($MiConexion); // Seleccionando  las tablas en la bd, listadoGet.php
      $ListadoTipos = ListarTipos($MiConexion); // Seleccionando las tablas en la bd, listadoGet.php
      
      $Mensaje = "";
      $MensajeOk = "";
      $DatoFaltante = "";
      if (!empty($_POST['BotonRegistrar'])) {
        $Mensaje = Validar_Datos(); // Validar los datos del formulario
        if (empty($Mensaje)) { 
            if (InsertarCamiones($MiConexion) !== false) { // Si la inserción es exitosa
                $MensajeOk = 'Los datos se guardaron correctamente!';
                $_POST = []; // Reiniciar formulario
            } else {
                $Mensaje = 'Hubo un error al registrar el transporte.';
            }
        } else {
            $DatoFaltante = DatoFaltante(); // Obtener el nombre del campo que falta
        }
      }
      ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Registrar un nuevo transporte</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php">Home</a></li>
               <li class="breadcrumb-item">Transportes</li>
               <li class="breadcrumb-item active">Carga Camión</li>
            </ol>
         </nav>
      </div>
      <!-- End Page Title -->
      <section class="section">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Ingresa los datos</h5> <!-- Alerta de validaciones tomando variables ya definidas -->
                     <?php if (!empty($DatoFaltante)): ?>
                     <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        El campo <?= $DatoFaltante; ?> es requerido.
                     </div>
                     <?php endif; ?>
                     <?php if (!empty($Mensaje)) { ?>
                     <div class="alert alert-warning alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?php echo $Mensaje; ?>
                     </div>
                     <?php } ?> 
                     <?php if (!empty($MensajeOk)) { ?>
                     <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-1"></i>
                        <?php echo $MensajeOk; ?>
                     </div>
                     <?php } ?>


                     <form class="row g-3" method="post">
                        <!-- Formulario con metodo post -->

                        <!-- Selector para la marca de transporte -->
                        <div class="col-12">
                           <label for="marca" class="form-label">Marca (*)</label>
                           <select class="form-select" id="marca" name="MARCA">
                              <option value="">Selecciona una opción</option>
                              <?php foreach ($ListadoMarcas as $marca): ?> <!-- Variable creada al principio. Haciendo llamado a ListarMarcas -->
                              <option value="<?= $marca['id'] ?>" 
                                 <?= (!empty($_POST["MARCA"]) && $_POST["MARCA"] == $marca['id']) ? "selected" : ""; ?>> <!-- Verificar datos enviados, selected preselecciona la marca si el usuario ya la chequeo anteriormente (basicamente) -->
                                 <?= $marca['denominacion'] ?>
                              </option>
                              <?php endforeach; ?>
                           </select>
                        </div>

                        <!-- Selector para tipo de transporte -->
                        <div class="col-12">
                           <label for="tipo" class="form-label">Tipo (*)</label>
                           <select class="form-select" id="tipo" name="TIPO">
                              <option value="">Selecciona una opción</option>
                              <?php foreach ($ListadoTipos as $tipo): ?>
                              <option value="<?= $tipo['id'] ?>" 
                                 <?= (!empty($_POST["TIPO"]) && $_POST["TIPO"] == $tipo['id']) ? "selected" : ""; ?>> <!-- Verificar datos enviados -->
                                 <?= $tipo['denominacion'] ?>
                              </option>
                              <?php endforeach; ?>
                           </select>
                        </div>

                        <!-- Patente. 6-7 Caracteres alfanúmericos -->
                        <div class="col-12">
                           <label for="patente" class="form-label">Patente (*)</label>
                           <input type="text" class="form-control" id="patente" name="PATENTE" value="<?= $_POST['PATENTE'] ?? ''; ?>" required>
                        </div>

                        <!-- Modelo de transporte. Limitado a 50 caracteres en la funcion para validar el registro -->
                        <div class="col-12">
                           <label for="modelo" class="form-label">Modelo</label>
                           <input type="text" class="form-control" id="modelo" name="MODELO" value="<?= $_POST['MODELO'] ?? ''; ?>">
                        </div>

                        <!-- Checkbox habilitado -->
                        <div class="col-12">
                           <label class="form-label">Disponibilidad (*)</label>
                           <div class="form-check">
                              <input type="hidden" name="DISPONIBLE" value="0">
                              <input class="form-check-input" type="checkbox" id="habilitado" name="DISPONIBLE" value="1"
                                 <?= (!empty($_POST["DISPONIBLE"]) && $_POST["DISPONIBLE"] == "1") ? "checked" : ""; ?>> <!-- Verificación para comprobar si el checkbox fue igual a 1, se envía -->
                              <label class="form-check-label" for="habilitado">Habilitado</label>
                           </div>
                        </div>

                        <!-- Radio elección nafta -->
                        <div class="col-12">
                           <label class="form-label">Combustible</label>
                           <div class="form-check">
                              <input class="form-check-input" type="radio" id="combustible_gnc" name="COMBUSTIBLE" value="GNC"
                                 <?= (!empty($_POST["COMBUSTIBLE"]) && $_POST["COMBUSTIBLE"] == "GNC") ? "checked" : ""; ?>>
                              <label class="form-check-label" for="combustible_gnc">GNC</label>
                           </div>
                           <div class="form-check">
                              <input class="form-check-input" type="radio" id="combustible_gasoil" name="COMBUSTIBLE" value="Gasoil"
                                 <?= (!empty($_POST["COMBUSTIBLE"]) && $_POST["COMBUSTIBLE"] == "Gasoil") ? "checked" : ""; ?>>
                              <label class="form-check-label" for="combustible_gasoil">Gasoil</label>
                           </div>
                        </div>
                        
                        <!-- Botones de envío formulario-->
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
   </main>
   <!-- End #main -->
</body>
<?php include_once "includes/footer_s.php"?>
</html>