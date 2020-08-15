<?php

class Venta {
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $hora;
    private $cantidad;
    private $preciounitario;
    private $total;

    public function __construct(){

    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }

    public function cargarFormulario($request){
        $this->idventa = isset($request["id"])? $request["id"] : "";
        $this->fk_idcliente = isset($request["lstCliente"])? $request["lstCliente"] : "";
        $this->fk_idproducto = isset($request["lstProducto"])? $request["lstProducto"]: "";
        $this->fecha = isset($request["txtFecha"])? $request["txtFecha"]: "";
        $this->hora = isset($request["txtHora"])? $request["txtHora"]: "";
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"] : "";
        $this->preciounitario = isset($request["txtPrecioUnitario"])? $request["txtPrecioUnitario"] :"";
        $this->total = isset($request["txtTotal"])? $request["txtTotal"] :"";
    }

    public function insertar(){
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        //Arma la query
        $sql = "INSERT INTO ventas (
                    fk_idcliente,
                    fk_idproducto, 
                    fecha,
                    hora, 
                    cantidad, 
                    preciounitario, 
                    total
                ) VALUES (
                    '" . $this->fk_idcliente ."', 
                    '" . $this->fk_idproducto ."', 
                    '" . $this->fecha ."',
                    '" . $this->hora ."', 
                    '" . $this->cantidad ."', 
                    '" . $this->preciounitario ."',
                    '" . $this->total ."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idventa = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE ventas SET
                fk_idproducto = '".$this->fk_idproducto."',
                fk_idcliente = '".$this->fk_idcliente."',
                fecha = '".$this->fecha."',
                hora = '".$this->hora."',
                cantidad = '".$this->cantidad."',
                preciounitario =  '".$this->preciounitario."',
                total = '".$this->total."'
                WHERE idventa = " . $this->idventa;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idventa, 
                    fk_idcliente,
                    fk_idproducto, 
                    fecha,
                    hora, 
                    cantidad, 
                    preciounitario, 
                    total 
                FROM ventas 
                WHERE idventa = " . $this->idventa;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        //Convierte el resultado en un array asociativo
        if($fila = $resultado->fetch_assoc()){
           
            $this->idventa = $fila["idventa"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->hora = $fila["hora"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total = $fila["total"];

        }  
        $mysqli->close();

    }

  public function obtenerTodos(){
        $aVenta = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT
        A.idventa,
        C.nombre AS cliente,
        B.nombre AS producto, 
        A.fecha,
        A.hora, 
        A.cantidad, 
        A.preciounitario, 
        A.total
        FROM
        ventas A 
        INNER JOIN productos B ON A.fk_idproducto = B.idproducto
		INNER JOIN clientes C ON A.fk_idcliente = C.idcliente 
        ORDER BY
        A.idventa DESC";
        $resultado = $mysqli->query($sql);

        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Venta();
                $obj->idventa = $fila["idventa"];
                $obj->fk_idcliente = $fila["cliente"];
                $obj->fk_idproducto = $fila["producto"];
                $obj->fecha = $fila["fecha"];
                $obj->hora = $fila["hora"];
                $obj->cantidad = $fila["cantidad"];
                $obj->preciounitario = $fila["preciounitario"];
                $obj->total = $fila["total"];
                $aVenta[] = $obj;

            }
            return $aVenta;
        }
    }

    public function obtenerFacturacionMensual($mes){
            $total_mensual = "";
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT SUM(total) AS total_mensual
                    FROM ventas
                    WHERE MONTH(fecha) = $mes;";
            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            //Convierte el resultado en un array asociativo
            if($fila = $resultado->fetch_assoc()){
                $total_mensual = $fila["total_mensual"];
            }
            return $total_mensual;
            $mysqli->close();
        
        
    }
    public function obtenerFacturacionAnual($anio){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE YEAR(fecha) = '$anio'";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }else{
            $fila = $resultado->fetch_assoc();
            return $fila["total"];
            $mysqli->close();
        }
    }



}
?>