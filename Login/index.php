<?php
    session_start();

    include('../conexion.php');

    $mensajeError = ""; 

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

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Css\estilos.css">

    <script>
        // Esta función ocultará el mensaje de error después de 10 segundos
        setTimeout(function() {
            var errorElement = document.querySelector(".error-message");
            if (errorElement) {
                errorElement.style.display = "none";
            }
        }, 4000); // 10000 milisegundos = 10 segundos
    </script>

</head>
<body>

  <img class="fullscreen-image" src="img/ImagenLo.jpeg" alt="Imagen de pantalla completa">

  <div class="contenedor">

    <div class="login-image">
        <img src="img/Beriondopspspsps.png" alt="Imagen de inicio de sesión">
    </div>
        
    <div class="div_formulario">
        <h2>Ingresar al sistema</h2>
           <form action="index.php" method="post" id="formulario">
            
             
             <div class="input-wraper">
                <input type="text" id="usuario" name="usuario" placeholder="Usuario">
                <img class="input-icon" src="img/Icons/user.svg" alt="">
             </div>

             <div class="input-wraper">
                <input type="password" id="password" name="contraseña" placeholder="Contraseña">
                <img class="input-icon" src="img/Icons/padlock-svgrepo-com.svg" alt="">
             </div>
            <button type="submit" id="validarButton">Ingresar</button>

            <div class="error-message">
                <?php
                if (!empty($mensajeError)) {
                    echo '<div class="alert alert-danger">' . $mensajeError . '</div>';
                }
                ?>
    </div>
           </form>

   </div>
</body>
</html>



