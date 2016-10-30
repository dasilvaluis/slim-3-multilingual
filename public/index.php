<?php

use \Slim\App;
use \Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$available_languages = ['pt', 'en'];
$default_language = $available_languages[0];

$app = new App();
$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("../views/", array("language" => $default_language));

$app->add( new \MultilingualSlim\LanguageMiddleware($available_languages, $default_language, $container) );

$app->get('/', function (Request $request, Response $response) {

		return $this->renderer->render($response, "base.php", [
			"language" => $this->language
		]);
});

$app->run();