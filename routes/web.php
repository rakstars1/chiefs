<?php
use Slim\App;
use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function(App $app){
    //get all items


    //test
    $app->get('/', function(Request $request, Response $response){
        $response->getBody()->write("working");
        return $response;
    });


    //test 2

    $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    //test blade from laravel
    function view(Response $response, $template, $with =[]){
        $cache = __DIR__ . '/../cache';
        $views = __DIR__ . '/../app/views';

        $blade = (new Blade($views, $cache))->make($template,$with);

        $response->getBody()->write($blade->render());

        return $response;
    }
    $app->get('/html', function(Request $request, Response $response, $param){
        return view($response,'auth.home');
    });
};