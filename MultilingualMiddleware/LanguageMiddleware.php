<?php

namespace MultilingualSlim;

use MultilingualSlim\Language;

class LanguageMiddleware {

    protected $container;

    public function __construct($available_languages, $default_language, $container) {
        if(!is_array($available_languages)) 
            $available_languages = array($available_languages);

        $this->container = $container;
        $this->container['default_language'] = $default_language;
        $this->container['available_languages'] = $available_languages;
        $this->container['language'] = $default_language;
   }

   /**
     * RestrictRoute middleware invokable class.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        //Split path into chunks
        $pathChunks = explode("/", $path); 

        //Check for language references
        if(count($pathChunks) > 1 && in_array($pathChunks[1], $this->container['available_languages'])) {
            
            //Set current language
            $this->container['language'] = $pathChunks[1];  
            
            //Produce new URI without language reference 
            unset($pathChunks[1]); 
            $newPath = implode('/', $pathChunks);
            $newUri = $uri->withPath($newPath);

            return $next($request->withUri($newUri), $response); 
        }

        return $next($request, $response);
    }
}