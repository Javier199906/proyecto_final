<?php
    include_once '../clases/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $consulta = "SELECT id, total, fecha, hora, cliente FROM ventas ORDER BY id DESC LIMIT 1, 1 ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    foreach ($resultado as $row);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
</head>
<body onload="imprimir();">
    <div align="center">
        
    <h1>Ticket De Venta</h1>

    <h4>
    <table>
        <tr><td>FOLIO: <?php echo $row["id"] ?></td></tr>
        <tr><td>FECHA: <?php echo $row["fecha"] ?></td></tr>
        <tr><td>HORA: <?php echo $row["hora"] ?></td></tr>
        <tr><td>******************************************************</td></tr>
        <tr><td>TIENDA</td></tr>
        <tr><td>DIRECCION:</td></tr>
        <tr><td>TELEFONO:</td></tr>
        <tr><td>CORREO ELECTRONICO:<br><br></td></tr>
        <?php
            $consulta = "SELECT c.codigo, p.nombre, p.apellido, p.telefono, p.direccion, ci.nombre AS ciudad FROM clientes c, personas p, ciudades ci WHERE c.persona=p.id AND p.ciudad=ci.id AND c.id='" . $row["cliente"] . "' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            foreach ($resultado as $fila);
        ?>
        <tr><td>****************DATOS DEL CLIENTE*****************</td></tr>
        <tr><td>CODIGO: <?php echo $fila["codigo"] ?></td></tr>
        <tr><td>CLIENTE: <?php echo $fila["nombre"] . " " . $fila["apellido"] ?></td></tr>
        <tr><td>DIRECCION: <?php echo $fila["direccion"] . " " . $fila["ciudad"] ?></tr></td>
        <tr><td>TELEFONO: <?php echo $fila["telefono"] ?><br><br></tr></td>
        <tr><td>==================PRODUCTOS==================</td></tr>
    </table>
    <table>
        <tr>
            <td><h3>   PRODUCTO   </h3></td><td></td>
            <td><h3>   PRECIO     </h3></td><td></td>
            <td><h3>   CANTIDAD   </h3></td><td></td>
            <td><h3>   IMPORTE    </h3></td><td></td>
        </tr>

        <?php
        $consulta = "SELECT CONCAT(p.nombre) AS producto, u.abreviatura AS unidad_medida, dv.precio_unitario, dv.cantidad, dv.importe FROM detalleventa dv, productos p, unidadesmedida u WHERE dv.producto=p.id AND p.unidad_medida=u.id AND dv.venta='" . $row["id"] . "' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $filaa){
        ?>

        <tr>
            <td><?php echo $filaa["producto"] ?></td>
            <td colspan="3"><?php echo $filaa["precio_unitario"] ?></td>
            <td colspan="2"><?php echo $filaa["cantidad"] . " " . $filaa["unidad_medida"] ?></td>
            <td colspan="1"><?php echo $filaa["importe"] ?></td>

        </tr>



        <?php
        }
        ?>
    
    </table>

    <table>
        <tr><td>===============================================<br><br></td></tr>
        <tr><td>TOTAL: $<?php echo $row["total"] ?><br><br></td></tr>
        <tr><td>GRACIAS POR SU COMPRA</td></tr>
    </table>
    </h4>

    </div>
    <script>
        function imprimir(){
            window.print();

            /** A MI ME FUNCIONA CON ESTO, SINO TE FUNCIONA SOLO COMENTALO **/
            setInterval(() => {
                window.close();
            }, 1000);
        }
    </script>
</body>
</html>