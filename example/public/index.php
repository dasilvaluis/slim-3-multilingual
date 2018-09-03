<?php

use \Slim\App;
use \Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$default_language = 'pt';
$available_languages = ['pt', 'es', 'en', 'fr', 'de'];

$app = new App();
$container = $app->getContainer();

$app->add( new \MultilingualSlim\LanguageMiddleware($available_languages, $default_language, $container) );

$app->get('/', function (Request $request, Response $response) {

        $output =   '<nav>
                        <ul>
                            <li><a href="/">PT</a></li>
                            <li><a href="/es">ES</a></li>
                            <li><a href="/en">EN</a></li>
                            <li><a href="/fr">FR</a></li>
                            <li><a href="/de">DE</a></li>
                        </ul>
                    </nav>';

        //This works with '/', '/pt' and '/en',
        //and prints 'Hello' in each language.
        if ( $this->language === 'pt' ) {
            $output .= "<p>Olá Mundo!</p>";
        } elseif ( $this->language === 'en' ) {
            $output .= "<p>Hello World!</p>";
        } elseif ( $this->language === 'es' ) {
            $output .= "<p>Hola Mundo!</p>";
        } elseif ( $this->language === 'fr' ) {
            $output .= "<p>Bonjour le Monde!</p>";
        } elseif ( $this->language === 'de' ) {
            $output .= "<p>Hallo Welt!</p>";
        }

        return $response->write($output);
});

$app->run();