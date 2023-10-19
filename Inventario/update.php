<?php
    include('conexion.php');

    $id=$_POST['id'];
    $producto=$_POST['producto'];
    $stock=$_POST['stock'];
    $precio=$_POST['precio'];

    $up=$con->query("UPDATE inventario set
                    producto='$producto', stock='$stock', precio='$precio'
                    WHERE id='$id' ");

    if($up){
        header('location:inventario.php');
    }else{
        header('location:actualizar.php');
    }

?>