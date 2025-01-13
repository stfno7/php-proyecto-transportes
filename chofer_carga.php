<?php require_once "includes/head_s.php" ?>
<body>
<?php require_once "includes/header_s.php"; ?>
<?php require_once "includes/sidebar_s.php"; ?>
<?php
  require_once 'funciones/conexion.php';
  require_once 'funciones/validarUsuario.php';

      $MiConexion = conexion_db();
      $Mensaje = "";
      $MensajeOk = "";
      if (!empty($_POST['BotonRegistrar'])) {
        $Mensaje = Validar_Datos();
        $DatoFaltante = DatoRequerido();
        if (empty($Mensaje)) {
          if (InsertarUsuarios($MiConexion) != false) {
            $MensajeOk = 'Los datos se guardaron correctamente!';
            $_POST = array();
          }
        }
      }
      ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Registrar un nuevo chofer</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Transportes</li>
          <li class="breadcrumb-item active">Carga Chofer</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        
        <div class="col-lg-6">

            <div class="card">
            <div class="card-body">
            <h5 class="card-title">Ingresa los datos</h5>
              <?php if(!empty($DatoFaltante)) { ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-1"></i>
                    El campo <?php echo $DatoFaltante; ?> (*) es requerido
                </div>
                <?php } ?>
                <?php if (!empty($Mensaje)) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <?php echo $Mensaje; ?>
                </div>
                <?php } ?>
                <?php if(!empty($MensajeOk)) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <?php echo $MensajeOk; ?>
                </div>
                <?php } ?>
                <form class="row g-3" method="POST"> <!-- Formulario metodo POST -->
                
                <!-- Input para apellido -->
                <div class="col-12">
                    <label for="apellido" class="form-label">Apellido (*)</label>
                    <input type="text" class="form-control" id="apellido" name="APELLIDO" value="<?php echo !empty($_POST['APELLIDO']) ? $_POST['APELLIDO'] : ''; ?>">
                </div>
                
                <!-- Input para usuario -->
                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre (*)</label>
                    <input type="text" class="form-control" id="nombre" name="NOMBRE" value="<?php echo !empty($_POST['NOMBRE']) ? $_POST['NOMBRE'] : ''; ?>">
                </div>
                
                <!-- Input para DNI -->
                <div class="col-12">
                    <label for="dni" class="form-label">DNI (*)</label>
                    <input type="text" class="form-control" id="dni" name="DNI" value="<?php echo !empty($_POST['DNI']) ? $_POST['DNI'] : ''; ?>">
                </div>
                <!-- Input password -->            
                <div class="col-12">
                    <label for="password" class="form-label">Clave</label>
                    <input type="password" class="form-control" id="pass" name="PASSWORD" value="<?php echo !empty($_POST['PASSWORD']) ? $_POST['PASSWORD'] : ''; ?>"> <!-- No recomendable -->
                </div>
                 
                <!-- Botones envío formulario -->
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