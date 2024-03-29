<?php

namespace app\controllers;

use app\models\Account;
use app\models\Applications;
use app\models\AppModel;
use Mpdf\Mpdf;

class ApplicationsController extends AppController {

    /**
     * List of applications - action
     */
    public function indexAction()
    {
        $this->setMeta('Aplikace pronajemonline.cz - Užitečné aplikace pro vyúčtování služeb nájemníkům', 'Vyberte si vhodnou aplikaci pro snadné vyúčtování služeb a energií nájemníkům. Proveďte vyúčtování kauce po skončení nájmu. Přihlášení uživatelé mohou ukládat a spravovat kalkulace, a také dostanou přístup k nástrojům pro správu nemovitostí a pronájmů.');
    }


    /**
     * Forms actions
     */

    //Vyúčtování služeb
    public function servicesformAction() {
        $this->setMeta('Vyúčtování služeb spojených s užíváním bytu | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online pravidelné vyúčtování služeb nájemníkům nebo vyúčtování služeb při skončení nájmu. Přehledné výstupy ve formátu PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Zjednodušené vyúčtování služeb
    public function easyservicesformAction() {
        $this->setMeta('Zjednodušené vyúčtování služeb spojených s užíváním bytu | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online pravidelné vyúčtování služeb nájemníkům za uplynulý rok. Přehledné výstupy ve formátу PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Vyúčtování spotřeby elektřiny
    public function electroformAction() {
        $this->setMeta('Vyúčtování spotřeby elektřiny | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online vyúčtování spotřeby elektřiny nájemníkům. Přehledné výstupy ve formátu PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Vyúčtování kauce
    public function depositformAction() {
        $this->setMeta('Vyúčtování kauce po skončení nájmu | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online vyúčtování kauce složené nájemníkem, zajišťující transparentní vracení kauce po skončení nájmu. Přehledné výstupy ve formátu PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));


    }

    //Souhrnné vyúčtování
    public function totalformAction() {
        $this->setMeta('Souhrnné vyúčtování služeb spojených s užíváním bytu | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online souhrnné vyúčtování služeb nájemníkům. Například, pomůže dát dohromady data z vyúčtování služeb spojených s užíváním bytu, vyúčtování spotřeby elektřiny a případných dalších vyúčtování. Přehledné výstupy ve formátu PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));


    }

    //Univerzální vyúčtování
    public function universalformAction() {
        $this->setMeta('Univerzální vyúčtování energií | pronajemonline.cz - Vyúčtování služeb nájemníkům', 'Tato aplikace umožňuje vyhotovit online vyúčtování spotřeby elektřiny, vodného, stočného nebo plynu nájemníkům. Přehledné výstupy ve formátu PDF. Ideální pro správu nemovitostí a pronájmů.');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));


    }

    /**
     * Edit forms actions
     */

    public function servicesformeditAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['servicesResult'][$_GET['id']])) {
            $data = $_SESSION['servicesResult'][$_GET['id']];
            unset($_SESSION['servicesResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }

    public function easyservicesformeditAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['easyservicesResult'][$_GET['id']])) {
            $data = $_SESSION['easyservicesResult'][$_GET['id']];
            unset($_SESSION['easyservicesResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }

    public function electroformeditAction() {
        $this->setMeta('Vyúčtování spotřeby elektřiny', 'Vyúčtování spotřeby elektřiny', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['electroResult'][$_GET['id']])) {
            $data = $_SESSION['electroResult'][$_GET['id']];
            unset($_SESSION['electroResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }

    public function depositformeditAction() {
        $this->setMeta('Vyúčtování kauce složené nájemníkem', 'Description', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['depositResult'][$_GET['id']])) {
            $data = $_SESSION['depositResult'][$_GET['id']];
            unset($_SESSION['depositResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }

    public function totalformeditAction() {
        $this->setMeta('Souhrné vyúčtování', 'Souhrné vyúčtování', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['totalResult'][$_GET['id']])) {
            $data = $_SESSION['totalResult'][$_GET['id']];
            unset($_SESSION['totalResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }

    public function universalformeditAction() {
        $this->setMeta('Univerzalní vyúčtování', 'Univerzalní vyúčtování', '');
        $this->layout = 'pronajemform';
        if(isset($_SESSION['universalResult'][$_GET['id']])) {
            $data = $_SESSION['universalResult'][$_GET['id']];
            unset($_SESSION['universalResult'][$_GET['id']]);
        } else {
            $data = null;
        }
        $this->set(compact('data'));
    }


    /**
     * Calculations actions
     */

    //Vyúčtování služeb
    public function servicescalcAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('services');
        $this->set(compact('result'));
    }


    //Zjednodušené vyúčtování služeb
    public function easyservicescalcAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('easyservices');
        $this->set(compact('result'));

    }

    //Vyúčtování spotřeby elektřiny
    public function electrocalcAction(){
        $this->setMeta('Vyúčtování spotřeby elektřiny', 'Vyúčtování spotřeby elektřiny', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('electro');
        $this->set(compact('result'));

    }


    //Vyúčtování kauce
    public function depositcalcAction(){
        $this->setMeta('Vyúčtování kauce složené nájemníkem', 'Vyúčtování spotřeby elektřiny', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('deposit');
        $this->set(compact('result'));
    }


    //Souhrnné vyúčtování
    public function totalcalcAction(){
        $this->setMeta('Souhrnné vyúčtování', 'Souhrnné vyúčtování', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('total');
        $this->set(compact('result'));
    }


    //Univerzální vyúčtování - not allowed for user
    public function universalcalcAction(){
        $this->setMeta('Univerzální vyúčtování', 'Univerzální vyúčtování', '');
        $this->layout = 'pronajemcalc';
        $result = $this->processCalculation('universal');
        $this->set(compact('result'));
    }






}