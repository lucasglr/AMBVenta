<?php
include_once "config.php";
include_once "entidades/cliente.php";
include_once "entidades/venta.php";
include_once "entidades/domicilio.entidad.php";
include_once "entidades/provincia.entidad.php";
include_once "entidades/localidad.entidad.php";
include_once "entidades/tipo_cliente.php";

$pg = "Edición de cliente";
$aMsj = array("codigo" => "", "mensaje" => "");

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);
$entidadTipoCliente = new Tipo_usuario();
$aTipoUsuario = $entidadTipoCliente->obtenerTodo();



if ($_POST) {
  if (isset($_POST["btnGuardar"])) {
    if (isset($_GET["id"]) && $_GET['id'] > 0) {
      //actualizar un cliente
      $cliente->actualizar();
      $aMsj = array("mensaje" => "Cliente actualizado", "codigo" => "primary");
      header("refresh:2; url=cliente-formulario.php");
    } else {
      //agregar un cliente

      $cliente->insertar();
      $aMsj = array("mensaje" => "Cliente agregado", "codigo" => "success");
      header("refresh:2; url=cliente-formulario.php");
    }
  } elseif (isset($_POST["btnBorrar"]) && isset($_GET["id"])) {
    $idCliente=$_GET['id'];
    $entidadVenta= new Venta();
    $venta=$entidadVenta->consultarVentas($idCliente);
   
    if(!$venta==0){
     
      $aMsj = array("mensaje" => "El cliente tiene ventas asignadas!", "codigo" => "danger");
      header("refresh:2; url=cliente-formulario.php");
    }else{
     
      $domicilio = new Domicilio();
      $domicilio->eliminarPorCliente($cliente->idcliente);
      $cliente->eliminar();
      $aMsj = array("mensaje" => "Cliente eliminado", "codigo" => "danger");
      header("refresh:2; url=cliente-formulario.php");
    }

   
    
  }
  if (isset($_POST["txtTipo"])) {
    $domicilio = new Domicilio();
    $domicilio->eliminarPorCliente($cliente->idcliente);
    for ($i = 0; $i < count($_POST["txtTipo"]); $i++) {
      $domicilio->fk_idcliente = $cliente->idcliente;
      $domicilio->fk_tipo = $_POST["txtTipo"][$i];
      $domicilio->fk_idlocalidad =  $_POST["txtLocalidad"][$i];
      $domicilio->domicilio = $_POST["txtDomicilio"][$i];
      $domicilio->insertar();
    }
  } 
  
}

if (isset($_GET["id"]) && $_GET["id"] != "") {
  $cliente->obtenerPorId();
}
if (isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad" && $_GET["id"] && $_GET["id"] > 0) {
  $idProvincia = $_GET["id"];
  $localidad = new Localidad();
  $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
  echo json_encode($aLocalidad);
  exit;
} else if (isset($_GET["id"]) && $_GET["id"] > 0) {
  $cliente->obtenerPorId();
}
if (isset($_GET["do"]) && $_GET["do"] == "cargarGrilla") {
  $idCliente = $_GET['idCliente'];
  $request = $_REQUEST;

  $entidad = new Domicilio();
  $aDomicilio = $entidad->obtenerFiltrado($idCliente);
 

  $data = array();

  if (count($aDomicilio) > 0)
    $cont = 0;
  for ($i = 0; $i < count($aDomicilio); $i++) {
    $row = array();
    $row[] = $aDomicilio[$i]->tipo;
    $row[] = $aDomicilio[$i]->provincia;
    $row[] = $aDomicilio[$i]->localidad;
    $row[] = $aDomicilio[$i]->domicilio;
    $cont++;
    $data[] = $row;
  }
  
  $json_data = array(
    "draw" => isset($request['draw']) ? intval($request['draw']) : 0,
    "recordsTotal" => count($aDomicilio), //cantidad total de registros sin paginar
    "recordsFiltered" => count($aDomicilio), //cantidad total de registros en la paginacion
    "data" => $data
  );
  echo json_encode($json_data);
  exit;
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
        <input type="text" name="txtNombre" class="form-control" value="<?php echo $cliente->nombre; ?>" required>
      </div>
      <div class="col-6 form-group mt-3">
        <label for="txtCuit">CUIT:</label>
        <input type="text" name="txtCuit" class="form-control" value="<?php echo $cliente->cuit; ?>" required>
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
            <div class="col-12" class="form-group">
              <label for="">Tipo</label>
              <select name="lstTipo" id="lstTipo" class="form-control">
                <option value="" selected>Seleccionar</option>
                <?php foreach ($aTipoUsuario as $tipo) : ?>
                  <option value="<?php echo $tipo->idtipo_usuario; ?>" selected><?php echo $tipo->nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Provincia</label>
              <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                <option value="" disabled selected>Seleccionar</option>
                <?php foreach ($aProvincias as $prov) : ?>
                  <option value="<?php echo $prov->idprovincia; ?>"><?php echo $prov->nombre; ?></option>
                <?php endforeach; ?>
              </select>

            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Localidad</label>
              <select name="lstLocalidades" id="lstLocalidades" class="form-control">
                <option value="" selected>Seleccionar</option>
              </select>
            </div>
          </div>
          <div class="row ml-2">
            <div class="col-12" class="form-group">
              <label for="">Direccion</label>
              <input type="text" class="form-control" id="txtDireccion" name="txtDireccion">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="cargarGrilla();">Cargar Datos</button>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  $(document).ready(function() {
    var idCliente = '<?php echo isset($cliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0 ?>';
    if (idCliente != 0 ) {
      var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": false,
        "bFilter": false,
        "bInfo": true,
        "bSearchable": false,
        "paging": false,
        "pageLength": 25,
        "order": [
          [0, "asc"]
        ],
        "ajax": "cliente-formulario.php?do=cargarGrilla&idCliente=" + idCliente
      });

    }

  });

  function cargarGrilla() {
    var grilla = $('#grilla').DataTable();
    grilla.row.add([
      $("#lstTipo option:selected").text() + "<input type='hidden' name='txtTipo[]' value='" + $("#lstTipo option:selected").val() + "'>",
      $("#lstProvincia option:selected").text() + "<input type='hidden' name='txtProvincia[]' value='" + $("#lstProvincia option:selected").val() + "'>",
      $("#lstLocalidades option:selected").text() + "<input type='hidden' name='txtLocalidad[]' value='" + $("#lstLocalidades option:selected").val() + "'>",
      $("#txtDireccion").val() + "<input type='hidden' name='txtDomicilio[]' value='" + $("#txtDireccion").val() + "'>"
    ]).draw();
    $('#modalDomicilio').modal('toggle');
    limpiarFormulario();
  }

  function limpiarFormulario() {
    $("#lstTipo").val("");
    $("#lstProvincia").val("");
    $("#lstLocalidades").val("");
    $("#txtDireccion").val("");
  }

  function fBuscarLocalidad() {
    idProvincia = $("#lstProvincia option:selected").val();

    $.ajax({
      type: "GET",
      url: "cliente-formulario.php?do=buscarLocalidad",
      data: {
        id: idProvincia
      },
      async: true,
      dataType: "json",
      success: function(respuesta) {
        let opciones = '<option value="0" selected disable>seleccionar</option>';
        const resultado = respuesta.reduce(function(acumulador, valor) {
          const {
            nombre,
            idlocalidad
          } = valor;
          return acumulador + `<option value="${idlocalidad}">${nombre}</option>`
        }, opciones);
        $('#lstLocalidades').empty().append(resultado);
      }
    });
  }
</script>

<?php include("footer.php"); ?>