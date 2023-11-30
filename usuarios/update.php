<?php
    include('../conexion.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = $_POST['numero'];
        $nombreCo = $_POST['nombreC'];
        $nombre = $_POST['nombre'];
        $rol = $_POST['rol'];
        $contraseña = $_POST['contraseña2'];
        $correo = $_POST['correo2'];

        $usuario_existente = $con->query("SELECT id_usuario FROM usuario WHERE (email = '$correo' OR contraseña = '$contraseña' OR usuario = '$nombre') AND id_usuario <> $numero");

        if ($usuario_existente->num_rows > 0) {
            //mostrar alerta y salir
            echo "<script>alert('El usuario, correo o contraseña ya están en uso. Por favor, elija otro.'); window.location.href='index.php';</script>";
            exit();
        }

        $query = $con->query("SELECT foto FROM usuario WHERE id_usuario = '$numero'");
        $resultado = $query->fetch_assoc();
        $nombre_imagen_actual = $resultado['foto'];

        // Se verifica si se selecciono una nueva imagen
        $imagen_nueva = isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0;

        if (!$imagen_nueva && !empty($nombre_imagen_actual)) {
            //si no hay nueva imagen, no eliminar la imagen actual
        } elseif (!empty($nombre_imagen_actual)) {
            //elimina la imagen actual
            $ruta_imagen_actual = "Img/" . $nombre_imagen_actual;
            if (file_exists($ruta_imagen_actual)) {
                unlink($ruta_imagen_actual);
            }
        }

        if ($imagen_nueva) {
            // Procesar la nueva imagen si se ha seleccionado
            $carpeta_destino = "Img/";
            $nombre_archivo = $_FILES["imagen"]["name"];
            $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];

            if (move_uploaded_file($ubicacion_temporal, $carpeta_destino . $nombre_archivo)) {
                $up = $con->query("UPDATE usuario SET nombre='$nombreCo', usuario='$nombre', rol='$rol', contraseña='$contraseña',foto='$nombre_archivo', email='$correo' WHERE id_usuario='$numero'");
                
                if ($up) {
                    $mensaje = "Registro actualizado";
                    header("Location:index.php?mensaje=".$mensaje);
                } else {
                    echo "Error en la actualización de la base de datos: " . $con->error;
                }
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            // si no hay nueva imagen, actualizar el usuario sin cambiar la imagen
            $up = $con->query("UPDATE usuario SET nombre='$nombreCo', usuario='$nombre', rol='$rol', contraseña='$contraseña', email='$correo' WHERE id_usuario='$numero'");
            
            if ($up) {
                $mensaje = "Registro actualizado";
                header("Location:index.php?mensaje=".$mensaje);
                exit();
            } else {
                echo "Error en la actualización de la base de datos: " . $con->error;
            }
        }
    }
?>
