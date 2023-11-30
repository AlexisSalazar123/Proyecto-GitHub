<?php
include('../conexion.php');
include("../templates/header.php");

if(isset($_GET['txtID'])){ //Si se paso id como parámetro get
    $id = $_GET['txtID'];
        // Obtener el nombre de la imagen actual antes de eliminar el registro
    $query = $con->query("SELECT foto FROM productos WHERE id_productos = '$id'");
    $resultado = $query->fetch_assoc();
    $nombre_imagen_actual = $resultado['foto'];

    // Eliminar la imagen de la carpeta
    if (!empty($nombre_imagen_actual)) {
        $ruta_imagen_actual = "Img/" . $nombre_imagen_actual;
        if (file_exists($ruta_imagen_actual)) {
            unlink($ruta_imagen_actual);
        }
    }

    // Eliminar el registro de la base de datos
    $del = $con->query("DELETE FROM usuario WHERE id_usuario=".$id);

    if($del) {//Modal de exito al eliminar
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Registro eliminado",
                showConfirmButton: false,
                timer: 1500
             }).then(function() {
                window.location.href = "index.php";
             });
            </script>';
    } else {
        echo "Error al eliminar el registro: " . $con->error;
    }



}
?>

<title>Usuarios</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<link rel="stylesheet" href="../Css/estilosUsuarios.css">
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $("#tabla_id").DataTable({
      "dom": '<"top"flBri>t<"bottom"ip>',
        "pageLength": 5,
        lengthMenu:[//como se va a mostrar el paginado
    [3,10,25],
    [3,10,25]
  ],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
});
</script>

<div class="alert alert-info">
    <h4><strong>Usuarios</strong></h4>
</div>

<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">
    <img src="../img/icons/add.svg" alt="Logo" style="width:30px;">
        Agregar Usuario
    </a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla Usuario -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Foto</th>
                    <th scope="col" class="table-dark">Nombre</th>
                    <th scope="col" class="table-dark">Usuario</th>
                    <th scope="col" class="table-dark">Rol</th>
                    <th scope="col" class="table-dark">Correo</th>
                    <th scope="col" class="table-dark">Acciones</th>
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT *,
            (SELECT nombre FROM tbl_roles
            WHERE tbl_roles.id_roles=usuario.rol limit 1)as Nrol
            FROM usuario");
            while ($fila = $sel->fetch_assoc()) {
            ?>

                <tr class="">
                <td><?php echo $fila['id_usuario']?></td>
                <td><img src="Img/<?php  echo $fila['foto']?>" alt="imagen" class="imagen-producto img-fluid rounded" style="width: 80px; height: 90px;"></td>
                <td><?php echo $fila['nombre']?></td>
                <td><?php echo $fila['usuario']?></td>
                <td><?php echo $fila['Nrol']?></td>
                <td><?php echo $fila['email']?></td>
                <td>
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                        <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>
                    | <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_usuario'];?>);" role="button">
                        <img src="../img/icons/delete.svg" alt="Imagen de eliminar" width="23" height="25">
                    </a>                   
                </td>
                </tr>

            <?php } ?>
                
            </tbody>
        </table>
    </div>
    
        
    </div>

</div>


<!--Modal Editar Registro -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="update_id">
                    <div class="mb-3">
                    <label for="numero" class="col-form-label">Número:</label>
                        <input type="number" readonly name="numero" id="numero" class="form-control" required>
                        <img class="input-icon" id="icons1" src="../img/Icons/hashtag.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="" class="col-form-label">Nombre Completo:</label>
                        <input type="text" id="nombreC" name="nombreC" class="form-control" required>
                        <img class="input-icon" id="icons2" src="../img/Icons/name.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="col-form-label">Usuario:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required maxlength="12">
                        <img class="input-icon" id="icons3" src="../img/Icons/user2.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="col-form-label">Rol:</label>
                        <img class="input-icon" id="icons4" src="../img/Icons/role.svg" alt=""> 
                        <select class="form-select form-select-sm" name="rol" id="rol" required>
                        <option value="" disabled selected>Seleccione un Rol</option>
                            <?php
                             $pro = $con->query("SELECT * FROM tbl_roles");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_roles'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="col-form-label">Imagen:</label>
                        <img id="imagen_previa" style="width: 120px; height: 120px;" class="img-preview img-fluid rounded" alt="Imagen previa">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="col-form-label">Nueva Imagen (opcional):</label>
                        <input type="file" class="form-control" name="imagen">
                        <img class="input-icon" id="icons5" src="../img/Icons/photo.svg" alt=""> 
                        <div class="imagen text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="contraseña" class="col-form-label">Nueva Contraseña:</label>
                        <img class="icon2" id="icons6" src="../img/Icons/contra.svg" alt="">
                        <input type="password" id="contraseña2" name="contraseña2" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="col-form-label">Correo:</label>
                        <img class="icon2" id="icons7" src="../img/Icons/email.svg" alt="">
                        <input type="email" id="correo2" name="correo2" class="form-control" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"   onclick="closeModalAndRedirect(event)">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!--Modal Agregar Producción -->
<div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="guardar.php" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="text" id="nombreCo" name="nombreCo" class="form-control" placeholder="Ingrese el Nombre Completo" required>
            <img class="input-icon" id="img1" src="../img/Icons/name.svg" alt="">
          </div>
          <div class="mb-3">
            <input type="text" id="nombre2" name="nombre2" class="form-control" placeholder="Ingrese el Usuario" required maxlength="12">
            <img class="input-icon" id="img2" src="../img/Icons/user2.svg" alt="">
          </div>
          <div class="mb-3">
                <img class="input-icon" id="img3" src="../img/Icons/role.svg" alt=""> 
                <select class="form-select form-select-sm" name="rol2" id="rol2" required>
                <option value="" disabled selected>Seleccione un Rol</option>
                    <?php
                     $pro = $con->query("SELECT * FROM tbl_roles");
                     while ($registro = $pro->fetch_assoc()){
                    ?>
                        <option value="<?php echo $registro['id_roles'] ?>">
                           <?php echo $registro['nombre']?>
                        </option>
                    <?php } ?>
                </select>
           </div>
          <div class="mb-3">
            <input type="file" class="form-control" style="" name="imagen" id="imagen" required>
            <img class="input-icon" id="img4" src="../img/Icons/photo.svg" alt="">
            <div class="text-danger"></div>
          </div> 
          <div class="mb-3">
            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese la Contraseña" required>
            <img class="input-icon" id="img5" src="../img/Icons/contra.svg" alt="">
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el Correo" required>
            <img class="input-icon" id="img6" src="../img/Icons/email.svg" alt="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input type="submit" value="Agregar" class="btn btn-success"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
    //Valores que se mostrara en la tabla editar
    $('.editbtn').on('click', function(){
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function (){
            return $(this).text();
        });
        // Obtener la url de la imagen
        var imagenURL = $tr.find("img").attr('src');

        $('#update_id').val(datos[0]);
        $('#numero').val(datos[0]);
        $('#nombreC').val(datos[2]);
        $('#nombre').val(datos[3]);
        $('#imagen_previa').attr('src', imagenURL);
        $('#correo2').val(datos[5]);
    });
</script>

<script>
function closeModalAndRedirect() {
  // Cierra el modal
  var modal = new bootstrap.Modal(document.getElementById('editar'));
  modal.hide();

  // Redirige a index.php sin recargar la página
  window.location.replace('index.php');
}
</script>






