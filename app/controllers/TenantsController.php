<?php

namespace app\controllers;

use app\actions\Tenant\CreateTenantAction;
use app\actions\Tenant\DestroyTenantAction;
use app\actions\Tenant\UpdateTenantAction;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotCreatedException;
use app\Exceptions\RecordNotUpdatedException;
use app\Factories\TenantDataFactory;
use app\Models\Tenant;
use app\Support\Account;
use app\validation\Core\ErrorBag;
use app\validation\Validators\TenantValidator;
use DI\Attribute\Inject;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;

class TenantsController extends AppController
{

    #[Inject]
    private Account $accountModel;

    #[Inject]
    private Tenant $tenant;

    #[Inject]
    private TenantValidator $validator;

    #[Inject]
    private ErrorBag $errorBag;

    #[Inject]
    private TenantDataFactory $tenantDataFactory;

    #[Inject]
    private CreateTenantAction $createTenantAction;

    #[Inject]
    private UpdateTenantAction $updateTenantAction;

    #[Inject]
    private DestroyTenantAction $destroyTenantAction;


    public function index()
    {


        $userID = $_SESSION['user_id'];

        $this->setMeta('Nájemníci', 'Seznam nájemníků');

        $result = $this->tenant->getPaginatedRecords(10, null, [], $userID);

        $tenants = $result->records;

        $pagination = $result->pagination;

        $tenantProp = $this->accountModel->personProps('tenant');

        $token = CSRF::createCsrfToken();

        $accountModel = $this->accountModel;

        $this->set(compact('tenants', 'tenantProp', 'pagination', 'accountModel', 'token'));

    }


    public function show(int $tenantId)
    {

        $userID = $_SESSION['user_id'];


        $tenant = $this->tenant->getOneRecordById($tenantId, $userID);

        if (!$tenant) {
            flash('error', 'Nepodařilo se najít nájemníka', 'error');
            redirect();
        }

        $propertyList = $this->accountModel->propertyList($tenant->id, 'tenant');

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($tenant->name, 'Profil nájemníka');

        $this->set(compact('tenant', 'propertyList', 'tokenInput'));

    }

    public function create()
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $tokenInput = CSRF::createCsrfInput();
        $this->setMeta('Nový nájemník', 'Vytvoření nového nájemníka');
        $this->set(compact('reCaptcha', 'tokenInput', 'errors', 'old'));
    }


    /**
     * @throws RecordNotCreatedException
     */
    public function store()
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');
        $data = $this->validator->validate(sanitize($_POST));
        $userID = $_SESSION['user_id'];
        $tenantDto = $this->tenantDataFactory->createFromArray($data);
        $tenantId = $this->createTenantAction->execute($tenantDto, $userID);
        flash('success', 'Nájemník byl úspěšně vytvořen.', 'success');
        redirect("/tenants/{$tenantId}");

    }


    public function edit(int $tenantId)
    {

        [$errors, $old] = $this->errorBag->getErrors();
        $userID = $_SESSION['user_id'];


        $tenant = $this->tenant->getOneRecordById($tenantId, $userID);

        if (!$tenant) {
            flash('error', 'Nepodařilo se najít nájemníka!', 'error');
            redirect();
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($tenant->name . ' - editace', 'Úprava nájemníka');
        $this->set(compact('tokenInput', 'tenant', 'errors', 'old'));

    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function update(int $tenantId)
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');

        $userID = $_SESSION['user_id'];

        $data = $this->validator->validate(sanitize($_POST));

        $tenantDto = $this->tenantDataFactory->createFromArray($data);

        try {
            $tenantId = $this->updateTenantAction->execute($tenantDto, $tenantId, $userID);
            flash('success', 'Nájemník byl úspěšně upraven.', 'success');
            redirect("/tenants/{$tenantId}");
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect('/tenants');
        }

    }


    public function destroy()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }
        checkCsrfOrRedirect($_POST['token'] ?? '');


        if (empty($_POST['tenant'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/tenants');
        }

        $tenantId = $_POST['tenant'];

        $userID = $_SESSION['user_id'];

        try {
            $this->destroyTenantAction->execute($this->tenant, $tenantId, $userID);
            flash('success', 'Nájemník byl úspěšně smazán.', 'success');
            redirect('/tenants');
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect();
        }


    }


}