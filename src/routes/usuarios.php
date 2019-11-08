<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET Listar todos los usuarios
$app->get('/api/usuarios', function (Request $request, Response $response) {
    $sql = "SELECT * FROM usuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $usuarios = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($usuarios);
        } else {
            echo json_encode("No existen ningún usuario.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//GET Consultar usuario
$app->get('/api/usuarios/{id}', function (Request $request, Response $response) {
    $idUsuario =  $request->getAttribute('id');
    $sql = "SELECT * FROM usuario where idUsuario = $idUsuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $usuarios = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($usuarios);
        } else {
            echo json_encode("No existe el usuario.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//POST Agregar usuario
$app->post('/api/usuarios/nuevo', function (Request $request, Response $response) {
    
    $nombre = $request->getParam('nombre');
    $cedula = $request->getParam('cedula');
    $correo = $request->getParam('correo');
    $huellaDactilar = $request->getParam('huellaDactilar');
    $sql = "INSERT INTO usuario (nombre, cedula, correo, huellaDactilar) VALUES
            (:nombre, :cedula, :correo, :huellaDactilar)";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':cedula', $cedula);
        $resultado->bindParam(':correo', $correo);
        $resultado->bindParam(':huellaDactilar', $huellaDactilar);

        $resultado->execute();
        echo json_encode("Nuevo usuario guardado.");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//PUT Modificar usuario
$app->post('/api/usuarios/nuevo', function (Request $request, Response $response) {
    
    $nombre = $request->getParam('nombre');
    $cedula = $request->getParam('cedula');
    $correo = $request->getParam('correo');
    $huellaDactilar = $request->getParam('huellaDactilar');
    $sql = "INSERT INTO usuario (nombre, cedula, correo, huellaDactilar) VALUES
            (:nombre, :cedula, :correo, :huellaDactilar)";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':cedula', $cedula);
        $resultado->bindParam(':correo', $correo);
        $resultado->bindParam(':huellaDactilar', $huellaDactilar);

        $resultado->execute();
        echo json_encode("Nuevo usuario guardado.");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});