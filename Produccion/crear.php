<?php

include('../conexion.php');

$codigo_agregar = $_POST['codigo'];
$producto_agregar = $_POST['producto'];
$cantidad_agregar = $_POST['cantidad'];

//Se inserta los datos de la nueva producción
$ins=$con->query("INSERT INTO produccion(codigo_produccion,nombre_producto,cantidad)
                     VALUES ('$codigo_agregar','$producto_agregar','$cantidad_agregar')");

if($ins){
    //Se calcula los ingredientes utilizados
    $cantidad_arepas = $cantidad_agregar * 5;
    $cantidad_harina = ($cantidad_arepas / 5) * 0.5;
    $cantidad_mozarella = ($cantidad_arepas / 5) * 0.25;
    $cantidad_fresco = ($cantidad_arepas / 5) * 0.150;
    $cantidad_azucar = ($cantidad_arepas / 5) * 0.02;
    $cantidad_sal = ($cantidad_arepas / 5) * 0.01;
    $cantidad_mantequilla = ($cantidad_arepas / 5) * 0.03;
    $cantidad_agua = ($cantidad_arepas / 5) * 0.35;
    $cantidad_leche = ($cantidad_arepas / 5) * 0.35;

    //Se descuenta del inventario
    $ins_harina = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_harina WHERE nombre_ingrediente = 'Harina'");
    $ins_mozarrella = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_mozarella WHERE nombre_ingrediente = 'queso mozarella'");
    $ins_fresco = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_fresco WHERE nombre_ingrediente = 'queso fresco'");
    $ins_azucar = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_azucar WHERE nombre_ingrediente = 'azucar'");
    $ins_sal = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_sal WHERE nombre_ingrediente = 'sal'");
    $ins_mantequilla = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_mantequilla WHERE nombre_ingrediente = 'mantequilla'");
    $ins_agua = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_agua WHERE nombre_ingrediente = 'agua'");
    $ins_leche = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_leche WHERE nombre_ingrediente = 'leche'");

    //Mensaje que se mostrara en el modal exitosamente
    $mensaje="Registro agregado y el inventario se ha actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}

?>