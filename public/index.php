<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

//Ruta login
require '../src/routes/autenticacion.php';

//Ruta clientes
require '../src/routes/usuarios.php';

// //Ruta productos
// require '../src/routes/productos.php';

// //Ruta compras
// require '../src/routes/compras.php';

$app->run();
