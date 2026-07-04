<?php

namespace app\controllers;

class NewSettlementController extends AppController
{

    public function indexAction()
    {

        $this->setMeta('Nové vyúčtováíní', 'Vyberte jeden z dostupných typů vyúčtování.');

    }
}