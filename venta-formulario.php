<?php include("header.php");?>
<div class="container">
    <div class="row mt-3">
        <div class="col-12 ">
            <h1 class="h3 text-gray-800">Venta</h1>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-12 ">
            <a href="ventas-listado.php" class="btn btn-primary mr-2">Listado</a>
            <a href="" class="btn btn-primary mr-2">Nuevo</a>
            <button type="submit" class="btn btn-success mr-2">Guardar</button>
            <button type="submit" class="btn btn-danger mr-2">Borrar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group mt-3">
            <label for="txtFecha">Fecha:</label>
            <input type="date" name="txtFecha" class="form-control " >
        </div>
        <div class="col-6 form-group mt-3">
            <label for="txtHora">Hora:</label>
            <input type="time" name="txtHora" class="form-control" >
        </div>
        
    </div>
    <div class="row">
        <div class="col-6 form-group mt-1">
            <label for="lstCliente">Cliente:</label>
            <select name="lstCliente" id="lstCliente" class="form-control">
                <option value disabled selected>Seleccionar</option>
            </select>
        </div>
        <div class="col-6 form-group mt-1">
            <label for="lstProducto">Producto:</label>
            <select name="lstProducto" id="lstProducto" class="form-control">
                <option value disabled selected>Seleccionar</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="txtPrecioUnitario">Precio unitario:</label>
            <input type="number" name="txtPrecioUnitario" id="txtPrecioUnitario" class="form-control" placeholder="0">
        </div>
        <div class="col-6">
            <label for="txtCantidad">Cantidad:</label>
            <input type="number" name="txtCantidad" id="txtCantidad" class="form-control" placeholder="0">
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="txtTotal">Total</label>
            <input type="number" name="txtTotal" id="txtTotal" class="form-control" placeholder="0">
        </div>
    </div>
    
</div>
<?php include("footer.php");?>