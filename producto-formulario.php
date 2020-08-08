<?php
include_once "config.php";
include_once "entidades/producto.php";
$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"])&&$_GET["id"]>0){
            //actualizar
            $producto->actualizar(); 
        }else{
            //nuevo producto
            $producto->insertar();
        }        

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
        <div class="row my-3">
            <div class="col-12 ">
                <a href="productos-listado.php" class="btn btn-primary mr-2">Listado</a>
                <a href="" class="btn btn-primary mr-2">Nuevo</a>
                <button type="submit" class="btn btn-success mr-2" name="btnGuardar">Guardar</button>
                <button type="submit" class="btn btn-danger mr-2">Borrar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 form-group mt-3">
                <label for="txtNombre">Nombre:</label>
                <input type="text" name="txtNombre" class="form-control">
            </div>
            <div class="col-6 form-group mt-3">
                <label for="lstTipoProducto">Tipo de producto:</label>
                <select name="lstTipoProducto" id="lstTipoProducto" class="form-control">
                    <option value disabled selected>Seleccionar</option>
                    <option value="1">Electrodomestico</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6 form-group mt-1">
                <label for="txtCantidad">Cantidad:</label>
                <input type="text" name="txtCantidad" class="form-control" value="10">
            </div>
            <div class="col-6 form-group mt-1">
                <label for="lstPrecio">Precio:</label>
                <select name="lstPrecio" id="lstPrecio" class="form-control" >
                    <option value disabled selected>0</option>
                    <option value="80000">80000</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group mt-3">
                <label for="txtDescripcion">Descripción:</label>
                <textarea type="text" name="txtDescripcion" id="txtDescripcion"></textarea> 
                <script>
                    ClassicEditor
                        .create( document.querySelector( '#txtDescripcion' ) )
                        .catch( error => {
                            console.error( error );
                        } );
                </script>
            </div>
        </div>
        
    </div>
<?php include("footer.php");?>