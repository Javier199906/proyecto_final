<?php
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$correo_electronico = (isset($_POST['correo_electronico'])) ? $_POST['correo_electronico'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$ciudad = (isset($_POST['ciudad'])) ? $_POST['ciudad'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$tabla_foranea = (isset($_POST['tabla_foranea'])) ? $_POST['tabla_foranea'] : '';
$nombre_foranea = (isset($_POST['nombre_foranea'])) ? $_POST['nombre_foranea'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO proveedores VALUES(null, '$nombre', '$correo_electronico', '$telefono', '$direccion', $ciudad, $estado) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT p.id, p.nombre, p.correo_electronico, p.telefono, p.direccion, c.nombre AS ciudad, p.estado FROM proveedores p, ciudades c WHERE p.ciudad=c.id ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE proveedores SET nombre='$nombre', correo_electronico='$correo_electronico', telefono='$telefono', direccion='$direccion', ciudad=$ciudad, estado=$estado WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT p.id, p.nombre, p.correo_electronico, p.telefono, p.direccion, c.nombre AS ciudad, p.estado FROM proveedores p, ciudades c WHERE p.ciudad=c.id AND p.id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM proveedores WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT p.id, p.nombre, p.correo_electronico, p.telefono, p.direccion, c.nombre AS ciudad, p.estado FROM proveedores p, ciudades c WHERE p.ciudad=c.id ";
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
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Envio el array final el formato json a AJAX
$conexion=null;