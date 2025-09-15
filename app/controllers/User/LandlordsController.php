<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\db_models\Landlord;
use app\models\Account;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class LandlordsController extends AppController {


    #[Inject]
    private Account $accountModel;

    #[Inject]
    private Landlord $landlord;

    #[Inject]
    private PaginationSetParams $pagination;

    public function __construct($route) {

        parent::__construct($route);

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

    }

    public function indexAction(){

        $userID = $_SESSION['user_id'];

        $this->setMeta('Pronajímatele', 'Seznam pronajímatelů');

        $this->layout = 'account';

        $landlords = $this->landlord->getAllRecordsWithPagination(8, $userID);

        $landlordProp = $this->accountModel->personProps('landlord');

        $pagination = $this->pagination;

        $accountModel = $this->accountModel;

        $this->set(compact('landlords', 'landlordProp', 'pagination', 'accountModel'));

    }

    public function profileAction(){

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['landlord_id'])){
            $landlord_id = $_GET['landlord_id'];

            $landlord = $this->landlord->getOneRecordById($landlord_id, $userID);

            if ($landlord) {

                $propertyList = $this->accountModel->propertyList($landlord->id, 'landlord');
                $this->setMeta($landlord->name, 'Profil pronajímatele');
                $this->set(compact('landlord', 'propertyList'));

            }else{

                $_SESSION['account_error'] = 'Nepodařilo se najít pronajímatele!';
                redirect('/user/error');

            }

        }else {

            redirect('/user/landlords');

        }

    }

    public function profileeditingAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';
        //$this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['landlord_id'])){
            $landlord_id = $_GET['landlord_id'];
            $landlord = R::findOne('landlord', 'id=? AND user_id=?',[$landlord_id, $userID]);
            if ($landlord) {

                $this->set(compact('landlord'));
                $this->setMeta($landlord->name . '- editace', 'Profil pronajímatele');

            }else{
                $_SESSION['account_error'] = 'Nepodařilo se najít pronajímatele!';
                redirect('/user/error');
            }

        } else {
            redirect('/user/landlords');
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

        if (isset($_GET['landlord_id'])) {

            $landlordID = $_GET['landlord_id'];

            if(!empty($_POST['landlord_name']) &&
                !empty($_POST['landlord_address']) &&
                isset($_POST['landlord_email']) &&
                isset($_POST['landlord_phone_number']) &&
                isset($_POST['landlord_account'])){

                $landlord = R::findOne('landlord', 'id=? AND user_id=?',  [$landlordID, $userID] );
                if($landlord){

                    $landlord->name = $_POST['landlord_name'];
                    $landlord->address = $_POST['landlord_address'];
                    $landlord->phone_number = $_POST['landlord_phone_number'];
                    $landlord->email = $_POST['landlord_email'];
                    $landlord->account = $_POST['landlord_account'];

                    if (!R::store($landlord)) throw new Exception('Chyba zápisu do DB!');

                    redirect("/user/landlords/profile?landlord_id={$landlordID}");

                } else {
                    $_SESSION['account_error'] = 'Nepodařilo se najít pronajímatele!';
                    redirect('/user/error');
                }

            }else{
                redirect('/user/landlords');
            }

        } else {
            redirect('/user/landlords');
        }

    }

    public function profiledeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_GET['landlord_id'])) {
            $landlordID = $_GET['landlord_id'];
            $landlord = R::findOne('landlord', 'id=? AND user_id=?', [$landlordID, $userID]);
            if ($landlord) {

                R::trash($landlord);
                redirect('/user/landlords');

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít pronajímatele!';
                redirect('/user/error');
            }
        }else{

            redirect('/user/landlords');

        }

    }

    public function addAction(){

        $this->layout = 'account';
        $reCaptcha = true;

        $this->setMeta('Nový pronajímatel', 'Vytvoření nového pronajímatele');
        $this->set(compact('reCaptcha'));

    }


    /**
     * @throws SQL
     * @throws Exception
     */
    public function saveAction(){

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        //Ajax validation via form-validation.js

        if(!empty($_POST['landlord_name']) &&
            !empty($_POST['landlord_address']) &&
            isset($_POST['landlord_email']) &&
            isset($_POST['landlord_phone_number']) &&
            isset($_POST['landlord_account'])){

            $landlord = R::dispense('landlord');

            $landlord->name = $_POST['landlord_name'];
            $landlord->address = $_POST['landlord_address'];
            $landlord->phone_number = $_POST['landlord_phone_number'];
            $landlord->email = $_POST['landlord_email'];
            $landlord->account = $_POST['landlord_account'];
            $landlord->user_id = $userID;

            if (!($landlordID = R::store($landlord))) throw new Exception('Chyba zápisu do DB!');

            redirect("/user/landlords/profile?landlord_id={$landlordID}");

        } else {
            redirect('/user/landlords');
        }

    }


    /*public function savemodalAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }


        $response = [];

        $userID = $_SESSION['user_id'];


        if(!empty($_POST['landlord_name']) &&
            !empty($_POST['landlord_address']) &&
            isset($_POST['landlord_email']) &&
            isset($_POST['landlord_phone_number']) &&
            isset($_POST['landlord_account'])){



            $landlord = R::dispense('landlord');

            $landlord->name = $_POST['landlord_name'];
            $landlord->address = $_POST['landlord_address'];
            $landlord->phone_number = $_POST['landlord_phone_number'];
            $landlord->email = $_POST['landlord_email'];
            $landlord->account = $_POST['landlord_account'];
            $landlord->user_id = $userID;


            unset($_POST['landlord_name']);
            unset($_POST['landlord_address']);
            unset($_POST['landlord_email']);
            unset($_POST['landlord_phone_number']);
            unset($_POST['landlord_account']);



            if (!($landlordID = R::store($landlord))) throw new Exception('Chyba zápisu do DB!');

            $landlordName = R::findOne('landlord', 'id=? AND user_id=?',[$landlordID, $userID]);

            $response['landlordID'] = $landlordID;
            $response['landlordName'] = $landlordName->name;
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




    public function getlandlordlistAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        $request = $_GET['term'];

        if (isset($request)) {

            $landlords = R::getAll("SELECT id,name FROM landlord WHERE (name LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

            $result = [];
            foreach ($landlords as $k => $v) {
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