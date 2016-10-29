<?php

use \Slim\App;
use \Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';

$possible_languages = ['pt', 'en'];
$language = ["lang" => $possible_languages[0]];

$app = new App();
$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("../views/", $language);
$container['possible_languages'] = $possible_languages;

$app->get('/', function (Request $request, Response $response) {
	return $this->renderer->render($response, "base.php");
});
$app->get('[/{lang}]', function (Request $request, Response $response){
	$lang = $request->getAttribute('lang');

	if (in_array($lang, $this->possible_languages, true)) {
		$response = $this->renderer->render($response, "base.php", [
			"lang" => $lang
		]);
	} else {
		$response = $this->renderer->render($response, "404.php");
	}
	return $response;
});

$app->run();