<?php 
include_once "config.php";
include_once "entidades/venta.php";
$venta = new Venta();
$aVenta = $venta->obtenerTodos();
$pg="Listado de ventas";
?>

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
        <?php if(is_array($aVenta)):?>
        <?php foreach ($aVenta as $venta):?>
          <tr>
            <td><?php echo $venta->fecha;?></td>
            <td><?php echo $venta->cantidad;?></td>
            <td><?php echo $venta->fk_idproducto;?></td>
            <td><?php echo $venta->fk_idcliente;?></td>
            <th><?php echo '$'.number_format($venta->total,"2",",",".")?></th>
            <td><a href="venta-formulario.php?id=<?php echo $venta->idventa;?>"><i class="fas fa-search"></a></td>
          </tr>
        <?php endforeach;?>
        <?php endif ;?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php
include_once("footer.php");
?>