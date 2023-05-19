<?php
    session_start();
    if (!isset($_SESSION['usuario'])) header('Location: login.php');
    if ($_SESSION['rol'] != 1) header('Location: index.php');
?>

<!Doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Reportes</title>
        
        <link href="../assets/fonts/icon.css" rel="stylesheet" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/main.css" rel="stylesheet" />
        
        <link href="../assets/datatables/datatables.min.css" rel="stylesheet" />
        <link href="../assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

        <style type="text/css">  
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                margin: 0; 
            }
            
            input[type=number] { 
                -moz-appearance: textfield; 
            }

            #tabla-compras tr > *:nth-child(1) {
                display: none;
            }

            #tabla-ventas tr > *:nth-child(1) {
                display: none;
            }
        </style>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Punto de Venta</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="cerrar-sesion.php">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">MENU</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Principal
                            </a>
                            <a class="nav-link" href="clientes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                                Clientes
                            </a>
                            <?php
                                if($_SESSION['rol'] == 1){
                            ?>
                            <a class="nav-link" href="compras.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Compras
                            </a>
                            <?php
                                }
                            ?>
                            <a class="nav-link" href="productos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                Productos
                            </a>
                            <?php
                                if($_SESSION['rol'] == 1){
                            ?>
                            <a class="nav-link" href="proveedores.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Proveedores
                            </a>
                            <?php
                                }
                            ?>
                            <?php
                                if($_SESSION['rol'] == 1){
                            ?>
                            <a class="nav-link" href="reportes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder"></i></div>
                                Reportes
                            </a>
                            <?php
                                }
                            ?>
                            <?php
                                if($_SESSION['rol'] == 1){
                            ?>
                            <a class="nav-link" href="sucursales.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                Sucursales
                            </a>
                            <?php
                                }
                            ?>
                            <?php
                                if($_SESSION['rol'] == 1){
                            ?>
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                            </a>
                            <?php
                                }
                            ?>
                            <a class="nav-link" href="ventas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Ventas
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Configuracion
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <?php
                                    if($_SESSION['rol'] == 1){
                                    ?>
                                    <a class="nav-link" href="categorias.php">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                        Categorias
                                    </a>
                                    <?php
                                        }
                                    ?>
                                    <a class="nav-link" href="medidas.php">
                                        <div class="sb-nav-link-icon"><i class="fas fa-ruler-horizontal"></i></div>
                                        Unidades de Medida
                                    </a>
                                    <a class="nav-link" href="ciudades.php">
                                        <div class="sb-nav-link-icon"><i class="fas fa-city"></i></div>
                                        Ciudades
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages"></div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Usuario accedido:</div>
                        <?php echo $_SESSION['usuario']?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Reportes</h1>
                        <br>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Compras
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <h4 class="mt-4">Compras</h2>
                                        <form id="form-compras">
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="fecha-inicio-c" type="date" placeholder="Desde" autocomplete="off" />
                                                        <label for="fecha-inicio-c">Desde</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="fecha-fin-c" type="date" placeholder="Hasta" autocomplete="off" />
                                                        <label for="fecha-fin-c">Hasta</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-primary" type="submit" id="btnGenerar-c">Generar</button>
                                                    <button class="btn btn-danger" type="button" id="btnLimpiar-c">Limpiar</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-folder"></i>
                                                Compras
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="tabla-compras" class="table" style="width:100%" >
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Usuario</th>
                                                                <th>Fecha</th>
                                                                <th>Hora</th>
                                                                <th>Proveedor</th>
                                                                <th>Total</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Ventas
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <h4 class="mt-4">Ventas</h2>
                                        <form id="form-ventas">
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="fecha-inicio-v" type="date" placeholder="Desde" autocomplete="off" />
                                                        <label for="fecha-inicio-v">Desde</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="fecha-fin-v" type="date" placeholder="Hasta" autocomplete="off" />
                                                        <label for="fecha-fin-v">Hasta</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-primary" type="submit" id="btnGenerar-v">Generar</button>
                                                    <button class="btn btn-danger" type="button" id="btnLimpiar-v">Limpiar</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-folder"></i>
                                                Ventas
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="tabla-ventas" class="table" style="width:100%" >
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Usuario</th>
                                                                <th>Fecha</th>
                                                                <th>Hora</th>
                                                                <th>Cliente</th>
                                                                <th>Total</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                           
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!--Modal para CRUD-->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-12" id="traertabla"></div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    
    <script src="../assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/popper/popper.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="../assets/datatables/datatables.min.js"></script>
    <script src="../assets/buttons-datatables/dataTables.buttons.min.js"></script>
    <script src="../assets/buttons-datatables/jszip.min.js"></script>
    <script src="../assets/buttons-datatables/pdfmake.min.js"></script>
    <script src="../assets/buttons-datatables/vfs_fonts.js"></script>
    <script src="../assets/buttons-datatables/buttons.html5.min.js"></script>
    <script src="../assets/buttons-datatables/buttons.print.min.js"></script>
    <script src="../js/reportes-compras.js"></script>
    <script src="../js/reportes-ventas.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/fontawesome/all.min.js"></script>
    <script src="../js/scripts.js"></script>

    </body>
</html>