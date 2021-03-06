<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/product/', function () {

  $this->get('test', function (Request $request, Response $response) {
    return $response->getBody()
      ->write('Hello Products');
  });

  $this->get('getAll', function (Request $request, Response $response) {
    $obj = new ProductModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->GetAll()
        )
      );
  });

  $this->get('get/{id}', function (Request $request, Response $response) {
    $obj = new ProductModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->Get(
            $request->getAttribute('id')
          )
        )
      );
  });

  $this->post('save', function (Request $request, Response $response) {
    $obj = new ProductModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->InsertOrUpdate(
            $request->getParsedBody()
          )
        )
      );
  });

  $this->delete('delete/{id}', function (Request $request, Response $response) {
    $obj = new ProductModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->Delete(
            $request->getAttribute('id')
          )
        )
      );
  });

  $this->get('getByBarcode/{id}', function (Request $request, Response $response) {
    $obj = new ProductModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->GetByBarcode(
            $request->getAttribute('id')
          )
        )
      );
  });

});
