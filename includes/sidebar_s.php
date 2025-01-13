 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Panel</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php if ($_SESSION['Usuario_Nivel'] == 1): // Habilitar sección para Administrador. Usuario_Nivel tomado de login.php ?> 
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-truck"></i><span>Transporte</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="transporte_carga.php" class="active">
                        <i class="bi bi-file-earmark-plus"></i><span>Cargar nuevo transporte</span>
                    </a>
                </li>
                <li>
                    <a href="chofer_carga.php" class="active">
                        <i class="bi bi-file-earmark-plus"></i><span>Cargar nuevo chofer</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($_SESSION['Usuario_Nivel'] == 1 || $_SESSION['Usuario_Nivel'] == 2): // Habilitar sección tanto para el administrador (1) y Operador (2). Usuario_Nivel tomado de login.php ?>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-globe2"></i><span>Viajes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="viaje_carga.php" class="active">
                        <i class="bi bi-file-earmark-plus"></i><span>Cargar nuevo</span>
                    </a>
                </li>
                <li>
                    <a href="viajes_listado.php" class="active">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Listado de viajes</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($_SESSION['Usuario_Nivel'] == 3): // Chofer ?>
        <li class="nav-item">
            <a href="viajes_listado.php" class="nav-link active">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Mis Viajes</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</aside><!-- End Sidebar-->
