<?php   
    include('../conexion.php');

    $nombre=$_POST['nombre2'];
    $nombreCo=$_POST['nombreCo'];
    $rol=$_POST['rol2'];
    $contra=$_POST['contraseña'];
    $correo=$_POST['correo'];

    $correo_existente = $con->query("SELECT COUNT(*) as TotalRe FROM usuario WHERE email = '$correo' OR contraseña = '$contra' OR usuario = '$nombre' ");
    $row = $correo_existente->fetch_assoc();
    $totalRegistros = $row['TotalRe'];

    if ($totalRegistros > 0) {
        echo "<script>alert('El usuario, correo o contraseña ya está en uso. Por favor elija otro.'); window.location.href='index.php';</script>";
        exit();
    }

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

    $ins = $con->query("INSERT INTO usuario(nombre,usuario,rol,contraseña,foto,email) values  
                        ('$nombreCo','$nombre','$rol','$contra','$direccion_imagen','$correo')");
    if($ins){
        $mensaje="Registro agregado";
        header("location:index.php?mensaje=".$mensaje);
    }
?>