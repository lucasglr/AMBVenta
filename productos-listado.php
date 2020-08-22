<?php
include_once "config.php";
include_once "entidades/producto.php";

$producto = new Producto();
$aProducto = $producto->obtenerTodos();
$pg="Listado de productos";

?>

<?php
include_once("header.php");
?>
    <div class="container">
      <div class="row mt-3">
        <div class="col-12 ">
          <h1 class=" h3 text-gray-800">Listado de productos</h1>
        </div>
        <div class="col-12 my-3">
          <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
        </div>
      </div>
      <div class="row  my-2">
        <div class="col-12">
          <table class="table table-hover border">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if(is_array($aProducto)){ foreach($aProducto as $producto ){ ?>
                <tr>
                  <td><img src="<?php echo "img/".$producto->imagen;?>" alt="<?php echo $producto->imagen;?>" class="img-thumbnail" width="60px"></td>
                  <td><?php echo $producto->nombre?></td>
                  <td><?php echo $producto->cantidad?></td>
                  <td><?php echo '$'.number_format($producto->precio,"2",",",".");?></td>
                  <td><a href="producto-formulario.php?id=<?php echo $producto->idproducto?>"><i class="fas fa-search"></a></td>
                </tr>
              <?php }}?>
            </tbody>

          </table>
        </div>
      </div>

    </div>
<?php
include_once("footer.php");
?>