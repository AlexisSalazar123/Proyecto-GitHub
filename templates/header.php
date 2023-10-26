<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Css/estilosHeader.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
</head>
<body id="body">

<div class="navbar" id="navVertical">

      <img src="../img/LogoBerriondo.png" alt="Logo" style="width:225px;" class="rounded">

      <div class="horizontal-line"></div>
   
      <ul class="category-list">
  <li>
    <div class="category-item">
      <img src="../img/icons/home.svg" id="iconHome">
      <a href="../inicio/index.php">Inicio</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/box.svg" id="iconHome">
      <a href="#">Inventario</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/production.svg" id="iconHome">
      <a href="../Produccion/index.php">Producción</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/sales.svg" id="iconHome">
      <a href="#">Ventas</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/arepa.png" id="iconHome">
      <a href="#">Productos</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/customers.svg" id="iconHome">
      <a href="#">Clientes</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/provider.svg" id="iconHome">
      <a href="#">Proveedor</a>
    </div>
  </li>
  <li>
    <div class="category-item">
      <img src="../img/icons/user.svg" id="iconHome">
      <a href="#">Usuarios</a>
    </div>
  </li>
</ul>
  </div>
    
<nav class="navbar navbar-expand-sm navbar-dark bg-light" id="nav">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="mynavbar">
      <form class="d-flex">
        <input class="form-control me-2" type="text" style="width:300px" placeholder="Search...">
        <button class="btn btn-primary" type="button">Buscar</button>
      </form>
    </div>
  </div>

  <div class="container-fluid" id="notification">
    <a class="navbar-brand" href="#">
      <img src="../img/icons/notification.svg" alt="Logo" style="width:25px;" class="rounded-pill">
    </a>
  </div>
  
  <div class="vertical-line"></div>
  <div class="container-fluid" id="imgUsuario">
    <a class="navbar-brand" href="#">
      <img src="../img/Berriondo.jpeg" alt="Logo" style="width:55px;" class="rounded-pill">
    </a>
    <p>Don Berriondo</p>
  </div>
</nav>

<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready( function(){
$("#tabla_id").DataTable({
  "pageLength":3,
  lengthMenu:[
    [3,5,7],
    [3,5,7]
  ],
  "Language":{
    "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"

  }

});


});
</script>


<script>
function borrar(id){
    Swal.fire({
    title: '¡Desea borrar el registro?',
    showCancelButton: true,
    confirmButtonText: 'Si, Borrar',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location="index.php?txtID="+id;
      } 
})      
}
</script>

<?php if(isset($_GET['mensaje'])) { ?>
<script>
    Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje'];?>"});
</script>
<?php }?>

</body>
</html>