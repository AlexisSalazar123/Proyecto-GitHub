<?php
    include('conexion.php');
    
    $id = $_REQUEST['id_productos'];
    $del = $con->query("DELETE FROM productos WHERE id_productos=".$id);
    if($del){
        header('location:productos.php');
    }
?>