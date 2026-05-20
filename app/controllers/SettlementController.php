<?php

namespace app\controllers;

use app\Enum\SettlementType;
use app\Support\Account;
use app\Support\Services;
use pronajem\libs\CSRF;
use pronajem\libs\Pagination;
use RedBeanPHP\R;

class SettlementController extends AppController
{

    public function indexAction()
    {
        $this->setMeta('Vyúčtování', 'Seznam uložených vyúčtování');


        $userID = $_SESSION['user_id'];

        //set default calculation type
        $calcType = 'servicescalc';

        $calcMap = [
            'servicescalc' => 'servicesform',
            'easyservicescalc' => 'easyservicesform',
            'electrocalc' => 'electroform',
            'depositcalc' => 'depositform',
            'totalcalc' => 'totalform',
            'universalcalc' => 'universalform'
        ];

        $settlementTypes = SettlementType::options();


        //set default order by
        $order = 'ORDER BY created_at DESC';

        //Get order by from GET
        if(isset($_GET['ordered'])){
            switch ($_GET['ordered']){
                case 'upd-up':
                    $order = 'ORDER BY updated_at ASC';
                    break;
                case 'upd-down':
                    $order = 'ORDER BY updated_at DESC';
                    break;
                case 'crt-up':
                    $order = 'ORDER BY created_at ASC';
                    break;
                case 'crt-down':
                    $order = 'ORDER BY created_at DESC';
            }
        }


        //Get calculation type from $_GET
        if(isset($_GET['calc_type'])) {
            if(array_key_exists($_GET['calc_type'], Services::$calculationList)) {
                $calcType = $_GET['calc_type'];
            }
        }

        $formType = $calcMap[$calcType];

        //variables for SQL conditions
        $condition = '';
        $params = [];

        //create Account model
        $accountModel = new Account();

        //create SQL conditions for filter
        if($_GET) {
            $filterCond = $accountModel->filterQueryMaker($_GET, $calcType);
            $condition = $filterCond[0];
            $params = $filterCond[1];
        }
        array_unshift($params, $userID);

        //implement pagination
        $total = R::count($calcType, "user_id=? $condition", $params);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();


        //get calculation, including order, pagination and filter
        $calculations = R::findAll($calcType, "user_id=? $condition $order LIMIT $start, $perpage", $params);

        $calcURL = substr($calcType, 0, -4);
        $calcTypeValue = Services::getCalcValue($calcType);

        $token = CSRF::createCsrfToken();

        $this->set(compact('calculations', 'calcType', 'formType', 'calcTypeValue', 'calcURL', 'pagination', 'total', 'accountModel', 'token', 'settlementTypes'));

    }


}