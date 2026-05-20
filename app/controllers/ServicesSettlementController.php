<?php

namespace app\controllers;

class ServicesSettlementController extends AppController
{

    public function createAction()
    {

        $this->setMeta('Vyúčtování služeb', 'Vytvořte nové vyúčtování služeb spojených s užíváním bytu.');
        $data = null;
        $reCaptcha = false;

        $this->set(compact('data', 'reCaptcha'));

    }


}