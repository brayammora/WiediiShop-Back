<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//GET Listar todos los usuarios
$app->get('/user', function (Request $request, Response $response) {

    $respuesta = new Respuesta();
    $sql = "SELECT * FROM usuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $consulta = $db->query($sql);
        if ($consulta->rowCount() > 0) {
            $respuesta->setResponse(true);
            $respuesta->result = $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            $respuesta->message = "No existe ningún usuario.";
        }
        //cierro conexiones
        $consulta = null;
        $db = null;
    } catch (PDOException $e) {
        $respuesta->message =  $e->getMessage();
    }

    return json_encode($respuesta);
});

//GET Consultar usuario
$app->get('/user/{id}', function (Request $request, Response $response) {

    $idUsuario =  $request->getAttribute('id');
    $respuesta = new Respuesta();
    $sql = "SELECT * FROM usuario where idUsuario = $idUsuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $consulta = $db->query($sql);
        if ($consulta->rowCount() > 0) {
            $respuesta->setResponse(true);
            $respuesta->result = $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            $respuesta->message = "No existe el usuario.";
        }
        //cierro conexiones
        $consulta = null;
        $db = null;
    } catch (PDOException $e) {
        $respuesta->message =  $e->getMessage();
    }

    return json_encode($respuesta);
});

//POST Agregar o modificar usuario
$app->get('/user/save', function (Request $request, Response $response) {

    $idUsuario = $request->getParam('idUsuario');
    $nombre = $request->getParam('nombre');
    $cedula = $request->getParam('cedula');
    $correo = $request->getParam('correo');
    $huellaDactilar = $request->getParam('huellaDactilar');
    $respuesta = new Respuesta();

    if (isset($idUsuario) && !empty($idUsuario)) {∫
        $sql = "UPDATE usuario 
            SET nombre = :nombre, 
                cedula = :cedula, 
                correo = :correo, 
                huellaDactilar = :huellaDactilar
            WHERE idUsuario = $idUsuario";

        try {
            $db = new db();
            $db = $db->conectar();
            $consulta = $db->prepare($sql);
            $respuesta->setResponse(true);

            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':cedula', $cedula);
            $consulta->bindParam(':correo', $correo);
            $consulta->bindParam(':huellaDactilar', $huellaDactilar);

            $consulta->execute();
            $respuesta->result = $consulta->fetchAll(PDO::FETCH_OBJ);

            //cierro conexiones
            $consulta = null;
            $db = null;
        } catch (PDOException $e) {
            $respuesta->message =  $e->getMessage();
        }
    }else{
        $sql = "INSERT INTO usuario (nombre, cedula, correo, huellaDactilar) VALUES
            (:nombre, :cedula, :correo, :huellaDactilar)";
        try {
            $db = new db();
            $db = $db->conectar();
            $consulta = $db->prepare($sql);

            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':cedula', $cedula);
            $consulta->bindParam(':correo', $correo);
            $consulta->bindParam(':huellaDactilar', $huellaDactilar);

            $consulta->execute();
            //cierro conexiones
            $consulta = null;
            $db = null;
        } catch (PDOException $e) {
            $respuesta->message =  $e->getMessage();
        }
    }

    return json_encode($respuesta);
});
//olddd
$app->post('/usuarios/nuevo', function (Request $request, Response $response) {

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
$app->put('/usuarios/modificar/{id}', function (Request $request, Response $response) {

    $idUsuario =  $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $cedula = $request->getParam('cedula');
    $correo = $request->getParam('correo');
    $huellaDactilar = $request->getParam('huellaDactilar');
    $sql = "UPDATE usuario 
            SET nombre = :nombre, 
                cedula = :cedula, 
                correo = :correo, 
                huellaDactilar = :huellaDactilar
            WHERE idUsuario = $idUsuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':cedula', $cedula);
        $resultado->bindParam(':correo', $correo);
        $resultado->bindParam(':huellaDactilar', $huellaDactilar);

        $resultado->execute();
        echo json_encode("Usuario modificado.");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//DELETE Eliminar usuario
$app->delete('/usuarios/delete/{id}', function (Request $request, Response $response) {

    $idUsuario =  $request->getAttribute('id');

    $sql = "DELETE FROM usuario WHERE idUsuario = $idUsuario";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':cedula', $cedula);
        $resultado->bindParam(':correo', $correo);
        $resultado->bindParam(':huellaDactilar', $huellaDactilar);

        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            echo json_encode("Usuario eliminado.");
        } else {
            echo json_encode("Usuario no encontrado.");
        }


        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});
