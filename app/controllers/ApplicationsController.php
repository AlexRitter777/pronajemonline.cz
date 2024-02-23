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
        $this->setMeta('Aplikace', 'Aplikace pro jednoduchou a rychlou přefakturaci poměrné části nákladů na služby a energii na základě skuteční spotřeby a skutečné dekly pronájmu', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline, vyúčtování spotřeby elektřiny ');
    }


    /**
     * Forms actions
     */

    //Vyúčtování služeb
    public function servicesformAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu ', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Zjednodušené vyúčtování služeb
    public function easyservicesformAction() {
        $this->setMeta('Vyúčtování služeb', 'Vyúčtování služeb spojených s užíváním bytu ', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Vyúčtování spotřeby elektřiny
    public function electroformAction() {
        $this->setMeta('Vyúčtování spotřeby elektřiny', 'Vyúčtování spotřeby elektřiny', 'pronajímatel, nájemník, vyúčtování energii,  pronájem, kalkulace, pronajemonline.cz, pronajemonline, vyúčtování spotřeby elektřiny');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));
    }

    //Vyúčtování kauce
    public function depositformAction() {
        $this->setMeta('Vyúčtování kauce', 'Vyúčtování kauce složené nájemníkem', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline, vyúčtování spotřeby elektřiny');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));


    }

    //Souhrnné vyúčtování
    public function totalformAction() {
        $this->setMeta('Souhrné vyúčtování', 'Souhrné vyúčtování', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline, vyúčtování spotřeby elektřiny');
        $this->layout = 'pronajemform';
        $data = null;

        $this->set(compact('data'));


    }

    //Univerzální vyúčtování
    public function universalformAction() {
        $this->setMeta('Univerzalní vyúčtování', 'Description', 'vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem, kalkulace, pronajemonline.cz, pronajemonline, vyúčtování spotřeby elektřiny');
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