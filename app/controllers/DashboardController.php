<?php

namespace app\controllers;

use app\Support\Account;
use pronajem\base\Controller;
use RedBeanPHP\R;

class DashboardController extends Controller
{

    public function index()
    {
        $this->setMeta('Můj účet', 'My account');

        $userID = $_SESSION['user_id'];

        $accountModel = new Account();

        //Get five last changed calculations from each table . Returns NULL when there are no calculations

        $calcTypes = [
            'Vyúčtování služeb spojených s užíváním nemovitostí' => 'servicescalc',
            'Zjednodušené vyúčtování služeb spojených s užíváním nemovitostí' => 'easyservicescalc',
            'Vyúčtování spotřeby elektřiny' => 'electrocalc',
            'Vyúčtování kauce složené nájemníkem' => 'depositcalc',
            'Souhrnné vyúčtování' => 'totalcalc',
            'Univerzalní vyúčtování' => 'universalcalc',
        ];

        $calculations = $accountModel->createCalculationsBatch($calcTypes, $userID);

        //Count records from all tables
        $count = [];
        $count['landlord'] = R::count('landlord', "user_id=?", [$userID]);
        $count['tenant'] = R::count('tenant', "user_id=?", [$userID]);
        $count['property'] = R::count('property', "user_id=?", [$userID]);
        $count['admin'] = R::count('admin', "user_id=?", [$userID]);
        $count['elsupplier'] = R::count('elsupplier', "user_id=?", [$userID]);


        $this->set(compact('calculations', 'calcTypes', 'count'));
    }

}