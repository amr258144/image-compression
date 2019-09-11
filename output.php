<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/config/config.php';
require_once 'app/Controllers/Builder.php';
// require_once 'app/Controllers/Url.php';
// use app\Controllers\Url;
use app\Controllers\Builder;
require_once 'app/Controllers/BuilderFactory.php';
use app\Controllers\BuilderFactory;

$server = SERVER;
$secret = SECRET_KEY;

/*echo Builder::construct($server, $secret, 'http://localhost/thumbor/uploads/strange.jpg')
    ->fitIn(640, 480)
    ->addFilter('fill', 'green');*/

/*echo BuilderFactory::construct($server, $secret)
    ->url('http://localhost/thumbor/uploads/strange.jpg')
    ->fitIn(640, 480)
    ->addFilter('fill', 'green')->addFilter('brightness',10);*/

echo $twig->render('test.html', ['image' => new Url('http://localhost:8888', 'secret-key-here', 'http://localhost/thumbor/uploads/strange.jpg', ["640x480/filters:blur(10):brightness(10)"])]);
?>
