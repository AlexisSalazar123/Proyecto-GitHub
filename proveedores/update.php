<?php
    include('../conexion.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = $_POST['numero'];
        $nombre = $_POST['nombrePr'];
        $razon = $_POST['razon'];
        $direccion = $_POST['direccion2'];
        $telefono = $_POST['telefono2'];
        $correo = $_POST['correo2'];

        $query = $con->query("SELECT foto FROM proveedor WHERE id_proveedor = '$numero'");
        $resultado = $query->fetch_assoc();
        $nombre_imagen_actual = $resultado['foto'];

        // Verificar si se ha seleccionado un nueva imagenn
        $imagen_nueva = isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0;

        if (!$imagen_nueva && !empty($nombre_imagen_actual)) {
            // si no hay nueva imagen, no eliminar la imagen actual
        } elseif (!empty($nombre_imagen_actual)) {
            // elimina la imagen actual
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
                $up = $con->query("UPDATE proveedor SET nombre='$nombre', foto='$nombre_archivo', razon_social='$razon', direccion='$direccion', telefono='$telefono', correo='$correo' WHERE id_proveedor='$numero'");
                
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
            // si no hay nueva imagen, actualizar la tabla proveedor datos sin cambiar la imagen
            $up = $con->query("UPDATE proveedor SET nombre='$nombre', razon_social='$razon', direccion='$direccion', telefono='$telefono', correo='$correo' WHERE id_proveedor='$numero'");
            
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
