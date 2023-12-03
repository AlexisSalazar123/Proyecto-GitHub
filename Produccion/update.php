<?php
include('../conexion.php');

if(isset($_POST['numero'])){
    $id = $_POST['numero']; //Se asigna los valores a las variables
    $codigo = $_POST['codigo'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fecha = $_POST['fecha'];

    $codigo_existente = $con->query("SELECT id_produccion FROM produccion WHERE codigo_produccion = '$codigo' AND id_produccion <> $id");
    if ($codigo_existente->num_rows > 0) {
        // El código ya está en uso, mostrar alerta y detener el proceso
        echo "<script>alert('El código ya está en uso. Por favor elija otro.'); window.location.href='index.php';</script>";
        exit();
    }

    //Consulta que selecciona la cantidad de arepas de la produccion
    $sel = $con->query("SELECT cantidad FROM produccion WHERE id_produccion=". $id);
    $cantidad_anterior = $sel->fetch_assoc();

    $cantidad_anterior_valor = $cantidad_anterior['cantidad'];

    //se calcula los ingredientes utilizados
    $cantidad_arepas = $cantidad_anterior_valor * 5;
    $cantidad_harina = ($cantidad_arepas / 5) * 0.5;
    $cantidad_mozarella = ($cantidad_arepas / 5) * 0.25;
    $cantidad_fresco = ($cantidad_arepas / 5) * 0.150;
    $cantidad_azucar = ($cantidad_arepas / 5) * 0.02;
    $cantidad_sal = ($cantidad_arepas / 5) * 0.01;
    $cantidad_mantequilla = ($cantidad_arepas / 5) * 0.03;
    $cantidad_agua = ($cantidad_arepas / 5) * 0.35;
    $cantidad_leche = ($cantidad_arepas / 5) * 0.35;

    //Se devuelve la materia anterior al inventario sumandolo
    $ins_harina = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_harina WHERE nombre_ingrediente = 'Harina'");
    $ins_mozarrella = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_mozarella WHERE nombre_ingrediente = 'Queso mozarella'");
    $ins_fresco = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_fresco WHERE nombre_ingrediente = 'Queso fresco'");
    $ins_azucar = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_azucar WHERE nombre_ingrediente = 'Azucar'");
    $ins_sal = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_sal WHERE nombre_ingrediente = 'Sal'");
    $ins_mantequilla = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_mantequilla WHERE nombre_ingrediente = 'Mantequilla'");
    $ins_agua = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_agua WHERE nombre_ingrediente = 'Agua'");
    $ins_leche = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_leche WHERE nombre_ingrediente = 'Leche'");

    //Se calcula los ingredientes de la producción editada
    $cantidad_add = $cantidad * 5;
    $cantidad_harina = ($cantidad_add / 5) * 0.5;
    $cantidad_mozarella = ($cantidad_add / 5) * 0.25;
    $cantidad_fresco = ($cantidad_add / 5) * 0.150;
    $cantidad_azucar = ($cantidad_add / 5) * 0.02;
    $cantidad_sal = ($cantidad_add / 5) * 0.01;
    $cantidad_mantequilla = ($cantidad_add / 5) * 0.03;
    $cantidad_agua = ($cantidad_add / 5) * 0.35;
    $cantidad_leche = ($cantidad_add / 5) * 0.35;

    //Se descuenta la materia de la producción editada
    $ins_harina = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_harina WHERE nombre_ingrediente = 'Harina'");
    $ins_mozarrella = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_mozarella WHERE nombre_ingrediente = 'Queso mozarella'");
    $ins_fresco = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_fresco WHERE nombre_ingrediente = 'Queso fresco'");
    $ins_azucar = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_azucar WHERE nombre_ingrediente = 'Azucar'");
    $ins_sal = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_sal WHERE nombre_ingrediente = 'Sal'");
    $ins_mantequilla = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_mantequilla WHERE nombre_ingrediente = 'Mantequilla'");
    $ins_agua = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_agua WHERE nombre_ingrediente = 'Agua'");
    $ins_leche = $con->query("UPDATE inventario SET cantidad = cantidad - $cantidad_leche WHERE nombre_ingrediente = 'Leche'");

    //Se actualiza la producción
    $up = $con->query("UPDATE produccion SET
                     id_produccion='$id', codigo_produccion='$codigo', nombre_producto='$producto', cantidad='$cantidad', fecha='$fecha'
                     WHERE id_produccion='$id' ");
                

if($up){

    
    $mensaje="Registro actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}
}

?>






