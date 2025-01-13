<?php include_once "includes/head_s.php"?>
<body>
   <?php
      require_once 'funciones/conexion.php'; // Conexion a la db
      require_once 'funciones/login_db.php'; // Funcion consulta a db
      
      $MiConexion = conexion_db(); // Conexión a la base de datos
      $mensaje = '';
      $login = array();
      
      // Validación en servidor PHP verificando que los campos no estén vacíos
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['BotonLogin'])) {
          if (empty($_POST['UserName'])) {
              $mensaje = "Debe ingresar su usuario.";
          } elseif (empty($_POST['Password'])) {
              $mensaje = "Debe ingresar su clave.";
          } else {
              // Validación para la base de datos del usuario
              $login = DatosLogin(trim($_POST['UserName']), $_POST['Password'], $MiConexion);
      
              if (!empty($login)) {
                  // Condicional para validar si el usuario está activo. Un valor = 0, no redirecciona a ninguna parte.
                  if ($login['ESTADO'] == 0) {
                      $mensaje = "Ud. no se encuentra activo en el sistema.";
                  } else {
                      // Guardar datos del usuario en la sesión
                      $_SESSION['Usuario_Nombre'] = $login['NOMBRE']; // login_db.php
                      $_SESSION['Usuario_Apellido'] = $login['APELLIDO']; 
                      $_SESSION['Usuario_Nivel'] = $login['NIVEL'];
      
                      // Redireccionamiento index.php. ABRIR SESIÓN
                      header('Location: index.php');
                      exit;
                  }
              } else { // Mensaje respectivo con error
                  $mensaje = "Los datos son incorrectos. Intenta nuevamente.";
              }
          }
      }
      ?>
   <main>
      <div class="container">
         <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                     <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="assets/img/logo.png" alt="">
                        <span class="d-none d-lg-block">Panel de Administración</span>
                        </a>
                     </div>
                     <!-- End Logo -->
                     <div class="card mb-3">
                        <div class="card-body">
                           <div class="pt-4 pb-2">
                              <h5 class="card-title text-center pb-0 fs-4">Ingresa tu cuenta</h5>
                              <p class="text-center small">Ingresa tu datos de usuario y clave</p>
                           </div>
                           <form class="row g-3 needs-validation" method="POST" novalidate>

                              <?php if (!empty($mensaje)) { ?>
                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                 <i class="bi bi-exclamation-triangle me-1"></i>
                                 <?php echo $mensaje; ?>
                              </div>
                              <?php } ?>

                              <!-- Usuario -->
                              <div class="col-12">
                                 <label for="yourUsername" class="form-label">Usuario</label>
                                 <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    <input class="form-control" id="yourUsername" name="UserName" value="<?php echo !empty($_POST['UserName']) ? $_POST['UserName'] : ''; ?>" required>
                                    <div class="invalid-feedback">Ingresa tu usuario.</div>
                                 </div>
                              </div>

                              <!-- Password -->
                              <div class="col-12">
                                 <label for="yourPassword" class="form-label">Clave</label>
                                 <input class="form-control" id="yourPassword" name="Password" type="password" required>
                                 <div class="invalid-feedback">Ingresa tu clave</div>
                              </div>
                              <div class="col-12">
                                 <button type="submit" name="BotonLogin" class="btn btn-primary w-100" value="Login">Login</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </main>
   <!-- End #main -->
</body>
<?php include_once "includes/footer_s.php"?>
</html>