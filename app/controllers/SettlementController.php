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

    public function index()
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

        $result = $this->$settlementEntity->getPaginatedRecords(
            perPage: 10,
        );

        $settlements = $result->records;
        $pagination = $result->pagination;

        $token = CSRF::createCsrfToken();

        $this->set(compact('settlements', 'settlementType', 'pagination',  'token', 'settlementTypes'));

    }

    public function create()
    {
        if(empty($_GET['form_type'])){
            redirect('/settlements/list');
        }

        $settlementType = SettlementType::tryFrom($_GET['form_type']);

        if($settlementType === null) {
            redirect('/settlements/list');
        }

        $this->setMeta($settlementType->label());


        $settlementFormPath = '/' . $settlementType->form() . '.php';

        $this->set(compact('settlementFormPath'));


    }


    public function storeAction(){

    }


    public function editAction(){


    }

    public function updateAction(){

    }

    public function showAction(){

    }

    public function destroyAction(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/settlements');
        }

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/settlements');
        }

        if(empty($_POST['settlement'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/settlements');
        }

        [$settlementType, $settlementId] = explode(':', $_POST['settlement']);

        $userId = $_SESSION['user_id'];

        $settlementTypeEnum = SettlementType::tryFrom($settlementType);

        if($settlementTypeEnum === null){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/settlements');
        }

        $settlementEntity = $settlementTypeEnum->entity();

        $recordDeleted = $this->$settlementEntity->deleteOneRecordbyIdAndUserId($settlementId, $userId);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/settlements?calc_type=' . $settlementTypeEnum->value);
        } else {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

    }


}