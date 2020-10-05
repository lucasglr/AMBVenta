<?php
include_once "config.php";
include_once "entidades/cliente.php";
include_once "entidades/domicilio.entidad.php";
include_once "entidades/provincia.entidad.php";
include_once "entidades/localidad.entidad.php";

$pg = "Edición de cliente";
$aMsj = array("codigo" => "", "mensaje" => "");

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

if ($_POST) {
  if (isset($_POST["btnGuardar"])) {
    if (isset($_GET["id"]) && $_GET['id'] > 0) {
      //actualizar un cliente
      $cliente->actualizar();
      $aMsj = array("mensaje" => "Cliente actualizado", "codigo" => "primary");
      header("refresh:2; url=producto-formulario.php");
    } else {
      //agregar un cliente
      $cliente->insertar();
      $aMsj = array("mensaje" => "Cliente agregado", "codigo" => "success");
      header("refresh:2; url=producto-formulario.php");
    }
  } elseif (isset($_POST["btnBorrar"]) && isset($_GET["id"])) {
    $cliente->eliminar();
    $aMsj = array("mensaje" => "Cliente eliminado", "codigo" => "danger");
    header("refresh:2; url=producto-formulario.php");
  }
}
if (isset($_GET["id"]) && $_GET["id"] != "") {
  $cliente->obtenerPorId();
}
if(isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad" && $_GET["id"] && $_GET["id"] > 0){
  $idProvincia = $_GET["id"];
  $localidad = new Localidad();
  $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
  echo json_encode($aLocalidad);
  exit;
} else if(isset($_GET["id"]) && $_GET["id"] > 0){
  $cliente->obtenerPorId();
}

$entidadProvincia = new Provincia();
$aProvincias = $entidadProvincia->obtenerTodos();


?>
<?php include("header.php"); ?>
<div class="container">
  <div class="row mt-3">
    <div class="col-12 ">
      <h1 class="h3 text-gray-800">Clientes</h1>
    </div>
  </div>
  <form action="" method="POST">
    <div class="row my-3">
      <div class="col-6 ">
        <a href="clientes-listado.php" class="btn btn-primary mr-2">Listado</a>
        <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
        <button type="submit" class="btn btn-success mr-2" name="btnGuardar">Guardar</button>
        <button type="submit" class="btn btn-danger mr-2" name="btnBorrar">Borrar</button>
      </div>
      <div class="col-6">
        <?php if ($aMsj != "") : ?>
          <div class="alert alert-<?php echo $aMsj["codigo"]; ?>" role="alert">
            <?php echo $aMsj["mensaje"]; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-6 form-group mt-3">
        <label for="txtNombre">Nombre:</label>
        <input type="text" name="txtNombre" class="form-control" value="<?php echo $cliente->nombre; ?>">
      </div>
      <div class="col-6 form-group mt-3">
        <label for="txtCuit">CUIT:</label>
        <input type="text" name="txtCuit" class="form-control" value="<?php echo $cliente->cuit; ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-6 form-group mt-1">
        <label for="txtFechaNacimiento">Fecha de nacimiento</label>
        <input type="date" name="txtFechaNac" class="form-control" value="<?php echo $cliente->fecha_nac; ?>">
      </div>
      <div class="col-6 form-group mt-1">
        <label for="txtTelefono">Teléfono:</label>
        <input type="number" name="txtTelefono" class="form-control" value="<?php echo $cliente->telefono; ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <label for="txtCorreo">Correo:</label>
        <input type="email" class="form-control" name="txtCorreo" value="<?php echo $cliente->correo; ?>">
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i> Domicilios
            <div class="pull-right">
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalDomicilio">Agregar</button>
            </div>
          </div>
          <div class="panel-body">
            <table id="grilla" class="display" style="width:98%">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Provincia</th>
                  <th>Localidad</th>
                  <th>Dirección</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
  </form>
  <!-- Modal -->
  <div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="modalDomicilioLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Domicilio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container mx-auto">
          <div class="row ml-2">
            <div class="col-10" class="form-group">
              <label for="">Tipo</label>
              <select name="" id="" class="form-control">
                <option value="" selected>Seleccionar</option>

              </select>
            </div>
          </div>
          <div class="row ml-2">
            <div class="col-10" class="form-group">
              <label for="">Provincia</label>
              <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach($aProvincias as $prov): ?>
                        <option value="<?php echo $prov->idprovincia; ?>"><?php echo $prov->nombre; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Localidad</label>
              <select name="" id="" class="form-control">
                <option value="" selected>Seleccionar</option>
              </select>
            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Provincia</label>
              <select name="" id="" class="form-control">
                <option value="" selected>Seleccionar</option>
              </select>
            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Direccion</label>
              <select name="" id="" class="form-control">
                <option value="" selected>Seleccionar</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  $(document).ready(function() {
    $('#grilla').DataTable();
  });

  function fBuscarLocalidad(){
            idProvincia = $("#lstProvincia option:selected").val();

            $.ajax({
                type: "GET",
                url: "cliente-formulario.php?do=buscarLocalidad",
                data: { id:idProvincia },
                async: true,
                dataType: "json",
                success: function (respuesta) {
              		
                }
            });
        }

</script>

<?php include("footer.php"); ?>