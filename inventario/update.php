<?php
include('../conexion.php');

$id = $_POST['numero']; //Se asigna los valores a las variables
$ingrediente = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$Umedida = $_POST['Umedida'];
$Cminima = $_POST['Cminima'];
$proveedor = $_POST['proveedor'];


    //Se actualiza el inventario
    $up = $con->query("UPDATE inventario SET
                     id_inventario='$id', nombre_ingrediente='$ingrediente', cantidad='$cantidad', unidad_medida='$Umedida', cantidad_minima='$Cminima', nombre_proveedor='$proveedor'
                     WHERE id_inventario='$id' ");
                

if($up){

    
    $mensaje="Registro actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}



?>






