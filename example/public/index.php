<?php

use \Slim\App;
use \Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$default_language = 'pt';
$available_languages = ['pt', 'en'];

$app = new App();
$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("../views/");

$app->add( new \MultilingualSlim\LanguageMiddleware($available_languages, $default_language, $container) );

$app->get('/', function (Request $request, Response $response) {
        //This works with '/', '/pt' and '/en',
        //and prints 'Hello' in each language.
        if ($this->language === 'pt') {
            return $response->write("Olá Mundo");
        } elseif($this->language === 'en') {
            return $response->write("Hello World");
        }
});

$app->get('/home', function (Request $request, Response $response) {
        //This works with '/home', '/pt/home' and '/en/home', 
        //and returns the template views/base.php.
        //It also passes the chosen language as an argument accessible from the chosen template.
        return $this->renderer->render($response, "base.php", [
            "language" => $this->language
        ]);
});

$app->run();