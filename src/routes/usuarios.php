<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//GET Listar todos los usuarios
$app->get('/usuarios', function (Request $request, Response $response) {
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
        echo '{"error" : "text": ' . $e->getMessage() . '}';
    }
});

//GET Consultar usuario
$app->get('/usuarios/{id}', function (Request $request, Response $response) {
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

        if ($resultado->rowCount() > 0){
            echo json_encode("Usuario eliminado.");
        }else{
            echo json_encode("Usuario no encontrado.");
        }
        

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});