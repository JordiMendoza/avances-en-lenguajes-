<?php
namespace App\controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;

class Cliente {
    protected $container;
    public function __construct(ContainerInterface $c){
        $this->container = $c;
    }

    function create(Request $request, Response $response, $args) {

        $body = json_decode($request->getBody());

        $sql = "INSERT INTO cliente (idCliente, nombre, apellido1, apellido2, telefono, celular, direccion, correo, FechaIngreso)". "VALUES ('$body->idCliente', '$body->nombre', '$body->apellido1', '$body->apellido2', '$body->telefono', '$body->celular', '$body->direccion', '$body->correo', NOW())";

        $con = $this->container->get('bd');

        $query = $con->prepare($sql);

        $query->execute();

        $status = $query->rowCount() > 0 ?201:409;  

        $query=null;
        $con=null;
      
       # $body[1]['id'] = 15;

        #$response->getBody()->write(json_encode($body));

        return $response->withStatus($status);
    }




    function read(Request $request, Response $response, $args) {
            $sql = "SELECT * FROM cliente";
            $con = $this->container->get('bd');

            $query = $con->prepare($sql);
            $query->execute();

            $res = $query->fetchAll();

            $status = $query->rowCount() > 0 ?200:204;

            $query=null;
            $con=null;


        $response->getBody()->write(json_encode($res));
        return $response 
        ->withHeader('Content-type','Application/json')
        ->withStatus($status);
    }
    function update(Request $request, Response $response, $args) {

        $id= $args['id'];
        $body = json_decode($request->getBody());

        $sql = "UPDATE cliente SET 
        idCliente = '$body->idCliente', 
        nombre = '$body->nombre', 
        apellido1 = '$body->apellido1', 
        apellido2 = '$body->apellido2', 
        telefono = '$body->telefono', 
        celular = '$body->celular', 
        direccion = '$body->direccion', 
        correo = '$body->correo', 
        FechaIngreso = NOW()
        WHERE id = $id";


        $con = $this->container->get('bd');

        $query = $con->prepare($sql);

        $query->execute();

        $status = $query->rowCount() > 0 ?200:204;  

        $query=null;
        $con=null;
      
       # $body[1]['id'] = 15;

        #$response->getBody()->write(json_encode($body));

        return $response->withStatus($status);








    }
    function delete(Request $request, Response $response, $args) {
        $id= $args['id'];
        $sql = "DELETE FROM cliente WHERE id = $id";
        $con = $this->container->get('bd');
        $query = $con->prepare($sql);
        $query->execute();
       
        #$query=null;
        #$con=null;
     
        $status = $query->rowCount() > 0 ?200:204; 

        return $response 
        ->withStatus(200);

    }

    function buscar(Request $request, Response $response, $args) {
        $id= $args['id'];

        $sql = "SELECT * FROM cliente WHERE id = $id";
        $con = $this->container->get('bd');

        $query = $con->prepare($sql);
        $query->execute();

        $res = $query->fetchAll();

        $status = $query->rowCount() > 0 ?200:204;  

        $query=null;
        $con=null;


    $response->getBody()->write(json_encode($res));
    return $response 
    ->withHeader('Content-type','Application/json')
    ->withStatus($status);
}










}
