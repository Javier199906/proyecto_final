<?php
session_start();
$sucursal = $_SESSION['sucursal'];
$usuario = $_SESSION['idUsuario'];
include_once '../clases/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch($opcion){
    case 1:
        $consulta = "SELECT dc.id, p.nombre AS producto, p.descripcion, dc.precio_unitario, dc.cantidad, dc.importe FROM compras c, detallecompra dc, productos p WHERE dc.compra=c.id AND dc.producto=p.id AND c.id=$id ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        ?>
        <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <th hidden>Id</th>
                    <th>Producto</th>
                    <th>Descripcion</th>
                    <th>P.Unitario</th>
                    <th>Cantidad</th>
                    <th>Importe</th>
                </thead>
                <tbody>
                        <?php
                        foreach($resultado as $row){
                            echo "<tr>";
                            echo "<td hidden>". $row["id"] ."</td>";
                            echo "<td>". $row["producto"] ."</td>";
                            echo "<td>". $row["descripcion"] ."</td>";
                            echo "<td>". $row["precio_unitario"] ."</td>";
                            echo "<td>". $row["cantidad"] ."</td>";
                            echo "<td>". $row["importe"] ."</td>";
                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <?php
        exit();
        break;
    case 2:
        $consulta = "SELECT * FROM compras_v WHERE sucursal='$sucursal' AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_fin' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "DELETE FROM compras WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Envio el array final el formato json a AJAX
$conexion=null;