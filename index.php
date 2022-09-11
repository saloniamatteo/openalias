<?php
require_once('./vendor/autoload.php');
require_once('includes/Routes.class.php');
require_once('includes/Redis.class.php');

$app = new \Slim\Slim();

/* Uncomment this line if you DON'T want to use Redis */
//$Routes = new Routes($app);

/* Uncomment these lines if you want to use Redis */
$Redis = new Redis();
$Routes = new Routes($app, $Redis);

/* Set logging options for debugging, comment if using in production */
//$app->log->setEnabled(true);
//$app->log->setLevel(\Slim\Log::DEBUG);

/* Route to check for the domain TXT records */
$app->get('/:domain', function($domain) use($Routes) {
    $Routes->domainCheck($domain);
});

/* Route for the web form */
$app->get('/', function () use ($Routes) {
    $Routes->index();
});

$app->run();
