<?php   
    include('conexion.php');

    $nombre=$_POST['nombre'];
    $precio=$_POST['precio'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $carpeta_destino = "Img/";
    
            $nombre_archivo = $_FILES["imagen"]["name"];
            $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
    
            if (move_uploaded_file($ubicacion_temporal, $carpeta_destino . $nombre_archivo)) {
                $direccion_imagen = $carpeta_destino . $nombre_archivo;
            }
        }
    }

    $ins = $con->query("INSERT INTO productos(nombre,foto,precio) values  
                        ('$nombre','$direccion_imagen','$precio')");
    if($ins){
        header('location:productos.php');
    }
?>