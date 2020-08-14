<?php
include_once "config.php";
include_once "entidades/tipoproducto.php";
$tipodeproducto= new Tipoproducto();
$tipodeproducto->cargarFormulario($_REQUEST);
$aMsj=array("mensaje"=>"","codigo"=>"");

if($_POST){
    if(isset($_POST["btnGuardar"])){
        
        if(isset($_GET["id"])&& $_GET['id']>0){
            $tipodeproducto->actualizar();
            $aMsj=array("mensaje"=>"Tipo de producto actualizado","codigo"=>"primary");
        }else{
            $tipodeproducto->insertar();
            $aMsj=array("mensaje"=>"Tipo de producto cargado","codigo"=>"success");
        }
    }elseif(isset($_POST["btnBorrar"])&&isset($_GET["id"])){
        $tipodeproducto->eliminar();
        $aMsj=array("mensaje"=>"Tipo de producto ","codigo"=>"danger");
    }
   
}  
if(isset($_GET["id"])&&$_GET["id"]!=""){
    $tipodeproducto->obtenerPorId();
    
} 
?>

<?php include("header.php"); ?>
<div class="container">
    <div class="row mt-3">
        <div class="col-12 ">
            <h1 class="h3 text-gray-800">Tipo de producto</h1>
        </div>
    </div>
    <form action="" method="POST">
        <div class="row my-3">
            <div class="col-6 ">
                <a href="tipoproducto.php" class="btn btn-primary mr-2">Listado</a>
                <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
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
            <div class="col-12 form-group mt-3">
                <label for="txtNombre">Nombre:</label>
                <input type="text" name="txtNombre" class="form-control" value="<?php echo $tipodeproducto->nombre; ?>" >
            </div>
        </div>
    </form>
</div>
<?php include("footer.php"); ?>