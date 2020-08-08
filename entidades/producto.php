<?php
class Producto{
    private $idproducto;
    private $nombre;
    private $fk_idtipoproducto;
    private $cantidad;
    private $precio;
    private $descripcion;
    private $imagen;

    public function __construct()
    {
        
    }
    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }
    public function cargarFormulario($request){
        $this->idproducto = isset($request["id"])? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
        $this->fk_idtipoproducto = isset($request["lstTipoProducto"])? $request["lstTipoProducto"]: "";
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"]: "";
        $this->precio = isset($request["lstPrecio"])? $request["lstPrecio"] : "";
        $this->descripcion = isset($request["txtDescripcion"])? $request["txtDescripcion"] :"";
        $this->imagen = isset($request["txtImagen"])? $request["txtImagen"]:"";
    }
    public function insertar(){
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        //Arma la query
        $sql = "INSERT INTO productos (
                    nombre, 
                    fk_idtipoproducto, 
                    cantidad, 
                    precio, 
                    descripcion,
                    imagen
                ) VALUES (
                    '".$this->nombre."',
                    '. $this->fk_idtipoproducto .', 
                    '. $this->cantidad.', 
                    '. $this->precio .', 
                    '" . $this->descripcion ."',
                    '" . $this->imagen ."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idproducto = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }
    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE productos SET
                nombre = '".$this->nombre."',
                fk_idtipoproducto = '".$this->fk_idtipoproducto."',
                cantidad = '".$this->cantidad."',
                precio = '".$this->precio."',
                descripcion =  '".$this->descripcion."'
                WHERE idproducto = " . $this->idproducto;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM productos WHERE idproducto = " . $this->idproducto;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }
    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idproducto, 
                    nombre, 
                    fk_idtipoproducto, 
                    cantidad, 
                    precio, 
                    descripcion,
                    imagen 
                FROM productos 
                WHERE idproducto = " . $this->idproducto;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if($fila = $resultado->fetch_assoc()){
            $this->idproducto = $fila["idproducto"];
            $this->nombre = $fila["nombre"];
            $this->fk_idtipoproducto= $fila["fk_idproducto"];
            $this->cantidad = $fila["cantidad"];
            $this->precio = $fila["precio"];
            $this->descripcion = $fila["descripcion"];
            $this->imagen = $fila["imagen"];
        }  
        $mysqli->close();

    }

  public function obtenerTodos(){
        $aProducto = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT
        A.idProducto,
        A.fk_idtipoproducto,
        A.nombre,
        A.cantidad,
        A.precio
        A.descripcion
        A.imagen
        FROM
        productos A
        ORDER BY
        idproductos DESC";
        $resultado = $mysqli->query($sql);

        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Producto();
                $obj->idproducto = $fila["idproducto"];
                $obj->fk_idtipoproducto = $fila["fk_idtipodeproducto"];
                $obj->nombre = $fila["nombre"];
                $obj->cantidad = $fila["cantidad"];
                $obj->precio = $fila["precio"];
                $obj->descripcion = $fila["descripcion"];
                $obj->imagen = $fila["imagen"];

                $aProducto[] = $obj;

            }
            return $aProducto;
        }
    }

}


?>

