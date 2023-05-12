<?php
    session_start();
    if (!isset($_SESSION['usuario'])) header('Location: login.php');

    include_once '../clases/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $query = $conexion->query("SELECT * FROM sucursales WHERE id=" . $_SESSION['sucursal']);
    foreach ($query as $row)
?>

<!Doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Principal</title>

        <link href="../assets/fonts/icon.css" rel="stylesheet" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/main.css" rel="stylesheet" />
        
        <link href="../assets/datatables/datatables.min.css" rel="stylesheet" />
        <link href="../assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        
        <style type="text/css">
            body{
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
            h1{
                color: black;
                font-size: 80px;
                text-align: center;
            }
            p{
                color: black;
                font-size: 40px;
                text-align: center;
            
            }
            .hola{
                background-color: white;
                color:black;
            }
            .hi{
                background-color: #141212;
                color:white; 
                text-align: justify;
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
            <div class="hola"id="layoutSidenav_content">
           <h1> BIENVENIDO </h1>
           <p>PUNTO DE VENTA</p>
           <center>
         <img src='../assets/img/2.png' class='imgRedonda mb-1'height="100" width="100" />
        </center>
                <main>
                <p class="hi mb-5 mt-5 my-6 md-6 mx-3 px-4 py-3">
   
    Sucursal: <?php echo $row['nombre']?><br/>
    Usuario: <?php echo $_SESSION['usuario']?><br/>
                                    </p>
                </main>



                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">PUNTO DE VENTA</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    
    <script src="../assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/popper/popper.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="../assets/datatables/datatables.min.js"></script>
    <script src="../js/categorias.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/fontawesome/all.min.js"></script>
    <script src="../js/scripts.js"></script>

    </body>
</html>