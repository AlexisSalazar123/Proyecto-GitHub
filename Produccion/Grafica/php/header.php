<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica Producción</title>
    <link rel="stylesheet" href="../../Css/estilosGrafica.css">
    <link rel="icon" href="../../inicio/img/producto.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    <img src="../../img/LogoBerriondo.png" alt="Logo" style="width:225px;" class="rounded">
    <div class="horizontal-line"></div>
    <ul class="category-list">
        <a href="../../inicio/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/home.svg" id="iconHome">
                    <span>Inicio</span>
                </div>
            </li>
        </a>
        <a href="../../inventario/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/box.svg" id="iconHome">
                    <span>Inventario</span>
                </div>
            </li>
        </a>
        <a href="../../Produccion/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/production.svg" id="iconHome">
                    <span>Producción</span>
                </div>
            </li>
        </a>
        <a href="../../ventas/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/sales.svg" id="iconHome">
                    <span>Ventas</span>
                </div>
            </li>
        </a>
        <a href="../../productos/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/arepita2.svg" id="iconHome">
                    <span>Productos</span>
                </div>
            </li>
        </a>
        <a href="../../clientes/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/customers.svg" id="iconHome">
                    <span>Clientes</span>
                </div>
            </li>
        </a>
        <a href="../../proveedores/index.php">
            <li>
                <div class="category-item">
                    <img src="../../img/icons/provider.svg" id="iconHome">
                    <span>Proveedor</span>
                </div>
            </li>
        </a>
        <?php
        if ($_SESSION['rol'] == 1) {
            echo '
                <a href="../../usuarios/index.php">
                    <li>
                        <div class="category-item">
                            <img src="../../img/icons/user.svg" id="iconHome">
                            <span>Usuarios</span>
                        </div>
                    </li>
                </a>';
        }
        ?>
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
      
    </a>
  </div>
  
  <div class="vertical-line"></div>
  <div class="container-fluid" id="imgUsuario">
    <a class="navbar-brand" href="#">
    <img src="../../usuarios/img/<?= $_SESSION['imagenUsuario']?>" alt="Foto de perfil" style="width:60px; height:60px" class="rounded-pill">
    </a>
    <p><strong><?= $_SESSION['usuarioIn']?></strong></p>
  </div>
</nav>

<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function borrar(id){
  Swal.fire({
  title: "¿Desea eliminar el registro?",
  text: "¡No podras revertirlo!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Sí, eliminar!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location="index.php?txtID="+id;
  }
});      
}
</script>

<?php if(isset($_GET['mensaje'])) { ?>
<script>
    Swal.fire({ icon: "success", timer: 1500, title: "<?php echo $_GET['mensaje']; ?>" 
    }).then(function(){
      window.location.href = "index.php";
    });
</script>
<?php }?>

</body>
</html>