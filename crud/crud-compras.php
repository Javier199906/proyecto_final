<?php
session_start();
$sucursal = $_SESSION['sucursal'];
$usuario = $_SESSION['idUsuario'];
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT id FROM compras ORDER BY id DESC LIMIT 1 ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
foreach ($resultado as $row);
$idCompra = $row["id"];

$producto = (isset($_POST['producto'])) ? $_POST['producto'] : '';
$precio_unitario = (isset($_POST['precio_unitario'])) ? $_POST['precio_unitario'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';

if($precio_unitario && $cantidad){
    $importe = $precio_unitario * $cantidad;
}

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$proveedor = (isset($_POST['proveedor'])) ? $_POST['proveedor'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';

$fecha = date("Y-m-d");
$hora = date("H:i:s");

switch($opcion){
    case 1:
        $consulta = "INSERT INTO detallecompra VALUES(null, '$idCompra', '$producto', '$precio_unitario', '$cantidad', '$importe') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT dc.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dc.precio_unitario, dc.cantidad, dc.importe FROM compras c, detallecompra dc, productos p WHERE dc.compra=c.id AND dc.producto=p.id AND c.id=$idCompra ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE detallecompra SET producto='$producto', precio_unitario='$precio_unitario', cantidad='$cantidad',  importe='$importe' WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT dc.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dc.precio_unitario, dc.cantidad, dc.importe FROM compras c, detallecompra dc, productos p WHERE dc.compra=c.id AND dc.producto=p.id AND c.id=$idCompra AND dc.id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM detallecompra WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4:
        $consulta = "SELECT dc.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dc.precio_unitario, dc.cantidad, dc.importe FROM compras c, detallecompra dc, productos p WHERE dc.compra=c.id AND dc.producto=p.id AND c.id=$idCompra ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $consulta = "DELETE FROM detallecompra WHERE compra='$idCompra' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 6:
        $consulta = "SELECT dc.id, p.id AS id_producto, p.nombre AS producto, p.descripcion, dc.precio_unitario, dc.cantidad, dc.importe FROM compras c, detallecompra dc, productos p WHERE dc.compra=c.id AND dc.producto=p.id AND c.id=$idCompra ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        foreach($resultado as $fila){
            $consulta = "SELECT precio_compra FROM productos WHERE id='" . $fila["id"] . "' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            foreach($resultado as $filaa);

            if($fila["precio_unitario"] > $filaa["precio_compra"]){
                $consulta = "UPDATE productos SET precio_compra='" . $fila["precio_unitario"] . "' WHERE id='" . $fila["id_producto"] . "' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }
        }

        $consulta = "UPDATE compras SET proveedor='$proveedor', total='$total', fecha='$fecha', hora='$hora', usuario='$usuario',sucursal='$sucursal' WHERE id='$idCompra' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "INSERT INTO compras(id) VALUES(null) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 7:
        $consulta = "SELECT SUM(importe) AS total FROM detallecompra WHERE compra='$idCompra' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $row);
        echo (isset($row['total'])) ? $row['total'] : 0;
        exit();
        break;
    case 8:
        $consulta = "SELECT id FROM detallecompra WHERE producto='$producto' AND compra='$idCompra' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $fila);
        echo (isset($fila['id'])) ? $fila['id'] : null;
        exit();
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Envio el array final el formato json a AJAX
$conexion=null;