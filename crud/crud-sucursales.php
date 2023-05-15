<?php
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$ciudad = (isset($_POST['ciudad'])) ? $_POST['ciudad'] : '';

$tabla_foranea = (isset($_POST['tabla_foranea'])) ? $_POST['tabla_foranea'] : '';
$nombre_foranea = (isset($_POST['nombre_foranea'])) ? $_POST['nombre_foranea'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO sucursales VALUES(null, '$nombre', '$direccion', $ciudad) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT s.id, s.nombre, s.direccion, c.nombre AS ciudad FROM sucursales s, ciudades c WHERE s.ciudad=c.id ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE sucursales SET nombre='$nombre', direccion='$direccion', ciudad=$ciudad WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT s.id, s.nombre, s.direccion, c.nombre AS ciudad FROM sucursales s, ciudades c WHERE s.ciudad=c.id AND s.id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM sucursales WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT s.id, s.nombre, s.direccion, c.nombre AS ciudad FROM sucursales s, ciudades c WHERE s.ciudad=c.id ";
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