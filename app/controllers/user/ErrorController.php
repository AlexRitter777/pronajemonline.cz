<?php

namespace app\controllers\user;

use app\controllers\AppController;

class ErrorController extends AppController {

    public function indexAction()
    {

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Chyba', 'Vyskytla se chyba');

        $this->layout = 'account';


    }
}