<?php
include('../conexion.php');

if(isset($_POST['numero'])){
    $id = $_POST['numero']; //Se asigna los valores a las variables
    $fcodigo = $_POST['codigo'];
    $fcliente = $_POST['cliente'];
    $fcantidad = $_POST['total'];
    $ffecha = $_POST['fecha'];

    $sel = $con->query("SELECT * FROM ventas WHERE id_ventas=$id");


    //Se actualiza la producción
    $up = $con->query("UPDATE ventas SET id_ventas='$id', codigo_venta='$fcodigo', nombre_cliente='$fcliente', total='$fcantidad', fecha='$ffecha' WHERE id_ventas='$id' ");

if($up){

    
    $mensaje="Registro actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}
}


?>

