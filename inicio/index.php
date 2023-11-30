<?php 
session_start();

if (!isset($_SESSION['logueado'])) {
  header("Location: ../Login/index.php");
  exit();
}

include("../templates/header.php"); 
include('../conexion.php');

//Total ventas
$sel = $con->query("SELECT COUNT(*)as totalVentas FROM ventas");
$totalVentas = $sel->fetch_assoc();

//Total productos
$sel = $con->query("SELECT COUNT(*)as totalProductos FROM productos");
$totalProductos = $sel->fetch_assoc();

//Total clientes
$sel = $con->query("SELECT COUNT(*)as totalClientes FROM clientes");
$totalClientes = $sel->fetch_assoc();

//Total proveedores
$sel = $con->query("SELECT COUNT(*)as totalProveedores FROM proveedor");
$totalProveedores = $sel->fetch_assoc();

//Total usuarios
$sel = $con->query("SELECT COUNT(*)as totalUsuarios FROM usuario");
$totalUsuarios = $sel->fetch_assoc();

?>
<title>Inicio</title>
<link rel="stylesheet" href="../Css/estilosInicio.css">

<body>
<div class="container" id="cartas">

<!-- Cartas con los totales -->
<a href="../ventas/index.php">
<div class="card d-inline-block" id="carta" style="width: 350px; height: 285px; margin-left: -10%; margin-right: 15px;">
    <img class="card-img-top" src="img/ventas.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2><strong>Total Ventas</strong></h2>
      <h4 class="card-title" style="font-size:27px"><?php echo $totalVentas['totalVentas']?></h4>
    </div>
  </div>
</a>

  <a href="../productos/index.php">
    <div class="card d-inline-block" style="width: 350px; height: 285px; margin-right: 15px;">
    <img class="card-img-top" src="img/producto.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2><strong>Total Productos</strong></h2>
      <h4 class="card-title" style="font-size:27px"><?php echo $totalProductos['totalProductos']?></h4>
    </div>
  </div>
  </a>

  <a href="../clientes/index.php">
  <div class="card d-inline-block" style="width: 350px; height: 285px; margin-right: 15px;">
    <img class="card-img-top" src="img/cliente.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2><strong>Total Clientes</strong></h2>
      <h4 class="card-title" style="font-size:27px"><?php echo $totalClientes['totalClientes']?></h4>
    </div>
  </div>
</div>
  </a>

<div class="container" id="cartas2">
 <a href="../proveedores/index.php">
 <div class="card d-inline-block" style="width: 350px; height: 285px; margin-left: -10%; margin-right: 15px;">
    <img class="card-img-top" src="img/proveedor.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2><strong>Total Proveedores</strong></h2>
      <h4 class="card-title" style="font-size:27px"><?php echo $totalProveedores['totalProveedores']?></h4>
    </div>
  </div>
 </a>

  <?php
if ($_SESSION['rol'] == 1) {
    echo '<a href="../usuarios/index.php">';
}
?>
  <div class="card d-inline-block" style="width: 350px; height: 285px; margin-right: 15px;">
    <img class="card-img-top" src="img/usuario.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2><strong>Total Usuarios</strong></h2>
      <h4 class="card-title" style="font-size:27px"><?php echo $totalUsuarios['totalUsuarios']?></h4>
    </div>
  </div>
  </a>

  <div class="card d-inline-block" style="width: 350px; height: 285px; margin-right: 15px;">
    <img class="card-img-top" src="img/hornear.png" alt="Card image" style="width:140px">
    <div class="card-body">
      <h2>Receta</h2>
      <button type="button" style="width:40%" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalReceta"><h5>Mostrar</h5></button>
    </div>
  </div>
</div>

<!-- Modal que aparece para dar la bienvenida al usuario -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title fs-5" id="exampleModalLabel"><h1>Arepas El Berriondo</h1></div>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="texto">
          <h1 id="h1User">Oe Berriondo, <strong style="color: grey;"><?= $_SESSION['usuarioIn']?></strong></h1>
          <h1>Bienvenido a donde hacen las mejores</h1>
          <h1>arepas del mundo.</h1>
          <h1><strong>¡Práctimante pues, pues, pues!</strong></h1>
        </div>
        <div class="contenido">
          <img src="../img/modalBe890.png" style="width: 20%;" alt="">
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</body>

<!-- Modal de la receta -->
<div class="modal fade" id="ModalReceta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog .modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header" id="modal2">
        <h4 class="modal-title fs-5" id="exampleModalLabel">Por cada 5 arepas</h4>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <img src="img/harinaM.png" style="width: 11%" alt="imgHarina">
            <h3>500 gramos de harina</h3>
          </div>
          <div class="">
            <img src="img/queso2.png" style="width: 11%" alt="imgQueso">
            <h3>250 gramos de Q mozarella</h3>
          </div>
          <div class="mb-3">
            <img src="img/queso.png" style="width: 11%" alt="imgQueso">
            <h3>125 gramos de queso fresco</h3>
          </div>
          <div class="mb-3">
            <img src="img/azucar.png" style="width: 11%" alt="imgAzucar">
            <h3>20 gramos de azucar</h3>
          </div>
          <div class="mb-3">
            <img src="img/sal.png" style="width: 11%" alt="imgSal">
            <h3>10 gramos de sal</h3>
          </div>
          <div class="mb-3">
            <img src="img/mantequilla.png" style="width: 11%" alt="imgMantequilla">
            <h3>30 gramos de mantequilla</h3>
          </div>
          <div class="mb-3">
            <img src="img/agua.png" style="width: 11%" alt="imgAgua">
            <h3>350 ml de agua</h3>
          </div>
          <div class="mb-3">
            <img src="img/leche.png" style="width: 11%" alt="imgLeche">
            <h3>350 ml de leche</h3>
          </div>
          
      </div>
      <div class="modal-footer" id="modal2">
      </div>
    </div>
  </div>
</div>

<!-- Script para mostrar el modal solo una vez despues de -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (<?php echo isset($_SESSION['logueado']) && $_SESSION['logueado'] && !$_SESSION['modalMostrado'] ? 'true' : 'false'; ?>) {
          setTimeout(function() {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();

            <?php $_SESSION['modalMostrado'] = true; ?>
          }, 2000); 
        }
    });
</script> 

    

