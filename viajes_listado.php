<?php include_once "includes/head_s.php" ?>
<body>
   <?php
      include_once "includes/header_s.php";
      include_once "includes/sidebar_s.php";
      include_once "funciones/conexion.php";
      include_once "funciones/listadoGet.php";
      
      $MiConexion = conexion_db();
      $ListarViaje = ListarViajes($MiConexion);
      session_start();
   ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Lista de viajes registrados</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php">Home</a></li>
               <li class="breadcrumb-item">Viajes</li>
               <li class="breadcrumb-item active">Listado</li>
            </ol>
         </nav>
      </div>
      <!-- End Page Title -->
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Viajes cargados</h5>
                     <!-- Default Table -->
                     <table class="table table-hover">
                        <thead>
                           <tr>
                              <th scope="col">#</th>
                              <th scope="col">Fecha Viaje</th>
                              <th scope="col">Destino</th>
                              <th scope="col">Chofer</th>
                              <th scope="col">Transporte</th>
                              <th scope="col">Costo Viaje</th>
                              <th scope="col">Monto Chofer</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              date_default_timezone_set("America/Argentina/Cordoba");
                              $var = 0;
                              $chofer_logueado = $_SESSION['Usuario_Nivel']; // Obtener id para el chofer
                              $nombreChoferLogueado = $_SESSION['Usuario_Nombre'] . ' ' . $_SESSION['Usuario_Apellido']; // Obtención del nombre completo del chofer (validación de lista de viajes)
                              
                              // Obtener la fecha actual
                              $Fecha_Actual = date('Y-m-d');
                              
                              // Fecha de mañana 
                              $Maniana= date("Y-m-d", strtotime($Fecha_Actual."+ 1 day"));
                              
                              foreach ($ListarViaje as $viajes) {

                                  $var++;
                                  $mensaje = "";
                                  $color = "";
                                  $fechaViaje = $viajes["FECHA_VIAJE"]; 
                              
                                  // Compara las fechas
                                  if ($fechaViaje == $Maniana) {
                                    $mensaje = "El viaje es mañana!";
                                    $color = "warning";
                                } elseif ($fechaViaje == $Fecha_Actual) {
                                    $mensaje = "El viaje es hoy!";
                                    $color = "danger";
                                } elseif ($fechaViaje < $Fecha_Actual) {
                                    $mensaje = "El viaje ya se hizo.";
                                    $color = "success";
                                } elseif ($fechaViaje > $Fecha_Actual) {
                                    $mensaje = "El viaje es en próximos días";
                                    $color = "primary";
                                }
                              
                                  /* Comparar valores. Usuario_Nivel (3 = chofer), strtolower tampoco funciona. El chofer puede ver todos los viajes, pero no filtra el de el
                                  if (strtolower($viajes["APELLIDO"] . ', ' . $viajes["NOMBRE"]) != strtolower($nombreChoferLogueado)) {
                                      continue; // Si el chofer no es el logueado, pasa al siguiente viaje
                                  }
                                  */
                                  // Cálculo del monto para el chofer
                                  $montoChofer = ((($viajes["COSTO_VIAJE"]) * ($viajes["PORCENTAJE_CHOFER"])) / 100);
                                  $montoFormateado = number_format($montoChofer, 0, '', '.');
                                  $usuario_nivel = $_SESSION['Usuario_Nivel']; // Var condicional
                              ?>
                           <tr class="table-<?php echo $color ?>" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?php echo $mensaje?>">
                              <th scope="row"><?php echo $var ?></th>
                              <td><?php echo date('d/m/y', strtotime($viajes["FECHA_VIAJE"])) ?></td> <!-- Fecha formateada en español -->
                              <td><?php echo $viajes["NOM_CIUDAD"] ?></td>
                              <td><?php echo $viajes["APELLIDO"] . ', ' . $viajes["NOMBRE"]; ?></td>
                              <td><?php echo $viajes["NOM_MARCA"] . ' - ' . $viajes["NOM_MODELO"] . ' - ' . $viajes["PATENTE"]; ?></td>
                              <td>$<?php echo number_format($viajes["COSTO_VIAJE"], 0, '', '.') ?></td>

                              <!-- Condicional para mostrar el porcentaje que se lleva el chofer -->
                              <?php
                                 switch ($usuario_nivel) {
                                     case 1:
                                     case 2:
                                         echo "<td>$" . $montoFormateado . ' (' . $viajes["PORCENTAJE_CHOFER"] . '%)</td>';
                                         break;
                                     case 3:
                                         echo "<td>$" . $montoFormateado . '</td>';
                                         break;
                                 }
                                 ?>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                     <!-- End Default Table Example -->
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
