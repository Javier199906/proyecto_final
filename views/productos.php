<?php
    session_start();
    if (!isset($_SESSION['usuario'])) header('Location: login.php');

    include_once '../clases/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $query = $conexion->query("SELECT * FROM unidadesmedida WHERE estado=1 ");
?>

<!Doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Productos</title>

        <link href="../assets/fonts/icon.css" rel="stylesheet" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/main.css" rel="stylesheet" />
        
        <link href="../assets/datatables/datatables.min.css" rel="stylesheet" />
        <link href="../assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="../assets/buttons-datatables/buttons.dataTables.min.css" rel="stylesheet" />

        <style type="text/css">  
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                margin: 0; 
            }
            
            input[type=number] { 
                -moz-appearance: textfield; 
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
                        <h1 class="mt-4">Productos</h1>
                        <br>
                        <div>
                            <div class="row">
                                <div>         
                                    <button id="btnNuevo" type="button" class="btn btn-primary" data-toggle="modal">Nuevo</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-store"></i>
                                Productos Registrados
                            </div>
                            <div class="card-body">
                                <table id="tabla" class="table" style="width:100%" >
                                    <thead class="text-center">
                                        <tr>
                                            <th>Id</th>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>U.Medida</th>
                                            <th>Categoria</th>
                                            <th>P.Compra</th>
                                            <th>P.Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
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
                    <form id="form">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="nombre" type="text" placeholder="Nombre" autocomplete="off" />
                                        <label for="nombre">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <textarea class="form-control" id="descripcion" placeholder="Descripcion" autocomplete="off"></textarea>
                                        <label for="descripcion">Descripcion</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select class="form-select" id="unidad-medida">
                                        <option value="0">Unidad de Medida</option>
                                        <?php
                                        foreach ($query as $row){
                                            ?>
                                            <option value="<?=$row['id']?>"><?=$row['nombre']?></option>
                                            <?php
                                        }

                                        $query = $conexion->query("SELECT * FROM categorias WHERE estado=1 ");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" id="categoria">
                                        <option value="0">Categoria</option>
                                        <?php
                                        foreach ($query as $row){
                                            ?>
                                            <option value="<?=$row['id']?>"><?=$row['nombre']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="precio-compra" type="number" placeholder="Precio de Compra" autocomplete="off" />
                                        <label for="precio-compra">Precio de Compra</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="precio-venta" type="number" placeholder="Precio de Venta" autocomplete="off" />
                                        <label for="precio-venta">Precio de Venta</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="input-estado" type="number" placeholder="Estado" autocomplete="off" />
                                        <label for="input-estado" id="label-estado">Estado</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnGuardar" class="btn btn-danger">Guardar</button>
                        </div>
                    </form>
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
    <script src="../js/productos.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/fontawesome/all.min.js"></script>
    <script src="../js/scripts.js"></script>

    </body>
</html>