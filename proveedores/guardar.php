<?php   
    include('../conexion.php');

    $nombre=$_POST['nombreP'];
    $razon=$_POST['razonS'];
    $direccion=$_POST['direccion'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $carpeta_destino = "Img/";
    
            $nombre_archivo = $_FILES["imagen"]["name"];
            $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
    
            if (move_uploaded_file($ubicacion_temporal, $carpeta_destino . $nombre_archivo)) {
                $direccion_imagen = $nombre_archivo;
            }
        }
    }

    $ins = $con->query("INSERT INTO proveedor(nombre,foto,razon_social,direccion,telefono,correo) values  
                        ('$nombre','$direccion_imagen','$razon','$direccion','$telefono','$correo')");
    if($ins){
        $mensaje="Registro agregado";
        header("location:index.php?mensaje=".$mensaje);
    }
?>