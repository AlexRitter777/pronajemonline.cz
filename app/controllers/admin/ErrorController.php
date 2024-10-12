<?php

namespace app\controllers\admin;

use app\controllers\AppController;

class ErrorController extends AppController
{

    public function indexAction(){
        $this->layout = 'admin';

        if(!is_admin()){
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

        if(!isset($_SESSION['admin_error'])){
            redirect('/admin');
        }

        $error = $_SESSION['admin_error'];
        unset($_SESSION['admin_error']);

        $this->setMeta('Chyba', 'Vyskytla se chyba');
        $this->set(compact('error'));


    }

}