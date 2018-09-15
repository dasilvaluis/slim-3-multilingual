# Slim 3 Multilingual

Extension to the [Slim](http://www.slimframework.com/) framework v3 to enable language based routing, i.e. i18n and l10n.

## Dependencies

* [Slim/Slim](https://github.com/slimphp/Slim) (v3)

## Installation

By terminal:

```shell

    composer require luism-s/multilingualslim

```

By editing composer.json

```json

    {
        "require": {
            "luism-s/multilingualslim": "~1.1.2"
        }
    }
    
```

## Usage

The `$container` is used as an interface between the Middleware and the Routes. 
The multilinguage middleware injects the following variables into the `$container`: `default_language`, `available_languages` and `language`. 
The first two are variables set by the developer, and the last is set by the middleware itself and indicates the requested language. 

```php

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require '../vendor/autoload.php';

    $default_language = 'pt';
    $available_languages = ['pt', 'en'];

    $app = new \Slim\App();
    $container = $app->getContainer();

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

    $app->run();
    
```

You can also use a library to render templates such as php-view. For example:

```php

    $container['renderer'] = new \Slim\Views\PhpRenderer("../views/");

    $app->get('/home', function (Request $request, Response $response) {
            //This works with '/home', '/pt/home' and '/en/home', 
            //and returns the template views/base.php.
            //It also passes the chosen language as an argument accessible from the chosen template.
            return $this->renderer->render($response, "base.php", [
                "language" => $this->language
            ]);
    });

```

## Acknowledgements 

This project is largely influenced by [SimoTod/slim-multilanguage](https://github.com/SimoTod/slim-multilanguage), which follows the same philosophy but is made for the version 2 of Slim.

## TODO

Develop functions to do things such as testing for default language, get current language, compare language, and maybe more.