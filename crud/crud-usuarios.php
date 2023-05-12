<?php
session_start();
$sucursal = $_SESSION['sucursal'];
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : '';
$correo_electronico = (isset($_POST['correo_electronico'])) ? $_POST['correo_electronico'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$fecha_nacimiento = (isset($_POST['fecha_nacimiento'])) ? $_POST['fecha_nacimiento'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$ciudad = (isset($_POST['ciudad'])) ? $_POST['ciudad'] : '';
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$contraseña = (isset($_POST['contraseña'])) ? $_POST['contraseña'] : '';

$opciones = [
    'cost' => 10
];
$password = password_hash($contraseña, PASSWORD_BCRYPT, $opciones);

$rol = (isset($_POST['rol'])) ? $_POST['rol'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$tabla_foranea = (isset($_POST['tabla_foranea'])) ? $_POST['tabla_foranea'] : '';
$nombre_foranea = (isset($_POST['nombre_foranea'])) ? $_POST['nombre_foranea'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_persona = (isset($_POST['id_persona'])) ? $_POST['id_persona'] : '';
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO personas VALUES(null, '$nombre', '$apellido', '$correo_electronico', '$telefono', '$fecha_nacimiento', '$direccion', $ciudad, $estado) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT id FROM personas ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        $persona = $row["id"];

        $consulta = "INSERT INTO usuarios VALUES(null, '$username', '$password', $persona, $rol, $estado) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT id FROM usuarios ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $fila);
        $usuario = $fila["id"];

        $consulta = "INSERT INTO usuarios_sucursales VALUES(null, $usuario, $sucursal) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM usuarios_v WHERE  sucursal=$sucursal ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE personas SET nombre='$nombre', apellido='$apellido', correo_electronico='$correo_electronico',  telefono='$telefono', fecha_nacimiento='$fecha_nacimiento', direccion='$direccion', ciudad=$ciudad, estado=$estado WHERE id='$id_persona' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "UPDATE usuarios SET username='$username', rol=$rol, estado=$estado WHERE id='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM usuarios_v WHERE  sucursal=$sucursal AND id_usuario='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "CALL eliminar_usuario($id_persona, $id_usuario) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;

        /*
        $consulta = "DELETE FROM usuarios_sucursales WHERE usuario='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "DELETE FROM usuarios WHERE id='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "DELETE FROM personas WHERE id='$id_persona' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
        */
    case 4:
        $consulta = "SELECT * FROM usuarios_v WHERE sucursal=$sucursal ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $consulta = "SELECT id FROM " . $tabla_foranea . " WHERE nombre='$nombre_foranea' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo $row["id"];
        exit();
        break;
    case 6:
        $consulta = "SELECT id FROM usuarios WHERE username='$username' && NOT id='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo (isset($row['id'])) ? $row['id'] : null;
        exit();
        break;
    case 7:
        $consulta = "UPDATE usuarios SET password='$password' WHERE id='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
            
        $consulta = "SELECT * FROM usuarios_v WHERE  sucursal=$sucursal AND id_usuario='$id_usuario' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Envio el array final el formato json a AJAX
$conexion=null;