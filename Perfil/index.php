<?php
include('../conexion.php');
include("../templates/header.php");

$idRol = $_SESSION['rol'];

//consulta para el rol
$sql = "SELECT nombre FROM tbl_roles WHERE id_roles = $idRol";

$resultado = mysqli_query($con, $sql);

$fila = mysqli_fetch_assoc($resultado);
?>

<link rel="stylesheet" href="../Css/estilosPerfil.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Sans&family=Open+Sans:wght@300&family=Roboto&family=Shadows+Into+Light&family=Sometype+Mono&display=swap" rel="stylesheet">


<div id="body">
<!-- Muestra el perfil del usuario que se logueo -->

<div class="alert alert-warning" id="alertP">
    <h2><strong>Perfil</strong></h2>
  </div>

<div id="card1" class="card" style="width:400px">
   <img src="../usuarios/img/<?= $_SESSION['imagenUsuario']?>" alt="Foto de perfil" style="width:160px; height:160px" class="rounded-pill">
  <div class="card-body">
  <p><strong><?= $_SESSION['usuarioIn']?></strong></p>
  </div>
</div>

<div id="card2" class="card" style="width:620px">
  <div class="card-body">
    <div id="caja1">
       <img style="width:90px;" src="../img/icons/identificador.png" alt="">
       <div id="inf1" style="display: inline-block; margin-left: 10px;"> 
        <h3>Nombre:</h3>
        <p><strong><?= $_SESSION['nombreIn']?></strong></p>
       </div>
    </div>
    <div id="caja2">
       <img style="width:80px;" src="../img/icons/rol.png" alt="">
       <div id="inf2" style="display: inline-block; margin-left: 10px;">
       <h3>Rol:</h3>
       <p><strong><?php echo $fila['nombre']?></p>
       </div>
    </div>
    <div id="caja3">
       <img style="width:80px;" src="../img/icons/correo.png" alt="">
       <div id="inf3" style="display: inline-block; margin-left: 10px;">
       <h3>Email:</h3>
       <p><?= $_SESSION['emailIn']?></p>
       </div>
    </div>
  </div>
</div>

</div>


