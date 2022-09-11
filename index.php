<?php
require_once('./vendor/autoload.php');
require_once('includes/Routes.class.php');
require_once('includes/Redis.class.php');

$app = new \Slim\Slim();
$Redis = new Redis();
//$Routes = new Routes($app);

//Just don't add anything as the second param
//if you don't want to track with Redis
$Routes = new Routes($app, $Redis);

//set logging for debugging
//comment out if using in production
$app->log->setEnabled(true);
$app->log->setLevel(\Slim\Log::DEBUG);

//This is the route to check for the domain TXT records
$app->get('/:domain', function($domain) use($Routes) {
    $Routes->domainCheck($domain);
});

//This is the route for the plain ol' web form
$app->get('/', function () use ($Routes) {
    $Routes->index();
});

$app->run();

