<?php
    include('conexion.php');
    
    $id = $_REQUEST['id'];
    $del = $con->query("DELETE FROM inventario WHERE id=".$id);
    if($del){
        header('location:inventario.php');
    }
?>