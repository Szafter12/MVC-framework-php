<?php

use app\core\Application;
use app\core\Router;

$app = new Application();

$app->router->get('/', function () {
    echo "Hello world";
});

$app->run();
