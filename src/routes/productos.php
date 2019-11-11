<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//GET Listar todos los productos
$app->get('/productos', function (Request $request, Response $response) {
    $sql = "SELECT * FROM producto";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $productos = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($productos);
        } else {
            echo json_encode("No existen ningun producto.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//GET Consultar producto
$app->get('/productos/{id}', function (Request $request, Response $response) {
    $idProducto =  $request->getAttribute('id');
    $sql = "SELECT * FROM producto where idProducto = $idProducto";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $productos = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($productos);
        } else {
            echo json_encode("No existe el producto.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//POST Agregar producto
$app->post('/productos/nuevo', function (Request $request, Response $response) {

    $nombre = $request->getParam('nombre');
    $precio = $request->getParam('precio');
    $codigoBarras = $request->getParam('codigoBarras');
    $sql = "INSERT INTO producto (nombre, precio, codigoBarras) VALUES
            (:nombre, :precio, :codigoBarras)";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':precio', $precio);
        $resultado->bindParam(':codigoBarras', $codigoBarras);

        $resultado->execute();
        echo json_encode("Nuevo producto guardado.");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//PUT Modificar producto
$app->put('/productos/modificar/{id}', function (Request $request, Response $response) {

    $idProducto =  $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $precio = $request->getParam('precio');
    $codigoBarras = $request->getParam('codigoBarras');
    $sql = "UPDATE producto 
            SET nombre = :nombre, 
                precio = :precio, 
                codigoBarras = :codigoBarras
            WHERE idProducto = $idProducto";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':precio', $precio);
        $resultado->bindParam(':codigoBarras', $codigoBarras);

        $resultado->execute();
        echo json_encode("Producto modificado.");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});

//DELETE Eliminar producto
$app->delete('/productos/delete/{id}', function (Request $request, Response $response) {

    $idProducto =  $request->getAttribute('id');

    $sql = "DELETE FROM producto WHERE idProducto = $idProducto";
    try {
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':precio', $precio);
        $resultado->bindParam(':codigoBarras', $codigoBarras);

        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            echo json_encode("Producto eliminado.");
        } else {
            echo json_encode("Producto no encontrado.");
        }


        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text": ' . $e->getMessage() . '}';
    }
});
