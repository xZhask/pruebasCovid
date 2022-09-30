<?php
try {
    $manejador = 'mysql';
    $servidor = 'localhost';
    $usuario = 'root';
    $pass = 'mysql';
    $db = 'dbpruebas';
    //$usuario = 'odindeve_josue';
    //$pass = '1I~j0uCT{Va1'; 
    //$db = 'odindeveloper_pruebas';
    $cadena = "$manejador:host=$servidor;dbname=$db";
    $cnx = new PDO($cadena, $usuario, $pass, [
        PDO::ATTR_PERSISTENT => 'true',
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
    ]);
    date_default_timezone_set('America/Lima');
} catch (Exception $ex) {
    echo 'Error de acceso, informelo a la brevedad.';
    exit();
}
