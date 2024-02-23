<?php

namespace app\controllers;

use app\models\Cron;
use app\models\SendMessage;
use DateTime;
use RedBeanPHP\R;

class CronController extends AppController
{


    /**
     * Sends reminder emails for contracts finishing within a specified interval.
     *
     * @throws \Exception
     */
    public function contractfinishAction(){

    $cron = new Cron();
    $cron->sendContractFinishRemind(3, 'months');
    $cron->sendContractFinishRemind(2, 'months');


    die();

    }


}