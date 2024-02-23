<?php

namespace app\controllers\user;

use app\controllers\AppController;
use app\models\Account;
use Exception;
use pronajem\libs\Pagination;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use setasign\Fpdi\PdfParser\Filter\FilterInterface;

class TenantsController extends AppController {

    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Nájemníci', 'Seznam nájemníků');

        $this->layout = 'account';

        $total = R::count('tenant', 'user_id=?', [$userID] );
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $tenants = R::findAll('tenant', "user_id=? LIMIT $start, $perpage", [$userID]);

        $accountModel = new Account();

        $tenantProp = $accountModel->personProps('tenant');

        $this->set(compact('tenants', 'tenantProp', 'pagination', 'total'));

    }


    public function profileAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['tenant_id'])){
            $tenant_id = $_GET['tenant_id'];
            $tenant = R::findOne('tenant', 'id=? AND user_id=?',[$tenant_id, $userID]);
            if ($tenant) {

                $accountModel = new Account();
                $propertyList = $accountModel->propertyList($tenant->id, 'tenant');
                //debug($propertyList);die();

                $this->setMeta($tenant->name, 'Profil nájemníka');
                $this->set(compact('tenant', 'propertyList'));

            }else{

                $_SESSION['account_error'] = 'Nepodařilo se najít nájemníka!';
                redirect('/user/error');

            }

        }else {

            redirect('/user/tenants');

        }

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


    public function addAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $this->setMeta('Nový nájemník', 'Vytvoření nového nájemníka');

    }


    /**
     * @throws SQL
     * @throws Exception
     */
    public function saveAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $this->layout = 'account';

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

                if (!($tenantID = R::store($tenant))) throw new Exception('Chyba zápisu do DB!');

                redirect("/user/tenants/profile?tenant_id={$tenantID}");

            } else {
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