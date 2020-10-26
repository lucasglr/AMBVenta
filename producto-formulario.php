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

if(isset($_GET["id"])&& $_GET["id"]=!""){
    $producto->obtenerPorId();

}
if($_POST){
    
    if(isset($_POST["btnGuardar"])){
        
        
        if ($_FILES["fileImagen"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["fileImagen"]["tmp_name"];
            $nombreArchivo = $_FILES["fileImagen"]["name"];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreImagen = $nombreAleatorio . "." . $extension;
            move_uploaded_file($archivo_tmp, "img/$nombreImagen");    
            
        }
    
        if(isset($_GET["id"])&&$_GET["id"]>0){
           
            $producto->nombre=$_POST["txtNombre"];
            $producto->fk_idtipoproducto=$_POST["lstTipoProducto"];
            $producto->cantidad=$_POST["txtCantidad"];
            $producto->precio=$_POST["txtPrecio"];
            $producto->descripcion=$_POST["txtDescripcion"];
            $imagenAnterior=$producto->imagen;
           
            if ($_FILES["fileImagen"]["error"] != UPLOAD_ERR_OK){//Si no se adjunta la imagen , queda la imagen anterior
                $producto->imagen=$imagenAnterior;
                
            }else{
                if($imagenAnterior!=""){//se adjunta nueva imagen , se borra la anterior y actualiza la nueva 
                    unlink("img/".$imagenAnterior);
                }
                $producto->imagen=$nombreImagen;    
            }
            
             //actualizar
             $producto->actualizar();
             $aMsj=array("mensaje"=>"Producto actualizado","codigo"=>"primary");
             header("refresh:2; url=producto-formulario.php");
            
        }else{
           
            //nuevo producto
            $producto->imagen=$nombreImagen;
            $producto->insertar();
            $aMsj=array("mensaje"=>"Producto insertado","codigo"=>"success");
            header("refresh:2; url=producto-formulario.php");
        }        

    }elseif (isset($_POST["btnBorrar"])&&isset($_GET["id"])){
        $producto->obtenerPorId();
        if($producto->imagen !=""){
            $imagen=$producto->imagen;
            unlink("img/".$imagen);
        }
        $producto->eliminar();
        $aMsj=array("mensaje"=>"Producto eliminado","codigo"=>"danger");
        header("refresh:2; url=producto-formulario.php");
        
    }
}


?>
<?php include("header.php");?>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 ">
                <h1 class="h3 text-gray-800">Productos</h1>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" >
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
                    <input type="text" name="txtNombre" class="form-control" value="<?php echo $producto->nombre?>" required>
                </div>
                <div class="col-6 form-group mt-3">
                    <label for="lstTipoProducto">Tipo de producto:</label>
                    <select name="lstTipoProducto" id="lstTipoProducto" class="form-control" value="" required>
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
                        <input type="text" name="txtCantidad" class="form-control" value="<?php echo $producto->cantidad;?>" required>
                    </div>
                    <div class="col-6 form-group mt-1">
                        <label for="txtPrecio">Precio:</label>
                        <input type="text" name="txtPrecio" class="form-control" value="<?php echo $producto->precio;?>" required>
                    </div>
            </div>
            <div class="row">
                    <div class="col-12 form-group mt-3">
                        <label for="txtDescripcion">Descripción:</label>
                        <textarea type="text" name="txtDescripcion" id="txtDescripcion"><?php  echo $producto->descripcion;?></textarea> 
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
                <div class="col-12">
                    <label for="fileImagen" >Imagen:</label>
                    <br>
                    <?php if (isset($_GET["id"])&&$_GET["id"]=!""):?>
                        <img src="<?php echo "img/".$producto->imagen; ?>" alt="" class="img-thumbnail" width="60px">
                    <?php endif;?>
                    <input type="file" class="form-control-file mt-2" name="fileImagen" value="<?php echo $producto->imagen ?>" required>
                </div>
            </div>
        </form>
    </div>
<?php include("footer.php");?>