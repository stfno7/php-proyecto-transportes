
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

 
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/bellota.jpg" alt="Profile" class="rounded-circle"> <!-- Desarrollo dentro del panel, nombre, apellido -->
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['Usuario_Nombre'] . ' ' . $_SESSION['Usuario_Apellido']; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header"> <!-- Dropdown con el nombre y apellido del usuario -->
          <h6><?php echo $_SESSION['Usuario_Nombre'] . ' ' . $_SESSION['Usuario_Apellido']; ?></h6>
           <span>
              <?php // Mal haber implementado un switch?. Nombre del nivel según usuario_nivel
               switch ($_SESSION['Usuario_Nivel']) {
               case 1:
               echo "Administrador";
               break;
               case 2:
               echo "Operador";
               break;
               case 3:
               echo "Chofer";
               break;
               default:
               echo "Sin Rol";
               break;
                }
               ?>
              </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>Mi perfil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-gear"></i>
                <span>Configuraciones</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="cerrarSesion.php"> <!-- Redireccionamiento a cerrarSesion.php -->
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar sesion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->