<?php
include_once "config.php";
include_once "entidades/tipoproducto.php";
$tipoproducto = new Tipoproducto();
$aTipodeproducto = $tipoproducto->obtenerTodos();

?>

<?php
include_once("header.php");
?>
          <div class="container">
            <div class="row mt-3">
                <div class="col-12 ">
                    <h1 class=" h3 text-gray-800 ">Listado de tipos de productos</h1>
                </div>
                <div class="col-12 my-3">
                    <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2" >Nuevo</a>
                </div>
            </div>
            <div class="row  my-2">
                <div class="col-12">
                    <table class="table table-hover border">
                        <thead>
                            <tr>
                                <th style="width:85% ;">Nombre</th>
                                <th>Acciones</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($aTipodeproducto)) { foreach ($aTipodeproducto as $tipoproducto){?>
                            <tr>
                                <td><?php echo $tipoproducto->nombre;?></td>
                                <td><a href="tipoproducto-formulario.php?id=<?php echo $tipoproducto->idtipoproducto; ?>"><i class="fas fa-search"></a></td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>

          </div>

<?php
include_once("footer.php");
?>