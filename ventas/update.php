<?php
include('../conexion.php');

if(isset($_POST['numero'])){
    $id = $_POST['numero']; //Se asigna los valores a las variables
    $fcodigo = $_POST['codigo'];
    $fcliente = $_POST['cliente'];
    $fcantidad = $_POST['cantidad'];
    $ffecha = $_POST['fecha'];
    $producto = $_POST['producto2'];
    $pago_agregar = $_POST['pago'];

    $codigo_existente = $con->query("SELECT id_ventas FROM ventas WHERE codigo_venta = '$fcodigo' AND id_ventas <> $id");
    if ($codigo_existente->num_rows > 0) {
        //mostra alerta y sale
        echo "<script>alert('El código ya está en uso. Por favor elija otro.'); window.location.href='index.php';</script>";
        exit();
    }

    $sqlPrecio = ("SELECT precio
            FROM productos WHERE `id_productos` = $producto");
$resultado = mysqli_query($con, $sqlPrecio);

$fila = mysqli_fetch_assoc($resultado);
$precio = $fila['precio'];
$total = $precio * $fcantidad;

    //Se actualiza ventas
    $up = $con->query("UPDATE ventas SET id_ventas='$id', nombre_producto='$producto', codigo_venta='$fcodigo', nombre_cliente='$fcliente', cantidad='$fcantidad', total='$total', fecha='$ffecha', forma_pago='$pago_agregar' WHERE id_ventas='$id' ");

if($up){

    
    $mensaje="Registro actualizado";
    header("location:index.php?mensaje=".$mensaje);
}else{
    header('location:index.php');
}
}


?>

