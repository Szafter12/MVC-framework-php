<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\controllers\SiteController;

$siteController = new SiteController();

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/contact', [$siteController, 'contact']);

$app->router->post('/contact', [$siteController, 'handleForm']);

$app->run();
