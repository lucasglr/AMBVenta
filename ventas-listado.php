<?php
include_once("header.php");
?>
<div class="container">
  <div class="row mt-3">
    <div class="col-12 ">
      <h1 class=" h3 text-gray-800">Listado de ventas</h1>
    </div>
    <div class="col-12 my-3">
      <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
    </div>
  </div>
  <div class="row  my-2">
    <div class="col-12">
      <table class="table table-hover border">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th></th>
            <td><a href=""><i class="fas fa-search"></a></td>
          </tr>
        </tbody>

      </table>
    </div>
  </div>

</div>

<?php
include_once("footer.php");
?>