<?php

require '../vendor/autoload.php';

$app = new \Slim\App;

//Load application
require '../app/app_loader.php';

$app->run();
