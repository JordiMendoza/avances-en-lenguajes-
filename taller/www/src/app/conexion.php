<?php
use Psr\Container\ContainerInterface;
$container->set('bd',function(ContainerInterface $c){
    $conf = $c ->get('config_bd');

    $opc = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ
    ];

    $dsn = "mysql:host=$conf->host;dbname=$conf->db;charset=$conf->charset";

    try{
        $con = new PDO($dsn, $conf->usr,$conf->passw,$opc);
       // die("conectado a la base de datos");



    }catch(PDOException $e){
       // print($e->getMessage());
        die("error conectando a la base de datos");
    }
        return $con;
});