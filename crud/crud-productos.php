<?php
session_start();
$sucursal = $_SESSION['sucursal'];
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$unidad_medida = (isset($_POST['unidad_medida'])) ? $_POST['unidad_medida'] : '';
$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';
$precio_compra = (isset($_POST['precio_compra'])) ? $_POST['precio_compra'] : '';
$precio_venta = (isset($_POST['precio_venta'])) ? $_POST['precio_venta'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$tabla_foranea = (isset($_POST['tabla_foranea'])) ? $_POST['tabla_foranea'] : '';
$nombre_foranea = (isset($_POST['nombre_foranea'])) ? $_POST['nombre_foranea'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch($opcion){
    case 1:
        $consulta = "SELECT id FROM productos ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $fila);
        $producto = (isset($fila["id"])) ? $fila["id"] : null;

        if (!$producto) {
            $codigo = "00000001";
        } else{
            if (strlen($producto) == 1) {
                $codigo = "0000000" . ($producto + 1);
            } else if (strlen($producto) == 2) {
                $codigo = "000000" . ($producto + 1);
            } else if (strlen($producto) == 3) {
                $codigo = "00000" . ($producto + 1);
            } else if (strlen($producto) == 4) {
                $codigo = "0000" . ($producto + 1);
            } else if (strlen($producto) == 5) {
                $codigo = "000" . ($producto + 1);
            } else if (strlen($producto) == 6) {
                $codigo = "00" . ($producto + 1);
            } else if (strlen($producto) == 7) {
                $codigo = "0" . ($producto + 1);
            } else if (strlen($producto) == 8) {
                $codigo = "" . ($producto + 1);
            }
        }

        $consulta = "INSERT INTO productos VALUES(null, '$codigo', '$nombre', '$descripcion', '$unidad_medida', '$categoria', '$precio_compra', '$precio_venta', 0, $sucursal, $estado) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM productos_v WHERE sucursal=$sucursal ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', unidad_medida='$unidad_medida', categoria='$categoria', precio_compra='$precio_compra', precio_venta='$precio_venta', estado=$estado WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM productos_v WHERE sucursal=$sucursal AND id_producto='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM productos WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT * FROM productos_v WHERE sucursal=$sucursal ";
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