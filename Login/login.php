<?php
    include('conexion.php');

    $usuario = $_POST['usuario'];
    $sel = $con->query("SELECT contraseña FROM usuarios where usuario='$usuario'");

    if($sel){
        if($sel->num_rows>0){
            $registro = $sel->fetch_assoc();

            $contraseña_bd = $registro['contraseña'];
            $contraseña_ingresada = $_POST['contraseña'];

            if ($contraseña_bd == $contraseña_ingresada) {
                header("Location: inicio.php"); 
            }
            else {
                echo "La contraseña o el usuario son incorrectos.";
            }
        }
        else {
            echo "Usuario no encontrado.";
        }
    }
    else {
        echo "Error en la consulta: " . $con->error;
    }
?>
