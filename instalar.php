<?php

    include_once"config.php";
    include_once"entidades/usuario.php";

$usuario = new Usuario();
$usuario->usuario="lucasglr";
$usuario->nombre="Lucas";
$usuario->apellido="López";
$usuario->clave = $usuario->encriptarClave("admin123");
$usuario->correo ="lucas-glr@hotmail.com";
$usuario->insertar();


?>