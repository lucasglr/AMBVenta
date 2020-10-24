<?php
include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";

$aMsj="";
$venta = new Venta();
$venta->cargarFormulario($_REQUEST);
$pg="Nueva venta";
$cliente = new Cliente();
$aCliente=$cliente->obtenerTodos();
$producto= new Producto();
$aProducto=$producto->obtenerTodos();
date_default_timezone_set("America/Argentina/Buenos_Aires");

if($_POST){
    
    if(isset($_POST["btnGuardar"])){
      if(isset($_GET["id"])&& $_GET['id']>0){
        //actualizar un cliente
        $venta->actualizar();
        $aMsj=array("mensaje"=>"Venta actualizada","codigo"=>"primary");
        
      }else{
        //agregar un cliente
        $venta->insertar();
        $aMsj=array("mensaje"=>"Venta agregada","codigo"=>"success");
        header("refresh:2; url=venta-formulario.php");
      }
    }elseif(isset($_POST["btnBorrar"])&&isset($_GET["id"])){
      $venta->eliminar();
      $aMsj=array("mensaje"=>"Venta eliminada","codigo"=>"danger");
      header("refresh:2; url=venta-formulario.php");
    }
  
}
if(isset($_GET["id"])&&$_GET["id"]=!""){
     $venta->obtenerPorId();
   
}


if(isset($_GET['idproducto']) && $_GET["do"]=='buscarPrecio' && $_GET["idproducto"] > 0){
   
    $idProducto = $_GET['idproducto'];
    $producto = new Producto();
    $aProducto=$producto-> obtenerPrecioPorId($idProducto);
    echo json_encode($aProducto);
    exit;
}

?>

<?php include("header.php");?>
<div class="container">
    <div class="row mt-3">
        <div class="col-12 ">
            <h1 class="h3 text-gray-800">Venta</h1>
        </div>
    </div>
    <form action="" method="post">    
        <div class="row my-3">
            <div class="col-6 ">
                <a href="ventas-listado.php" class="btn btn-primary mr-2">Listado</a>
                <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
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
                <label for="txtFecha">Fecha:</label>
                <input type="date" name="txtFecha" class="form-control" value="<?php  echo (isset($_GET["id"])&&$_GET["id"]=!"")?"$venta->fecha":date('Y-m-d')?>" >
            </div>
            <div class="col-6 form-group mt-3">
                <label for="txtHora">Hora:</label>
                <input type="time" name="txtHora" class="form-control" value="<?php echo (isset($_GET["id"])&&$_GET["id"]=!"")?"$venta->hora":date('H:i') ;?>">
            </div>
            
        </div>
        <div class="row">
            <div class="col-6 form-group mt-1">
                <label for="lstCliente">Cliente:</label>
                <select name="lstCliente" id="lstCliente" class="form-control  selectpicker" data-live-search="true" require="">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach($aCliente as $cliente){?>
                        <?php if($cliente->idcliente==$venta->fk_idcliente):?>
                            <option selected value="<?php echo $venta->fk_idcliente;?>"><?php echo $cliente->nombre; ?></option>
                        <?php else:?>
                            <option value="<?php echo $cliente->idcliente;?>"><?php echo $cliente->nombre;?></option>
                        <?php endif;?>
                    <?php }?>
                </select>
            </div>
            <div class="col-6 form-group mt-1">
                <label for="lstProducto">Producto:</label>
                <select name="lstProducto" id="lstProducto" class="form-control selectpicker" data-live-search="true">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach ($aProducto as $producto){?>
                        <?php if($producto->idproducto==$venta->fk_idproducto):?>
                            <option selected value="<?php echo $venta->fk_idproducto;?>"><?php echo $producto->nombre; ?></option>
                        <?php else:?>
                            <option value="<?php echo $producto->idproducto;?>"><?php echo $producto->nombre;?></option>
                        <?php endif;?>
                    <?php } ?>    
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="txtPrecioUnitario">Precio unitario:</label>
                <input type="text" name="txtPrecioUnitario" id="txtPrecioUnitario" class="form-control" placeholder="0" value="<?php echo (isset($_GET["id"])&&$_GET["id"]=!"")?'$'.number_format($venta->preciounitario,"2",",","."):""?>" >
            </div>     
            <div class="col-6">
                <label for="txtCantidad">Cantidad:</label>
                <input type="text" name="txtCantidad" id="txtCantidad" class="form-control" placeholder="0" value="<?php echo $venta->cantidad?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="txtTotal">Total</label>
                <input type="text" name="txtTotal" id="txtTotal" class="form-control" placeholder="0" value="<?php echo (isset($_GET["id"])&&$_GET["id"]=!"")?'$'.number_format($venta->total,"2",",","."):""?>">
            </div>
        </div>
    </form>
        
</div>
<script>
$('#lstProducto').change(function(event){
    let idproducto = event.target.value;
    $.ajax({
        type:"GET",
        url : "venta-formulario.php?do=buscarPrecio",
        data:{
            idproducto:idproducto
        },
        async: true,
        dataType: "json",
        success: function(respuesta) {
            let precio = respuesta.precio;
            $('#txtPrecioUnitario').prop('value',precio);
        }
    });
});
$('#txtCantidad').change(function(){
    let precio =$('#txtPrecioUnitario').val();
    let cantidad = $('#txtCantidad').val();
    let total = precio * cantidad;
    $('#txtTotal').prop('value',total);
})
</script>
<?php include("footer.php");?>