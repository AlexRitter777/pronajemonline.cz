<?php

namespace app\controllers\User;

use app\controllers\AppController;

class ServicesformController extends AppController
{

    public function createAction()
    {

        $this->setMeta('Vyúčtování služeb', 'Vytvořte nové vyúčtování služeb spojených s užíváním bytu.');
        $this->layout = 'account';
        $data = null;
        $reCaptcha = false;

        $this->set(compact('data', 'reCaptcha'));

    }


    public function editAction()
    {

        $this->setMeta('Vyúčtování služeb', 'Vytvořte nové vyúčtování služeb spojených s užíváním bytu.');

        $data = null;
        $this->layout = 'account';

        if(isset($_SESSION['servicesResult'][$_GET['id']])) {
            $data = $_SESSION['servicesResult'][$_GET['id']];
//            unset($_SESSION['servicesResult'][$_GET['id']]);// ??? keep data???
        }
        // clean session after calculation not here!!!

        $reCaptcha = false;

        $this->set(compact('data', 'reCaptcha'));

    }



}



