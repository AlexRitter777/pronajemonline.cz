<?php

namespace app\controllers;

use app\Enum\SettlementType;
use app\Enum\SortOrder;
use app\Models\Depositcalc;
use app\Models\Easyservicescalc;
use app\Models\Electrocalc;
use app\Models\Property;
use app\Models\Servicescalc;
use app\Models\Totalcalc;
use app\Models\Universalcalc;
use app\Support\Account;
use app\Support\Services;
use DI\Attribute\Inject;
use pronajem\libs\CSRF;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R;

class SettlementController extends AppController
{
    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private Servicescalc $servicesSettlement;

    #[Inject]
    private Easyservicescalc $simpleSettlement;

    #[Inject]
    private Electrocalc $electricitySettlement;

    #[Inject]
    private Universalcalc $universalSettlement;

    #[Inject]
    private Totalcalc $totalSettlement;

    #[Inject]
    private Depositcalc $depositSettlement;

    #[Inject]
    private Property $property;

    public function indexAction()
    {
        $this->setMeta('Vyúčtování', 'Seznam uložených vyúčtování');


        $userID = $_SESSION['user_id'];


        // Get available settlement types
        $settlementTypes = SettlementType::options();

        // Get the selected settlement type or default fallback
        $settlementTypeEnum = SettlementType::tryFrom($_GET['calc_type'] ?? 'servicescalc');
        $settlementEntity = $settlementTypeEnum->entity();
        $settlementType = $settlementTypeEnum;

        // Get the selected sort order or default fallback
        $sortOrder = SortOrder::tryFrom($_GET['ordered'] ?? 'crt-down')->sql();




        $settlements = $this->$settlementEntity->getAllRecordsWithPaginationAndConditions(
            perPage: 10,
            filters: [],
            userId: $userID,
            orderBy: $sortOrder
        );

//        dd($settlements);

//        dd($properties);


        //set default calculation type
//        $calcType = 'servicescalc';
//
//        $calcMap = [
//            'servicescalc' => 'servicesform',
//            'easyservicescalc' => 'easyservicesform',
//            'electrocalc' => 'electroform',
//            'depositcalc' => 'depositform',
//            'totalcalc' => 'totalform',
//            'universalcalc' => 'universalform'
//        ];







//        $order = 'ORDER BY created_at DESC';
//
//        //Get order by from GET
//        if(isset($_GET['ordered'])){
//            switch ($_GET['ordered']){
//                case 'upd-up':
//                    $order = 'ORDER BY updated_at ASC';
//                    break;
//                case 'upd-down':
//                    $order = 'ORDER BY updated_at DESC';
//                    break;
//                case 'crt-up':
//                    $order = 'ORDER BY created_at ASC';
//                    break;
//                case 'crt-down':
//                    $order = 'ORDER BY created_at DESC';
//            }
//        }
//
//
//
//        //Get calculation type from $_GET
//        if(isset($_GET['calc_type'])) {
//            if(array_key_exists($_GET['calc_type'], Services::$calculationList)) {
//                $calcType = $_GET['calc_type'];
//            }
//        }
//
//        $formType = $calcMap[$calcType];
//
//        //variables for SQL conditions
//        $condition = '';
//        $params = [];
//
//        //create Account model
//        $accountModel = new Account();
//
//        //create SQL conditions for filter
//        if($_GET) {
//            $filterCond = $accountModel->filterQueryMaker($_GET, $calcType);
//            $condition = $filterCond[0];
//            $params = $filterCond[1];
//        }
//        array_unshift($params, $userID);
//
//        //implement pagination
//        $total = R::count($calcType, "user_id=? $condition", $params);
//        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
//        $perpage = 10;
//        $pagination = new Pagination($page, $perpage, $total);
//        $start = $pagination->getStart();
//
//
//        //get calculation, including order, pagination and filter
//        //$calculations = R::findAll($calcType, "user_id=? $condition $order LIMIT $start, $perpage", $params);
//
//        $calcURL = substr($calcType, 0, -4);
//        $calcTypeValue = Services::getCalcValue($calcType);

        $pagination = $this->pagination;

        $token = CSRF::createCsrfToken();
        //$calculations = [];
        $this->set(compact('settlements', 'settlementType', 'pagination',  'token', 'settlementTypes'));

    }


}