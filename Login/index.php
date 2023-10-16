<?php
    include('conexion.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="arepa icon" href="img/arepa.png">
</head>
<body>
    <br><br><br><br><br><br>
    <section class="d-flex justify-content-center align-items-center">
        <div class="card shadow col-xs-12 col-sm-6 col-md-6 col-lg-4   p-4">
            <div class="mb-2 d-flex justify-content-start align-items-center">
                <h1>  <i class="bi bi-chat-left-quote"></i> &nbsp; Bienvenido </h1>
            </div>
            <div class="mb-1">
                <form method="post" action="login.php">
                    <div class="mb-4 d-flex justify-content-between"></div>
                        <div class="mb-4">
                            <label for="usuario"><i class="bi bi-envelope-fill"></i> Usuario:</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Ingrese su usuario aqui." required>
                            <div class="correo text-danger"></div>
                        </div>
                        <div class="mb-4">
                            <label for="contraseña"><i class="bi bi-envelope-fill"></i> Contraseña:</label>
                            <input type="password" class="form-control" name="contraseña" placeholder="Ingrese su contraseña aqui." required>
                            <div class="usuario text-danger"></div>
                        </div>
                        <div class="mb-2">
                            <button id ="botton" class="col-lg-12 btn btn-dark d-flex justify-content-between ">
                                <span>Iniciar Sesion</span><i id="btn" class="bi bi-cursor-fill "></i>
                            </button>
                        </div> 
                </form>
            </div>
        </div>
    </section>
</body>
</html>



