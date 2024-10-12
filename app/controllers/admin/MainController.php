<?php

namespace app\controllers\admin;

use app\controllers\AppController;

class MainController extends  AppController
{

    public function __construct($route)
    {

        parent::__construct($route);

        $this->layout = 'admin';

        if(!is_admin()){
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

    }


    public function indexAction(){





    }


}