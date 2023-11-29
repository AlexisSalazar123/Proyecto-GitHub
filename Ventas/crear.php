<?php

include('../conexion.php');

$codigo_agregar = $_POST['codigo'];
$cliente_agregar = $_POST['cliente'];
$producto_agregar = $_POST['producto'];
$cantidad_agregar = $_POST['cantidad'];
$total_agregar = $_POST['total'];
$pago_agregar = $_POST['pago'];

//Se inserta los datos de la nueva producción
$ins=$con->query("INSERT INTO ventas(codigo_venta,nombre_cliente,nombre_producto,cantidad,total,forma_de_pago)
                     VALUES ('$codigo_agregar','$cliente_agregar','$producto_agregar','$cantidad_agregar','$total_agregar','$pago_agregar')");

if($ins){

    //Mensaje que se mostrara en el modal exitosamente
    $mensaje="Registro agregado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}

?>