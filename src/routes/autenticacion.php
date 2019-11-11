<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//GET login
$app->get('/login', function (Request $request, Response $response) {

    $huella =  $request->getAttribute('huella');

    if (isset($huella)) {
        $sql = "SELECT * FROM usuario where huellaDactilar = $huella";
        try {
            $db = new db();
            $db = $db->conectar();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
                $_SESSION["usuario"] = json_encode($usuario);
                echo json_encode($usuario); //acceso autorizado
            } else {
                echo json_encode("No existen ningún usuario con esa huella.");
            }
            $resultado = null;
            $db = null;
        } catch (PDOException $e) {
            echo '{"error" : "text": ' . $e->getMessage() . '}';
        }
    } else {
        echo json_encode("Huella vacia: Acceso no autorizado.");
    }
});

$app->get('/logout', function (Request $request, Response $response) {
    session_destroy();
    return $response->withJson(array("ok" => "Sesion finalizada."));
});
