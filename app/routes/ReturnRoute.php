<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/returns/', function () {

  $this->get('test', function (Request $request, Response $response) {
    return $response->getBody()
      ->write('Hello returns');
  });

  $this->get('getAll', function (Request $request, Response $response) {
    $obj = new ReturnModel();

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
    $obj = new ReturnModel();

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
    $obj = new ReturnModel();

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
    $obj = new ReturnModel();

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

  $this->post('sendMail', function (Request $request, Response $response) {
    $obj = new ReturnModel();

    return $response
      ->withHeader('Content-type', 'application/json')
      ->getBody()
      ->write(
        json_encode(
          $obj->sendMail(
            $request->getParsedBody()
          )
        )
      );
  });
  
});
