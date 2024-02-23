<?php

namespace app\controllers;
use pronajem\Cache;
use RedBeanPHP\R as R;

class MainController extends AppController

{

    public function indexAction(){

        $this->setMeta('Pronájem Online', 'Vyúčtování služeb spojených s užíváním bytu při pronájmu', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem');

    }





}