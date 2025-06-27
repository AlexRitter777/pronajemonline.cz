<?php

define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("CONF", ROOT . '/config');
define("DEBUG", 1);
define("APP", ROOT . '/app');
define("SMTP", 0);

// Includes the Composer autoloader.
require_once ROOT . '/vendor/autoload.php';

//use classes
use app\models\Cron;
use pronajem\ErrorHandler;
use RedBeanPHP\R;

//Run error handler
new ErrorHandler();

//Create DB connection
if(!R::testConnection()) {
    $db = require_once CONF . '/config_db.php';
    R::setup($db['dsn'], $db['user'], $db['pass']);
    if (!R::testConnection()) {
        throw new \Exception('No database connection', 500);
    }
}
//start cron function
contractFinishCron();



/**
* Sends reminder emails for contracts finishing within a specified interval.
*
*/

function contractFinishCron(){

$cron = new Cron();
$cron->sendContractFinishRemind(90, 'days');
$cron->sendContractFinishRemind(60, 'days');
die();


}

