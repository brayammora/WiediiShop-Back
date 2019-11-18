<?php

require '../vendor/autoload.php';

$app = new \Slim\App;

//Set timezone
date_default_timezone_set('America/Bogota');

//Load application
require '../app/app_loader.php';

$app->run();
