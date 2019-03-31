<?php
$llave=mysqli_connect('localhost', 'reto', 'reto', 'reto');
//comruebo si hay errores
if (mysqli_connect_errno()) {
    echo "ERROR!! en conexion a la base de datos";
    echo "</br>Mensaje de error: ". mysqli_connect_errno();
    exit();
}
//para insertar los datos en utf8
mysqli_set_charset($llave, 'utf8');

?>