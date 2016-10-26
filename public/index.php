<?php

use \Slim\App;
use \Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';

$app = new App();

$possible_langs = ['', 'pt', 'en'];
$default_lang = ["lang" => $possible_langs[1]];

$container = $app->getContainer();
$container['view'] = new PhpRenderer("../templates/", $default_lang);

$container['lang_regex']  = '#';
foreach ($possible_langs as $possible_lang) {
	$container['lang_regex'] .= '|^'.$possible_lang.'$';
}
$container['lang_regex'] .= '#';

$app->get('[/{lang:.*}]', function (Request $request, Response $response) use ($app) {
	$lang = $request->getAttribute('lang');

	if (preg_match($this->lang_regex, $lang)) {
		$response = $this->view->render($response, "base.php", [
			"lang" => $lang
		]);
	} else {
		$response = $this->view->render($response, "404.php");
	}
	return $response;
});

$app->run();