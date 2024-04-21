<?php
namespace App\controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;

class Artefacto {
    protected $container;
    public function __construct(ContainerInterface $c){
        $this->container = $c;
    }

    function create(Request $request, Response $response, $args) {

        $body = json_decode($request->getBody());

        $sql = "INSERT INTO artefacto (id, idCliente, serie, marca, modelo, categoria, descripcion) 
        VALUES ($body->id, '$body->idCliente', '$body->serie', '$body->marca', '$body->modelo', '$body->categoria', '$body->descripcion')";


        $con = $this->container->get('bd');

        $query = $con->prepare($sql);

        $query->execute();

        $status = $query->rowCount() > 0 ?201:409;  

        $query=null;
        $con=null;
      

        return $response->withStatus($status);
    }




    function read(Request $request, Response $response, $args) {
            $sql = "SELECT * FROM artefacto";
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

        $sql = "UPDATE artefacto SET 
        idCliente = '$body->idCliente', 
        serie = '$body->serie', 
        marca = '$body->marca', 
        modelo = '$body->modelo', 
        categoria = '$body->categoria', 
        descripcion = '$body->descripcion' 
        WHERE id = $body->id";


        $con = $this->container->get('bd');

        $query = $con->prepare($sql);

        $query->execute();

        $status = $query->rowCount() > 0 ?200:204;  

        $query=null;
        $con=null;
      
        return $response->withStatus($status);

    }





    function delete(Request $request, Response $response, $args) {
        $id= $args['id'];
        $sql = "DELETE FROM artefacto WHERE id = $id";
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

        $sql = "SELECT * FROM artefacto WHERE id = $id";
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