
<?php
include_once "config.php";
include_once "entidades/cliente.php";

$pg="Edición de cliente";
$aMsj=array("codigo"=>"","mensaje"=>"");

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

if($_POST){
  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"])&& $_GET['id']>0){
      //actualizar un cliente
      $cliente->actualizar();
      $aMsj=array("mensaje"=>"Cliente actualizado","codigo"=>"primary");
      header("refresh:2; url=producto-formulario.php");
    }else{
      //agregar un cliente
      $cliente->insertar();
      $aMsj=array("mensaje"=>"Cliente agregado","codigo"=>"success");
      header("refresh:2; url=producto-formulario.php");
    }
  }elseif(isset($_POST["btnBorrar"])&&isset($_GET["id"])){
    $cliente->eliminar();
    $aMsj=array("mensaje"=>"Cliente eliminado","codigo"=>"danger");
    header("refresh:2; url=producto-formulario.php");
  }

}
if(isset($_GET["id"])&&$_GET["id"]!=""){
  $cliente->obtenerPorId();

 }
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
        <?php if($aMsj !=""):?>
            <div class="alert alert-<?php echo $aMsj["codigo"];?>" role="alert">
              <?php echo $aMsj["mensaje"];?>
            </div>
        <?php endif;?>  
      </div>
    </div>
    <div class="row">
      <div class="col-6 form-group mt-3">
        <label for="txtNombre">Nombre:</label>
        <input type="text" name="txtNombre" class="form-control" value="<?php echo $cliente->nombre;?>">
      </div>
      <div class="col-6 form-group mt-3">
        <label for="txtCuit">CUIT:</label>
        <input type="text" name="txtCuit" class="form-control" value="<?php echo $cliente->cuit;?>">
      </div>
    </div>
    <div class="row">
      <div class="col-6 form-group mt-1">
        <label for="txtFechaNacimiento">Fecha de nacimiento</label>
        <input type="date" name="txtFechaNac" class="form-control" value="<?php echo $cliente->fecha_nac;?>">
      </div>
      <div class="col-6 form-group mt-1">
        <label for="txtTelefono">Teléfono:</label>
        <input type="number" name="txtTelefono" class="form-control" value="<?php echo $cliente->telefono;?>">
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <label for="txtCorreo">Correo:</label>
        <input type="email" class="form-control" name="txtCorreo" value="<?php echo $cliente->correo;?>">
      </div>
    </div>
  </form>
</div>
<?php include("footer.php"); ?>