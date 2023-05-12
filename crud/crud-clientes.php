<?php
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
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$tabla_foranea = (isset($_POST['tabla_foranea'])) ? $_POST['tabla_foranea'] : '';
$nombre_foranea = (isset($_POST['nombre_foranea'])) ? $_POST['nombre_foranea'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_persona = (isset($_POST['id_persona'])) ? $_POST['id_persona'] : '';
$id_cliente = (isset($_POST['id_cliente'])) ? $_POST['id_cliente'] : '';


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

        $consulta = "SELECT id FROM clientes ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        foreach ($resultado as $fila);
        $cliente = $fila["id"];

        if (!$cliente) {
            $codigo = "00000001";
        } else{
            if (strlen($cliente) == 1) {
                $codigo = "0000000" . ($cliente + 1);
            } else if (strlen($cliente) == 2) {
                $codigo = "000000" . ($cliente + 1);
            } else if (strlen($cliente) == 3) {
                $codigo = "00000" . ($cliente + 1);
            } else if (strlen($cliente) == 4) {
                $codigo = "0000" . ($cliente + 1);
            } else if (strlen($cliente) == 5) {
                $codigo = "000" . ($cliente + 1);
            } else if (strlen($cliente) == 6) {
                $codigo = "00" . ($cliente + 1);
            } else if (strlen($cliente) == 7) {
                $codigo = "0" . ($cliente + 1);
            } else if (strlen($cliente) == 8) {
                $codigo = "" . ($cliente + 1);
            }
        } 

        $consulta = "INSERT INTO clientes VALUES(null, '$codigo', $persona, $estado) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM clientes_v ORDER BY id DESC LIMIT 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE personas SET nombre='$nombre', apellido='$apellido', correo_electronico='$correo_electronico', telefono='$telefono', fecha_nacimiento='$fecha_nacimiento', direccion='$direccion', ciudad=$ciudad, estado=$estado WHERE id='$id_persona' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "UPDATE clientes SET estado=$estado WHERE id='$id_cliente' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM clientes_v WHERE id_cliente='$id_cliente' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "CALL eliminar_cliente($id_persona, $id_cliente) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;

        /*
        $consulta = "DELETE FROM clientes WHERE id='$id_cliente' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "DELETE FROM personas WHERE id='$id_persona' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
        */
    case 4:
        $consulta = "SELECT * FROM clientes_v ";
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