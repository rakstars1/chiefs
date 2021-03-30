<?php
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require  __DIR__ . '/../vendor/autoload.php';
require '../db/db.php';

// Create Container
$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function() {
    return Twig::create(__DIR__ . '/../templates', ['cache'], '/../cache');
});

// Create App
$app = AppFactory::create();

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));


// Routes

$app->get('/api/items', function(Request $request, Response $response){
    $sql = "SELECT * FROM items";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $items = $stmt->fetchAll();
        $db = NULL;
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';

    }
    return $this->get('view')->render($response, 'index.twig', array('items' => $items));
});

// Run the app
$app->run();
?>