<?php
include("connection/DB.php");
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['logueado'])) {
  header("Location: ../Login/index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/estilosHeader.css">
    <link rel="icon" href="../inicio/img/producto.png" type="image/x-icon">
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

<?php
    //consulta para obtener los ingredientes con cantidad menor que cantidad_minima
    $find_notifications = "SELECT *,(SELECT nombre FROM tbl_unidad_medida WHERE tbl_unidad_medida.id_unidad_medida = inventario.unidad_medida)as Umedida FROM inventario WHERE cantidad < cantidad_minima";
    $result = mysqli_query($connection, $find_notifications);

    // Obtiene el número de notificaciones
    $count_notifications = mysqli_num_rows($result);
    ?>

<body id="body">

<div class="navbar" id="navVertical">
    <img src="../img/LogoBerriondo.png" alt="Logo" style="width:225px;" class="rounded">
    <div class="horizontal-line"></div>
    <ul class="category-list">
        <a href="../inicio/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/home.svg" id="iconHome">
                    <span>Inicio</span>
                </div>
            </li>
        </a>
        <a href="../inventario/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/box.svg" id="iconHome">
                    <span>Inventario</span>
                </div>
            </li>
        </a>
        <a href="../Produccion/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/production.svg" id="iconHome">
                    <span>Producción</span>
                </div>
            </li>
        </a>
        <a href="../ventas/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/sales.svg" id="iconHome">
                    <span>Ventas</span>
                </div>
            </li>
        </a>
        <a href="../productos/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/arepita2.svg" id="iconHome">
                    <span>Productos</span>
                </div>
            </li>
        </a>
        <a href="../clientes/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/customers.svg" id="iconHome">
                    <span>Clientes</span>
                </div>
            </li>
        </a>
        <a href="../proveedores/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/provider.svg" id="iconHome">
                    <span>Proveedores</span>
                </div>
            </li>
        </a>
        <?php
        
if ($_SESSION['rol'] == 1) {
    echo '
        <a href="../usuarios/index.php">
            <li>
                <div class="category-item">
                    <img src="../img/icons/user.svg" id="iconHome">
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

  <li id="cam">
      <img style="width: 35px;" src="../img/icons/notification.svg" id="notification-bell" data-value="<?php echo $count_notifications; ?>"
          style="z-index:-99 !important;font-size:32px;color:black;margin:0.5rem 0.4rem !important;">
  </li>
  <?php if (!empty($count_notifications)) { ?>
      <div class="round" id="bell-count" data-value="<?php echo $count_notifications; ?>">
          <div id="numN">
          <span><?php echo $count_notifications; ?></span>
          </div>
  </div>
  <?php } ?>

 <div id="list">
     <?php
     // Puedes utilizar estos resultados para mostrar detalles específicos de ingredientes
     while ($rows = mysqli_fetch_assoc($result)) {
         ?>
             <li id="message_items">
                 <div class="message alert alert-warning">
                     <span>¡URGENTE! <br> Notificación para: <?php echo $rows['nombre_ingrediente']; ?></span>
                     <div class="msg">
                         <img style="width: 50px;" src="../inicio/img/<?php echo $rows['imagen']; ?>" alt="Imagen del producto">
                         <p>La cantidad actual es <?php echo $rows['cantidad']; ?> <?php echo $rows['Umedida']; ?>.</p>
                     </div>
                 </div>
             </li>
         <?php
     }
     ?>
 </div>
</head>
<body>

<div class="vertical-line"></div>
<div class="container-fluid" id="imgUsuario">

  <a class="navbar-brand" href="#" id="mostrarModal">
    <img src="../usuarios/img/<?= $_SESSION['imagenUsuario']?>" alt="Foto de perfil" style="width:60px; height:60px" class="rounded-pill">
  </a>
  <div id="NomUsuario">
    <p><strong><?= $_SESSION['usuarioIn']?></strong></p>
    </div>
  </div>
</nav>

<!-- Modal de perfil-->
<div id="modal">
<span id="cerrar">&times;</span>
  <p><img src="../img/icons/perfil.png" style="width:30px;" alt=""><a href="../perfil/index.php">Ver Perfil</a></p>
  <p><img src="../img/icons/cerrar.png" style="width:30px;" alt=""><a id="cerrarSesionBtn">Cerrar Sesión</a></p>
</div>

<script>
  // función para cerrar la sesión
  function cerrarSesion() {

    // muestra la alerta
    let timerInterval;
    Swal.fire({
      title: 'Cerrando sesión...',
      html: 'Redirigiendo en <b></b> milliseconds.',
      timer: 1200,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
        const b = Swal.getHtmlContainer().querySelector('b');
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft();
        }, 100);
      },
      willClose: () => {
        clearInterval(timerInterval);
        // redirige a cerrar.php 
        window.location.href = '../Perfil/cerrar.php';
      },
    }).then((result) => {
  
    });
  }

  // Cuando se hace click en cerrar sesion se ejecuta la función
  document.getElementById('cerrarSesionBtn').addEventListener('click', cerrarSesion);
</script>

<script>
var modal = document.getElementById('modal');
var mostrarModal = document.getElementById('mostrarModal');
var cerrar = document.getElementById('cerrar');

//funciones para mostrar y ocultar el modal
function toggleModal() {
  if (modal.style.display === 'block') {
    modal.style.display = 'none';
  } else {
    modal.style.display = 'block';
  }
}

mostrarModal.onclick = function() {
  toggleModal();
}

cerrar.onclick = function() {
  modal.style.display = 'none';
}
</script>
  


<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Alerta para eliminar el registro -->
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

<!-- Alerta despues de que se agrega -->
<?php if(isset($_GET['mensaje'])) { ?>
<script>
    Swal.fire({ icon: "success", timer: 1500, title: "<?php echo $_GET['mensaje']; ?>" 
    }).then(function(){
      window.location.href = "index.php";
    });
</script>
<?php }?>

<!-- Script para la notificación -->
<script>
        $(document).ready(function () {

            $('#notification-bell').on('click', function () {
                $('#list').toggle();
            });

            $('#notify').on('click', function (e) {
                e.preventDefault();
            });
        });
    </script>

</body>
</html>