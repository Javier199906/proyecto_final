<?php
session_start();
$sucursal = $_SESSION['sucursal'];
$usuario = $_SESSION['idUsuario'];
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT id FROM ventas ORDER BY id DESC LIMIT 1 ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
foreach ($resultado as $row);
$idVenta = $row["id"];

$producto = (isset($_POST['producto'])) ? $_POST['producto'] : '';
$precio_unitario = (isset($_POST['precio_unitario'])) ? $_POST['precio_unitario'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';

if($precio_unitario && $cantidad){
    $importe = $precio_unitario * $cantidad;
}

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$cliente = (isset($_POST['cliente'])) ? $_POST['cliente'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';

$fecha = date("Y-m-d");
$hora = date("H:i:s");

switch($opcion){
    case 1:
        $consulta = "SELECT id FROM detalleventa WHERE producto='$producto' AND venta='$idVenta' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $fila);
        if($fila['id']){
            $consulta = "UPDATE detalleventa SET cantidad=cantidad+'$cantidad',  importe=importe+'$importe' WHERE id='" . $fila["id"] . "' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            break;
        }else{
            $consulta = "INSERT INTO detalleventa VALUES(null, '$idVenta', '$producto', '$precio_unitario', '$cantidad', '$importe') ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            
            $consulta = "SELECT dv.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dv.precio_unitario, dv.cantidad, dv.importe FROM ventas v, detalleventa dv, productos p WHERE dv.venta=v.id AND dv.producto=p.id AND v.id=$idVenta ORDER BY id DESC LIMIT 1 ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            break;
        }
    case 2:
        $consulta = "UPDATE detalleventa SET producto='$producto', precio_unitario='$precio_unitario', cantidad='$cantidad',  importe='$importe' WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT dv.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dv.precio_unitario, dv.cantidad, dv.importe FROM ventas v, detalleventa dv, productos p WHERE dv.venta=v.id AND dv.producto=p.id AND v.id=$idVenta AND dc.id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM detalleventa WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT dv.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dv.precio_unitario, dv.cantidad, dv.importe FROM ventas v, detalleventa dv, productos p WHERE dv.venta=v.id AND dv.producto=p.id AND v.id=$idVenta ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $consulta = "DELETE FROM detalleventa WHERE venta='$idVenta' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 6:
        $consulta = "UPDATE ventas SET cliente='$cliente', total='$total', fecha='$fecha', hora='$hora', usuario='$usuario',sucursal='$sucursal' WHERE id='$idVenta' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "INSERT INTO ventas(id) VALUES(null) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 7:
        $consulta = "SELECT SUM(importe) AS total FROM detalleventa WHERE venta='$idVenta' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo (isset($row['total'])) ? $row['total'] : 0;
        exit();
        break;
    case 8:
        $consulta = "SELECT precio_venta FROM productos WHERE id='$producto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo $row['precio_venta'];
        exit();
        break;
    case 9:
        $consulta = "SELECT stock FROM productos WHERE id='$producto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo $row['stock'];
        exit();
        break;
    case 10:
        $consulta = "SELECT precio_compra FROM productos WHERE id='$producto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo $row['precio_compra'];
        exit();
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Envio el array final el formato json a AJAX
$conexion=null;