<?php
    include('conexion.php');
    
    $id = $_REQUEST['id_inventario'];
    $del = $con->query("DELETE FROM inventario WHERE id_inventario=".$id);
    if($del){
        header('location:inventario.php');
    }
?>