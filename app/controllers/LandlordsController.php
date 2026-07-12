<?php

namespace app\controllers;

use app\actions\Landlord\CreateLandlordAction;
use app\actions\Landlord\DestroyLandlordAction;
use app\actions\Landlord\UpdateLandlordAction;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotCreatedException;
use app\Factories\LandlordDataFactory;
use app\Models\Landlord;
use app\Support\Account;
use app\validation\Core\ErrorBag;
use app\validation\Validators\LandlordValidator;
use DI\Attribute\Inject;
use Exception;
use pronajem\base\Controller;
use pronajem\libs\CSRF;
use RedBeanPHP\RedException\SQL;

class LandlordsController extends Controller {


    #[Inject]
    private Account $accountModel;

    #[Inject]
    private Landlord $landlord;

    #[Inject]
    private ErrorBag $errorBag;

    #[Inject]
    private LandlordValidator $validator;

    #[Inject]
    private LandlordDataFactory $landlordDataFactory;

    #[Inject]
    private CreateLandlordAction $createLandlordAction;

    #[Inject]
    private UpdateLandlordAction $updateLandlordAction;

    #[Inject]
    private DestroyLandlordAction $destroyLandlordAction;


    // List of landlords
    public function index(){

        $userID = $_SESSION['user_id'];

        $this->setMeta('Pronajímatele', 'Seznam pronajímatelů');

        $result = $this->landlord->getPaginatedRecords(10, null, [], $userID);

        $landlords = $result->records;

        $pagination = $result->pagination;

        $landlordProp = $this->accountModel->personProps('landlord');

        $accountModel = $this->accountModel;

        $token = CSRF::createCsrfToken();

        $this->set(compact('landlords', 'landlordProp', 'pagination', 'accountModel', 'token'));

    }

    public function show(int $landlordId){

        $userID = $_SESSION['user_id'];

        $landlord = $this->landlord->getOneRecordById($landlordId, $userID);

        if(!$landlord) {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }


        $propertyList = $this->accountModel->propertyList($landlord->id, 'landlord');

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($landlord->name, 'Profil pronajímatele');
        $this->set(compact('landlord', 'propertyList', 'tokenInput'));


    }


    // New landlord form
    public function create(){
        [$errors, $old] = $this->errorBag->getErrors();
        $tokenInput = CSRF::createCsrfInput();
        $this->setMeta('Nový pronajímatel', 'Vytvoření nového pronajímatele');
        $this->set(compact( 'tokenInput', 'errors', 'old'));

    }

    // Save new landlord
    /**
     * @throws RecordNotCreatedException
     */
    public function store()
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');
        $data = $this->validator->validate(sanitize($_POST));
        $userID = $_SESSION['user_id'];
        $landlordDto = $this->landlordDataFactory->createFromArray($data);
        $landlordId = $this->createLandlordAction->execute($landlordDto, $userID);
        flash('success', 'Pronajímatel byl úspěšně vytvořen.', 'success');
        redirect("landlords/show/{$landlordId}");
    }

    // Edit landlord profile
    public function edit(int $landlordId){

        [$errors, $old] = $this->errorBag->getErrors();

        $userID = $_SESSION['user_id'];

        $landlord = $this->landlord->getOneRecordById($landlordId, $userID);

        if(!$landlord) {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->set(compact('landlord', 'tokenInput', 'errors', 'old'));

        $this->setMeta($landlord->name . ' - editace', 'Profil pronajímatele');

    }

    // Save edited landlord profile
    /**
     * @throws SQL
     * @throws Exception
     */
    public function update(int $landlordId)
    {

        checkCsrfOrRedirect($_POST['token'] ?? '');


        $userID = $_SESSION['user_id'];

        $data = $this->validator->validate(sanitize($_POST));

        $landlordDto = $this->landlordDataFactory->createFromArray($data);

        try {
            $landlordId = $this->updateLandlordAction->execute($landlordDto, $landlordId, $userID);
            flash('success', 'Pronájímatel byl úspěšně upraven.', 'success');
            redirect("/landlords/{$landlordId}");
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect('/landlords');
        }

    }

    // Delete landlord
    public function destroy(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/landlords');
        }

        checkCsrfOrRedirect($_POST['token'] ?? '');

        if(empty($_POST['landlord'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/landlords');
        }

        $userId = $_SESSION['user_id'];

        $landlordID = $_POST['landlord'];

        try {
            $this->destroyLandlordAction->execute($this->landlord, $landlordID , $userId);
            flash('success', 'Pronájímatel byl úspěšně smazán.', 'success');
            redirect('/landlords');
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect();
        }

    }


}