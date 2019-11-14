<?php

require '../vendor/autoload.php';

$app = new \Slim\App;

//Cargar aplicacion
require '../app/app_loader.php';

$app->run();
