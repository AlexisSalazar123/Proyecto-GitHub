<?php   
    include('../conexion.php');

    $nombre=$_POST['nombre'];
    $precio=$_POST['precio'];

    //Proceso para guardar la imagen
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $carpeta_destino = "Img/";
    
            $nombre_archivo = $_FILES["imagen"]["name"];
            $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
    
            if (move_uploaded_file($ubicacion_temporal, $carpeta_destino . $nombre_archivo)) {
                $direccion_imagen = $nombre_archivo;
            }
        }
    }

    //Se inserta todos los datos en productos
    $ins = $con->query("INSERT INTO productos(nombre,foto,precio) values  
                        ('$nombre','$direccion_imagen','$precio')");
    if($ins){
        $mensaje="Registro agregado";
        header("location:index.php?mensaje=".$mensaje);
    }
?>