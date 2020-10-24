<?php


class Tipo_usuario{
    private $idproducto;
    private $nombre;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }

    public function obtenerTodo(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql="SELECT idtipo_usuario, nombre FROM tipos_usuarios";
        $resultado = $mysqli->query($sql);
        $aTipoUsuario=array();
        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Tipo_usuario();
                $obj->idtipo_usuario= $fila["idtipo_usuario"];
                $obj->nombre = $fila["nombre"];
                $aTipoUsuario[] = $obj;

            }
            return $aTipoUsuario;
        }
       
    }
}

?>