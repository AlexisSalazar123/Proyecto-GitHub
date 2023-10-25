<?php
    include('conexion.php');

    $id=$_POST['id'];
    $nombre_ingrediente=$_POST['nombre_ingrediente'];
    $cantidad=$_POST['cantidad'];
    $unidad_medida=$_POST['unidad_medida'];
    $cantidad_minima=$_POST['cantidad_minima'];
    $proveedor=$_POST['proveedor'];

    $urlLimpia = "http://localhost/GitHub/Proyecto-GitHub/Inventario/inventario.php";

    $up=$con->query("UPDATE inventario set
                    nombre_ingrediente='$nombre_ingrediente', cantidad='$cantidad', unidad_medida='$unidad_medida', 
                    cantidad_minima='$cantidad_minima', nombre_proveedor='$proveedor' WHERE id_inventario='$id' ");

    if($up){
        header('location:'.$urlLimpia);
    }else{
        header('location:actualizar.php');
    }

?>