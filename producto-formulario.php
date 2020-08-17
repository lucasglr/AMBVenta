<?php
include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);
$tipoProducto = new Tipoproducto();
$aTipoProducto=$tipoProducto->obtenerTodos();
$aMsj=array("mensaje"=>"","codigo"=>"");
$pg="Nuevo producto";

if($_POST){
   
    if(isset($_POST["btnGuardar"])){
        
        if(isset($_GET["id"])&&$_GET["id"]>0){
            //actualizar
            $producto->actualizar();
            $aMsj=array("mensaje"=>"Producto actualizado","codigo"=>"primary");
            header("refresh:2; url=producto-formulario.php");
        }else{
            //nuevo producto
            $producto->insertar();
            $aMsj=array("mensaje"=>"Producto insertado","codigo"=>"success");
            header("refresh:2; url=producto-formulario.php");
        }        

    }elseif (isset($_POST["btnBorrar"])&&isset($_GET["id"])){
        $producto->eliminar();
        $aMsj=array("mensaje"=>"Producto eliminado","codigo"=>"danger");
        header("refresh:2; url=producto-formulario.php");
    }
}
if(isset($_GET["id"])&& $_GET["id"]=!""){
    $producto->obtenerPorId();
    
}

?>
<?php include("header.php");?>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 ">
                <h1 class="h3 text-gray-800">Productos</h1>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="row my-3">
                <div class="col-6 ">
                    <a href="productos-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
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
                    <input type="text" name="txtNombre" class="form-control" value="<?php echo $producto->nombre?>">
                </div>
                <div class="col-6 form-group mt-3">
                        <label for="lstTipoProducto">Tipo de producto:</label>
                        <select name="lstTipoProducto" id="lstTipoProducto" class="form-control" value="<?php?>">
                            <option value disabled selected>Seleccionar</option>
                            <?php foreach ($aTipoProducto as $tipoProducto):?>
                                <?php if($tipoProducto->idtipoproducto==$producto->fk_idtipoproducto):?>
                                    <option selected value="<?php  echo $tipoProducto->idtipoproducto;?>"><?php echo $tipoProducto->nombre ;?></option>
                                <?php else :?>
                                    <option value="<?php echo $tipoProducto->idtipoproducto; ?>"><?php echo  $tipoProducto->nombre; ?></option>
                                <?php endif;?>
                                <?php endforeach;?>
                        </select>
                </div>
            </div>
            <div class="row">
                    <div class="col-6 form-group mt-1">
                        <label for="txtCantidad">Cantidad:</label>
                        <input type="text" name="txtCantidad" class="form-control" value="<?php echo $producto->cantidad;?>">
                    </div>
                    <div class="col-6 form-group mt-1">
                        <label for="txtPrecio">Precio:</label>
                        <input type="text" name="txtPrecio" class="form-control" value="<?php echo $producto->precio;?>">
                    </div>
            </div>
            <div class="row">
                    <div class="col-12 form-group mt-3">
                        <label for="txtDescripcion">Descripción:</label>
                        <textarea type="text" name="txtDescripcion" id="txtDescripcion" ><?php  echo $producto->descripcion;?></textarea> 
                        <script>
                            ClassicEditor
                                .create( document.querySelector( '#txtDescripcion' ) )
                                .catch( error => {
                                    console.error( error );
                                } );
                        </script>
                    </div>
            </div>
            <div class="row">
                <div class="col-12  ">
                    <label for="fileImagen">Imagen:</label>
                    <input type="file" class="form-control-file " name="fileImagen" class="form-control-file" require>
                </div>
            </div>
        </form>
    </div>
<?php include("footer.php");?>