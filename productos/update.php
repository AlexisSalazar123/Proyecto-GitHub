<?php
    include('../conexion.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_productos = $_POST['id_productos'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];

        $query = $con->query("SELECT foto FROM productos WHERE id_productos = '$id_productos'");
        $resultado = $query->fetch_assoc();
        $nombre_imagen_actual = $resultado['foto'];

        // Verificar si se selecciono una nueva imagen
        $imagen_nueva = isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0;

        if (!$imagen_nueva && !empty($nombre_imagen_actual)) {
            //Si no hay nueva imagen, no elimina la imagen actual
        } elseif (!empty($nombre_imagen_actual)) {
            // Eliminar la imagen actual
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
                $up = $con->query("UPDATE productos SET nombre='$nombre', foto='$nombre_archivo', precio='$precio' WHERE id_productos='$id_productos'");
                
                if ($up) {
                    $mensaje="Registro actualizado";
                    header("Location:index.php?mensaje=".$mensaje);
                    exit();
                } else {
                    echo "Error en la actualización de la base de datos: " . $con->error;
                }
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            $up = $con->query("UPDATE productos SET nombre='$nombre', precio='$precio' WHERE id_productos='$id_productos'");
            if ($up) {
                $mensaje="Registro actualizado";
                header("Location:index.php?mensaje=".$mensaje);
                exit();
            } else {
                echo "Error en la actualización de la base de datos: " . $con->error;
            }
        }
    }
?>