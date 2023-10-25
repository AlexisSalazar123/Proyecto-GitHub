<?php   
    include('conexion.php');

    $nombre_ingrediente=$_POST['nombre_ingrediente'];
    $cantidad=$_POST['cantidad'];
    $unidad_medida=$_POST['unidad_medida'];
    $cantidad_minima=$_POST['cantidad_minima'];
    $proveedor=$_POST['proveedor'];

    $ins = $con->query("INSERT INTO inventario(nombre_ingrediente,cantidad,unidad_medida,cantidad_minima,nombre_proveedor) values
    ('$nombre_ingrediente','$cantidad','$unidad_medida','$cantidad_minima','$proveedor')");

    if($ins){
        header('location:inventario.php');
    }
?>