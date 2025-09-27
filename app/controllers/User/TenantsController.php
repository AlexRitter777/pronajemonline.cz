<?php

namespace app\controllers\User;

use app\actions\Tenant\CreateTenantAction;
use app\actions\Tenant\DestroyTenantAction;
use app\actions\Tenant\UpdateTenantAction;
use app\controllers\AppController;
use app\db_models\Tenant;
use app\exceptions\PersonNotFoundException;
use app\exceptions\RecordNotCreatedException;
use app\exceptions\RecordNotUpdatedException;
use app\factories\TenantDataFactory;
use app\models\Account;
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
    private PaginationSetParams $pagination;

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

    public function __construct($route)
    {

        parent::__construct($route);

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

    }


    public function indexAction()
    {


        $userID = $_SESSION['user_id'];

        $this->setMeta('Nájemníci', 'Seznam nájemníků');

        $tenants = $this->tenant->getAllRecordsWithPagination(8, $userID);

        $tenantProp = $this->accountModel->personProps('tenant');

        $pagination = $this->pagination;

        $token = CSRF::createCsrfToken();

        $accountModel = $this->accountModel;

        $this->set(compact('tenants', 'tenantProp', 'pagination', 'accountModel', 'token'));

    }


    public function showAction()
    {

        $userID = $_SESSION['user_id'];

        if (!isset($_GET['tenant_id'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }

        $tenant_id = $_GET['tenant_id'];

        $tenant = $this->tenant->getOneRecordById($tenant_id, $userID);

        if (!$tenant) {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

        $propertyList = $this->accountModel->propertyList($tenant->id, 'tenant');

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($tenant->name, 'Profil nájemníka');

        $this->set(compact('tenant', 'propertyList', 'tokenInput'));

    }

    public function createAction()
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $reCaptcha = true; //remove from ajax logic later
        $tokenInput = CSRF::createCsrfInput();
        $this->setMeta('Nový nájemník', 'Vytvoření nového nájemníka');
        $this->set(compact('reCaptcha', 'tokenInput', 'errors', 'old'));
    }


    /**
     * @throws RecordNotCreatedException
     */
    public function saveAction()
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');
        $data = $this->validator->validate(sanitize($_POST));
        $userID = $_SESSION['user_id'];
        $tenantDto = $this->tenantDataFactory->createFromArray($data);
        $tenantId = $this->createTenantAction->execute($tenantDto, $userID);
        flash('success', 'Nájemník byl úspěšně vytvořen.', 'success');
        redirect("/user/tenants/show?tenant_id={$tenantId}");

    }


    public function editAction()
    {

        [$errors, $old] = $this->errorBag->getErrors();
        $reCaptcha = true; //remove from ajax logic later
        $userID = $_SESSION['user_id'];

        if (!isset($_GET['tenant_id'])) {
            flash('error', 'Nepodarilo se najit nájenmíka.', 'error');
            redirect();
        }

        $tenantId = $_GET['tenant_id'];
        $tenant = $this->tenant->getOneRecordById($tenantId, $userID);

        if (!$tenant) {
            flash('error', 'Nepodařilo se najít nájemníka!', 'error');
            redirect();
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta('Úprava nájemníka', 'Úprava nájemníka');
        $this->set(compact('reCaptcha', 'tokenInput', 'tenant', 'errors', 'old'));

    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function updateAction()
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');

        if (!isset($_GET['tenant_id'])) {
            flash('error', 'Nepodarilo se najit nájemníka.', 'error');
            redirect();
        }

        $tenantId = $_GET['tenant_id'];

        $userID = $_SESSION['user_id'];

        $data = $this->validator->validate(sanitize($_POST));

        $tenantDto = $this->tenantDataFactory->createFromArray($data);

        try {
            $tenantId = $this->updateTenantAction->execute($tenantDto, $tenantId, $userID);
            flash('success', 'Nájemník byl úspěšně upraven.', 'success');
            redirect("/user/tenants/show?tenant_id={$tenantId}");
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect('/user/tenants');
        }

    }


    public function destroyAction()
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
            redirect('/user/tenants');
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect();
        }


    }


}