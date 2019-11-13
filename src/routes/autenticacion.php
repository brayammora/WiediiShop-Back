<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//GET login
$app->post('/login', function (Request $request, Response $response) {

    $respuesta = new Respuesta();
    $huella =  $request->getParam('huella');

    if (isset($huella) && !empty($huella)) {
        $sql = "SELECT idUsuario, nombre, cedula FROM usuario where huellaDactilar = '$huella'";
        try {
            $db = new db();
            $db = $db->conectar();
            $consulta = $db->query($sql);
            if ($consulta->rowCount() > 0) {
                //acceso autorizado
                $respuesta->setResponse(true);
                $respuesta->result = $consulta->fetchAll(PDO::FETCH_OBJ);
            } else {
                $respuesta->message = "No existe ningún usuario con esa huella.";
            }
            //cierro conexiones
            $consulta = null;
            $db = null;
        } catch (PDOException $e) {
            $respuesta->message =  $e->getMessage();
        }
    } else {
        $respuesta->message = "Huella vacia: Acceso no autorizado.";
    }

    return json_encode($respuesta);
});

$app->get('/logout', function (Request $request, Response $response) {
    session_destroy();
    $respuesta = new Respuesta();
    $respuesta->message = "Sesion finalizada.";
    return json_encode($respuesta);
});
