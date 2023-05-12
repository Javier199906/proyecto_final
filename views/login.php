<?php
    session_start();
    if (isset($_SESSION['usuario'])) header('Location: index.php');

    include_once '../clases/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $query = $conexion->query("SELECT * FROM sucursales ");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Login</title>

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/main.css" rel="stylesheet" />

        <style type="text/css">
            body{
             
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
        </style>
    </head>
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content"><br><br><br>
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-1 bg-dark mb-1">
                                    <div class="card-header"><h3 class="text-center text-white font-weight-light my-4 mb-2">INICIO DE SESIÓN</h3></div>
                                    <div class="card-body">
                                        <center>
                                    <img src='../assets/img/2.png' class='imgRedonda mb-2'height="100" width="100" />
                                        </center>
                                      
                                        
                                        <form method="POST">
                                            <div class="form-floating mb-2">
                                                <input class="form-control" id="username" name="username" type="text" placeholder="Nombre de Usuario" autocomplete="off" />
                                                <label for="username">Nombre de Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Contraseña" autocomplete="off" />
                                                <label for="password">Contraseña</label>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <select class="form-select" id="sucursal" name="sucursal">
                                                    <option value="0">Sucursal</option>
                                                    <?php
                                                    foreach ($query as $row){
                                                        ?>
                                                        <option value="<?=$row['id']?>"><?=$row['nombre']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <br>
                                                <button type="submit" class="btn btn-light">Acceder</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                    <?php 
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
                                        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
                                        $sucursal = isset($_REQUEST['sucursal']) ? intval($_REQUEST['sucursal']) : null;

                                        $consulta = "SELECT id, password, rol FROM usuarios WHERE username='$username' and estado=1 ";
                                        $resultado = $conexion->prepare($consulta);
                                        $resultado->execute();

                                        foreach ($resultado as $row);
                                        $usuario = isset($row["id"]) ? $row["id"] : null;
                                        $contraseña = isset($row["password"]) ? $row["password"] : null;
                                        $rol = isset($row["rol"]) ? $row["rol"] : null;

                                        $consulta = "SELECT sucursal FROM usuarios_sucursales WHERE usuario='$usuario' ";
                                        $resultado = $conexion->prepare($consulta);
                                        $resultado->execute();

                                        foreach ($resultado as $fila);
                                        $_sucursal = isset($fila["sucursal"]) ? intval($fila["sucursal"]) : null;

                                        if (password_verify($password, $contraseña) && $sucursal == $_sucursal) {
                                            session_start();
                                            $_SESSION['usuario'] = $_REQUEST['username'];
                                            $_SESSION['idUsuario'] = $usuario;
                                            $_SESSION['sucursal'] = $_sucursal;
                                            $_SESSION['rol'] = $rol;
                                            header('Location: index.php');
                                            die();
                                        } else {
                                            echo '<p id="error" class="text-danger">USUARIO, CONTRASEÑA O SUCURSAL INCORRECTA</p>';
                                        }

                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div>
                              
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <script src="../assets/jquery/jquery-3.3.1.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/fontawesome/all.min.js"></script>
        <script src="../js/scripts.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() { 
                    $("#error").hide();
                }, 5000);
            });
        </script>
        
    </body>
</html>