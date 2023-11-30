<?php
include('../conexion.php');

if(isset($_POST['idCliente'])){
    $id = $_POST['idCliente']; //Se asigna los valores a las variables
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion =$_POST['direccion'];

    //Se actualiza el cliente
    $up = $con->query("UPDATE clientes SET
                     id_cliente='$id', nombre='$nombre', correo='$correo', telefono='$telefono', direccion='$direccion'
                     WHERE id_cliente='$id' ");
                

if($up){ 
    $mensaje="Registro actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}
}


?>






