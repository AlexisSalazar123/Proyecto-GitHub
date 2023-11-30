<?php

include('../conexion.php');

$codigo_agregar = $_POST['codigo'];

    $codigo_existente = $con->query("SELECT id_ventas FROM ventas WHERE codigo_venta = '$codigo_agregar' ");
    if ($codigo_existente->num_rows > 0) {
        // El código ya está en uso, mostrar alerta y detener el proceso
        echo "<script>alert('El código ya está en uso. Por favor elija otro.'); window.location.href='index.php';</script>";
        exit();
    }

$cliente_agregar = $_POST['cliente'];
$producto_agregar = $_POST['producto'];
$cantidad_agregar = $_POST['cantidad'];
$pago_agregar = $_POST['pago'];

$sqlPrecio = ("SELECT precio
            FROM productos WHERE `id_productos` = $producto_agregar");
$resultado = mysqli_query($con, $sqlPrecio);

$fila = mysqli_fetch_assoc($resultado);
$precio = $fila['precio'];
$total = $precio * $cantidad_agregar;

//Se inserta los datos de la nueva producción
$ins=$con->query("INSERT INTO ventas(codigo_venta,nombre_cliente,nombre_producto,cantidad,total,forma_pago)
                     VALUES ('$codigo_agregar','$cliente_agregar','$producto_agregar','$cantidad_agregar','$total','$pago_agregar')");

if($ins){

    //Mensaje que se mostrara en el modal exitosamente
    $mensaje="Registro agregado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}

?>