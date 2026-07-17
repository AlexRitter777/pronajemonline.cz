<?php

namespace app\controllers;

class NewSettlementController extends AppController
{

    public function index()
    {

        $this->setMeta('Nové vyúčtováíní', 'Vyberte jeden z dostupných typů vyúčtování.');

    }
}