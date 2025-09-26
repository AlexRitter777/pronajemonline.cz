<?php

namespace app\controllers\User;

use app\actions\Tenant\CreateTenantAction;
use app\controllers\AppController;
use app\db_models\Tenant;
use app\factories\TenantDataFactory;
use app\models\Account;
use app\validation\Core\ErrorBag;
use app\validation\Validators\TenantValidator;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class TenantsController extends AppController {


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

    public function __construct($route) {

        parent::__construct($route);

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

    }


    public function indexAction(){



        $userID = $_SESSION['user_id'];

        $this->setMeta('Nájemníci', 'Seznam nájemníků');

        $tenants = $this->tenant->getAllRecordsWithPagination(8, $userID);

        $tenantProp = $this->accountModel->personProps('tenant');

        $pagination = $this->pagination;

        $token = CSRF::createCsrfToken();

        $accountModel = $this->accountModel;

        $this->set(compact('tenants', 'tenantProp', 'pagination', 'accountModel', 'token'));

    }


    public function showAction(){

        $userID = $_SESSION['user_id'];

        if(!isset($_GET['tenant_id'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }

        $tenant_id = $_GET['tenant_id'];

        $tenant = $this->tenant->getOneRecordById($tenant_id, $userID);

        if(!$tenant){
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

        $propertyList = $this->accountModel->propertyList($tenant->id, 'tenant');

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($tenant->name, 'Profil nájemníka');

        $this->set(compact('tenant', 'propertyList', 'tokenInput'));

    }

    public function createAction(){
        [$errors, $old] = $this->errorBag->getErrors();
        $reCaptcha = true;
        $tokenInput = CSRF::createCsrfInput();
        $this->setMeta('Nový nájemník', 'Vytvoření nového nájemníka');
        $this->set(compact('reCaptcha', 'tokenInput', 'errors', 'old'));
    }


    /**
     * @throws Exception
     */
    public function saveAction(){

        $data = $this->validator->validate(sanitize($_POST));
        $userID = $_SESSION['user_id'];
        $tenantDto = $this->tenantDataFactory->createFromArray($data);
        $tenantId = $this->createTenantAction->execute($tenantDto, $userID);
        flash('success', 'Nájemník byl úspěšně vytvořen.', 'success');
        redirect("/user/tenants/show?tenant_id={$tenantId}");

    }


    public function profileeditingAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['tenant_id'])){
            $tenant_id = $_GET['tenant_id'];
            $tenant = R::findOne('tenant', 'id=? AND user_id=?',[$tenant_id, $userID]);
            if ($tenant) {

                $this->set(compact('tenant'));
                $this->setMeta($tenant->name . '- editace', 'Profile nájemníka');

            }else{
                $_SESSION['account_error'] = 'Nepodarilo se najit uzivatele!';
                redirect('/user/error');
            }

        } else {
            redirect('/user/tenants');
        }

    }

    /**
     * @throws SQL
     * @throws Exception
     */
    public function profilesaveAction()
    {

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if (isset($_GET['tenant_id'])) {

            $tenantID = $_GET['tenant_id'];

            if(!empty($_POST['tenant_name']) &&
               !empty($_POST['tenant_address']) &&
               isset($_POST['tenant_email']) &&
               isset($_POST['tenant_phone_number']) &&
               isset($_POST['tenant_account'])){

                $tenant = R::findOne('tenant', 'id=? AND user_id=?',  [$tenantID, $userID] );
                if($tenant){

                    $tenant->name = $_POST['tenant_name'];
                    $tenant->address = $_POST['tenant_address'];
                    $tenant->phone_number = $_POST['tenant_phone_number'];
                    $tenant->email = $_POST['tenant_email'];
                    $tenant->account = $_POST['tenant_account'];

                    if (!R::store($tenant)) throw new Exception('Chyba zapisu do DB!');

                    redirect("/user/tenants/profile?tenant_id={$tenantID}");

                } else {
                    $_SESSION['account_error'] = 'Nepodarilo se najit uzivatele!';
                    redirect('/user/error');
                }

            }else{
                redirect('/user/tenants');
            }

        } else {
            redirect('/user/tenants');
        }

    }


    public function profiledeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_GET['tenant_id'])) {
            $tenantID = $_GET['tenant_id'];
            $tenant = R::findOne('tenant', 'id=? AND user_id=?', [$tenantID, $userID]);
            if ($tenant) {

                R::trash($tenant);
                redirect('/user/tenants');

            } else {
                $_SESSION['account_error'] = 'Nepodarilo se najit uzivatele!';
                redirect('/user/error');
            }
        }else{

            redirect('/user/tenants');

        }

    }







    /*public function savemodalAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }


        $response = [];

        $userID = $_SESSION['user_id'];


        if(!empty($_POST['tenant_name']) &&
            !empty($_POST['tenant_address']) &&
            isset($_POST['tenant_email']) &&
            isset($_POST['tenant_phone_number']) &&
            isset($_POST['tenant_account'])){



            $tenant = R::dispense('tenant');

            $tenant->name = $_POST['tenant_name'];
            $tenant->address = $_POST['tenant_address'];
            $tenant->phone_number = $_POST['tenant_phone_number'];
            $tenant->email = $_POST['tenant_email'];
            $tenant->account = $_POST['tenant_account'];
            $tenant->user_id = $userID;


            unset($_POST['tenant_name']);
            unset($_POST['tenant_address']);
            unset($_POST['tenant_email']);
            unset($_POST['tenant_phone_number']);
            unset($_POST['tenant_account']);



            if (!($tenantID = R::store($tenant))) throw new Exception('Chyba zápisu do DB!');

            $currentTenant = R::findOne('tenant', 'id=? AND user_id=?',[$tenantID, $userID]);

            $response['tenantID'] = $tenantID;
            $response['tenantName'] = $currentTenant->name;
            $response['tenantAddress'] = $currentTenant->address;
            $response['success'] =  true;

            echo json_encode($response);
            die();

        } else {


            $response['success'] =  false;
            $response['error'] = 'Error!';
            echo json_encode($response);
            die();
        }

    }*/


    /**
     * @return void|null
     * @throws Exception
     */
    public function gettenantlistAction(){
        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'GET') {

                if (!is_user_logged_in()) {
                    die();
                }
                $userID = $_SESSION['user_id'];

                $request = $_GET['term'];

                if (isset($request)) {

                    $tenants = R::getAll("SELECT id,name FROM tenant WHERE (name LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

                    $result = [];
                    foreach ($tenants as $k => $v) {
                        $result[] = [
                            "id" => $v['id'],
                            "text" => $v['name']
                        ];
                    }

                    echo json_encode($result);
                    die();
                }

                return null;
            }
        }

        throw new Exception('Stránka není nalezená', 404);

    }







}