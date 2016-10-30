# Multilingual Slim

Extension to the [Slim](http://www.slimframework.com/) framework v3 to enable language routing.

## Dependencies

* [Slim/Slim](https://github.com/slimphp/Slim) (v3)
* [Slim/PHP-View](https://github.com/slimphp/PHP-View)

## Usage

The `$container` is used as a mean to serve as a interface between the Middleware and the Routes. 
The multilinguage middleware injects the following variables into the `$container`: `default_language`, `available_languages` and `language`. 
The first two are variables set by the developer, and the last is set by the middleware and indicates the requested language. 

```php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$available_languages = ['pt', 'en'];
$default_language = $available_languages[0];

$app = new \Slim\App();
$container = $app->getContainer();
$container['renderer'] = new \Slim\Views\PhpRenderer("../views/", array("language" => $default_language));

$app->add( new \MultilingualSlim\LanguageMiddleware($available_languages, $default_language, $container) );

$app->get('/', function (Request $request, Response $response) {
    //This works with '/', '/pt' and '/en', and 
    //and returns the template views/base.php
    return $this->renderer->render($response, "base.php", [
        "language" => $this->language
    ]);
});

$app->get('/hello', function (Request $request, Response $response) {
    //This works with '/hello', '/pt/hello' and '/en/hello',
    //and prints 'Hello' in each languages
    if ($this->language === $this->default_language  || $this->language === 'pt') {
        return $response->write("Olá");
    } else {
        return $response->write("Hello");
    }
});

$app->run();
```


## Acknowledgements 

This project is largely inspired by [SimoTod/slim-multilanguage](https://github.com/SimoTod/slim-multilanguage), which is made for the version 2 of Slim.

## TODO

Develop functions to do things such as testing for default language, get current language, compare language, and maybe more.