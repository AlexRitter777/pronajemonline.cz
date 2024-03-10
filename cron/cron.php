<?php

//run init (define path constants, require autoloader)
require __DIR__ . '/../config/init.php';

//use classes
use app\models\Cron;
use pronajem\ErrorHandler;
use RedBeanPHP\R;

//Run error handler
new ErrorHandler();

//Create DB connection
$db = require_once CONF . '/config_db.php';
R::setup($db['dsn'], $db['user'], $db['pass']);
if( !R::testConnection()){
    throw new \Exception('No database connection', 500);
}

//start cron function
contractFinishCron();



/**
* Sends reminder emails for contracts finishing within a specified interval.
*
*/

function contractFinishCron(){

$cron = new Cron();
$cron->sendContractFinishRemind(3, 'months');
$cron->sendContractFinishRemind(2, 'months');
die();


}

