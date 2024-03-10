<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\models\Account;
use RedBeanPHP\R;
use Exception;
use RedBeanPHP\RedException\SQL;

class AdminsController extends AppController {


    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Správci', 'Seznam správců');

        $this->layout = 'account';

        $admins = R::findAll('admin', 'user_id=?', [$userID]);

        $this->set(compact('admins'));

    }

    public function profileAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['admin_id'])){
            $admin_id = $_GET['admin_id'];
            $admin = R::findOne('admin', 'id=? AND user_id=?',[$admin_id, $userID]);
            if ($admin) {
                $accountModel = new Account();
                $propertyList = $accountModel->propertyList($admin->id, 'admin');
                $this->setMeta($admin->name, 'Profil správce');
                $this->set(compact('admin', 'propertyList'));

            }else{

                $_SESSION['account_error'] = 'Nepodařilo se najít správce!';
                redirect('/user/error');

            }

        }else {

            redirect('/user/admins');

        }

    }

    public function profileeditingAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['admin_id'])){
            $admin_id = $_GET['admin_id'];
            $admin = R::findOne('admin', 'id=? AND user_id=?',[$admin_id, $userID]);
            if ($admin) {
                //$accountModel = new Account();
                //$propertyList = $accountModel->propertyList($admin->id, 'admin');
                $this->set(compact('admin'/*, 'propertyList'*/));
                $this->setMeta($admin->name . '- editace', 'Profil správce');

            }else{
                $_SESSION['account_error'] = 'Nepodařilo se najít správce!';
                redirect('/user/error');
            }

        } else {
            redirect('/user/admins');
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

        if (isset($_GET['admin_id'])) {

            $adminID = $_GET['admin_id'];

            if(!empty($_POST['admin_name']) &&
                isset($_POST['admin_phone']) &&
                isset($_POST['admin_email']) &&
                isset($_POST['admin_tech_name']) &&
                isset($_POST['admin_tech_phone']) &&
                isset($_POST['admin_tech_email']) &&
                isset($_POST['admin_acc_name']) &&
                isset($_POST['admin_acc_phone']) &&
                isset($_POST['admin_acc_email'])) {

                $admin = R::findOne('admin', 'id=? AND user_id=?',  [$adminID, $userID] );
                if($admin){

                    $admin->name = $_POST['admin_name'];
                    $admin->phone = $_POST['admin_phone'];
                    $admin->email = $_POST['admin_email'];
                    $admin->tech_name = $_POST['admin_tech_name'];
                    $admin->tech_phone = $_POST['admin_tech_phone'];
                    $admin->tech_email = $_POST['admin_tech_email'];
                    $admin->acc_name = $_POST['admin_acc_name'];
                    $admin->acc_phone = $_POST['admin_acc_phone'];
                    $admin->acc_email = $_POST['admin_acc_email'];

                    if (!R::store($admin)) throw new Exception('Chyba zápisu do DB!');

                    redirect("/user/admins/profile?admin_id={$adminID}");

                } else {
                    $_SESSION['account_error'] = 'Nepodařilo se najít správce!';
                    redirect('/user/error');
                }

            }else{
                redirect('/user/admins');
            }

        } else {
            redirect('/user/admins');
        }

    }

    public function profiledeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_GET['admin_id'])) {
            $adminID = $_GET['admin_id'];
            $admin = R::findOne('admin', 'id=? AND user_id=?', [$adminID, $userID]);
            if ($admin) {

                R::trash($admin);
                redirect('/user/admins');

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít spávce!';
                redirect('/user/error');
            }
        }else{

            redirect('/user/admins');

        }

    }


    public function addAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $this->setMeta('Nový správce', 'Vytvoření nového správce');

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

        if (!empty($_POST['admin_name']) &&
            isset($_POST['admin_phone']) &&
            isset($_POST['admin_email']) &&
            isset($_POST['admin_tech_name']) &&
            isset($_POST['admin_tech_phone']) &&
            isset($_POST['admin_tech_email']) &&
            isset($_POST['admin_acc_name']) &&
            isset($_POST['admin_acc_phone']) &&
            isset($_POST['admin_acc_email'])){

            $admin = R::dispense('admin');

            $admin->name = $_POST['admin_name'];
            $admin->phone = $_POST['admin_phone'];
            $admin->email = $_POST['admin_email'];
            $admin->tech_name = $_POST['admin_tech_name'];
            $admin->tech_phone = $_POST['admin_tech_phone'];
            $admin->tech_email = $_POST['admin_tech_email'];
            $admin->acc_name = $_POST['admin_acc_name'];
            $admin->acc_phone = $_POST['admin_acc_phone'];
            $admin->acc_email = $_POST['admin_acc_email'];
            $admin->user_id = $userID;

            if (!($adminID = R::store($admin))) throw new Exception('Chyba zápisu do DB!');

            redirect("/user/admins/profile?admin_id={$adminID}");

        } else {
            redirect('/user/admins');
        }

    }

    /*public function savemodalAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $response = [];

        $userID = $_SESSION['user_id'];

        //check if it is an ajax request and data was sent in POST
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $data = $_POST;
                $account = new Account();
                $formName = $account->getFormName();
                $recordId = $account->saveData($formName, $data, $userID);
                $newRecord = $account->getRecordById($recordId, $formName, $userID);
                $response["{$formName}ID"] = $recordId;
                $response["{$formName}Name"] = $newRecord->name;

                echo json_encode($response);
                die;

            }

            redirect('/user/account');
        }

        redirect('/user/account');


    }*/






    public function getadminlistAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        $request = $_GET['term'];

        if (isset($request)) {

            $admins = R::getAll("SELECT id,name FROM admin WHERE (name LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

            $result = [];
            foreach ($admins as $k => $v) {
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