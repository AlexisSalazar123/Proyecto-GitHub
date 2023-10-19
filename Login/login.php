<?php
    include('conexion.php');

    $mensajeError = ""; // Inicialmente, no hay error.

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'];
        $sel = $con->query("SELECT contraseña FROM usuarios where usuario='$usuario'");

        if($sel) {
            if($sel->num_rows > 0) {
                $registro = $sel->fetch_assoc();

                $contraseña_bd = $registro['contraseña'];
                $contraseña_ingresada = $_POST['contraseña'];

                if ($contraseña_bd == $contraseña_ingresada) {
                    header("Location: inicio.php"); 
                } else {
                    $mensajeError = "La contraseña o el usuario son incorrectos.";
                }
            } else {
                $mensajeError = "Usuario no encontrado.";
            }
        } else {
            $mensajeError = "Error en la consulta: " . $con->error;
        }
    }
?>