<?php
    include_once "config.php";
    include_once "entidades/cliente.php";
    include_once "entidades/domicilio.entidad.php";
    $pg="Listado de clientes";

    $cliente = new Cliente();
    $aCliente = $cliente->obtenerTodos();

    
?>

<?php
    include_once("header.php");
?>
          <!-- Begin Page Content -->
          <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12 ">
                        <h1 class=" h3 text-gray-800">Listado de clientes</h1>
                    </div>
                    <div class="col-12 my-3">
                        <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    </div>
                </div>
                <div class="row  my-2">
                    <div class="col-12">
                        <table class="table table-hover border">
                            <thead>
                                <tr>
                                    <th>CUIT</th>
                                    <th>Nombre</th>
                                    <th>Fecha nac.</th>
                                    <th>Correo</th>
                                    <th>Domicilios</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($aCliente as $cliente){ ?>
                                <tr>
                                    <td><?php echo $cliente->cuit; ?></td>
                                    <td><?php echo $cliente->nombre; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($cliente->fecha_nac)); ?></td>
                                    <td><?php echo $cliente->correo; ?></td>
                                    <td><?php echo $cliente->domicilio;?></td>
                                    <td><a href="cliente-formulario.php?id=<?php echo $cliente->idcliente;?>"><i class="fas fa-search"></a></td>
            
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>

          </div>
          

<?php
    include_once("footer.php");
?>