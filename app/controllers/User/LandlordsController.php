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

    // List of landlords
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

    // Landlord profile
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
                flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
                redirect();

            }

        }else {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();

        }

    }

    // Edit landlord profile
    public function profileeditingAction(){

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['landlord_id'])){
            $landlord_id = $_GET['landlord_id'];
            $landlord = $this->landlord->getOneRecordById($landlord_id, $userID);
            if ($landlord) {
                $reCaptcha = true;
                $this->set(compact('landlord', 'reCaptcha'));
                $this->setMeta($landlord->name . '- editace', 'Profil pronajímatele');
            }else{
                flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
                redirect();
            }

        } else {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

    }

    // Save edited landlord profile
    /**
     * @throws SQL
     * @throws Exception
     */
    public function profilesaveAction()
    {

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if (isset($_GET['landlord_id'])) {

            $landlordID = $_GET['landlord_id'];

            if(!empty($_POST['landlord_name']) &&
                !empty($_POST['landlord_address']) &&
                isset($_POST['landlord_email']) &&
                isset($_POST['landlord_phone_number']) &&
                isset($_POST['landlord_account'])){

                $landlord = $this->landlord->getOneRecordById($landlordID, $userID);

                if($landlord){

                    $data = $this->landlord->saveAll([
                            'name' => $_POST['landlord_name'],
                            'address' => $_POST['landlord_address'],
                            'phone_number' => $_POST['landlord_phone_number'],
                            'email' => $_POST['landlord_email'],
                            'account' => $_POST['landlord_account']
                        ]
                    );

                    if (!$data) throw new Exception('Chyba zápisu do DB!');

                    flash('success', 'Profil pronajímatele byl úspěšně upraven.', 'success');
                    redirect("/user/landlords/profile?landlord_id={$landlordID}");

                } else {
                    flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
                    redirect();
                }

            }else{
                flash('error', 'Vyplňte prosím všechny potřebné údaje.', 'error');
                redirect();
            }

        } else {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

    }

    // Delete landlord
    public function profiledeleteAction(){

        $userID = $_SESSION['user_id'];

        if (isset($_GET['landlord_id'])) {
            $landlordID = $_GET['landlord_id'];

            $recordDeleted = $this->landlord->deleteOneRecordbyId($landlordID);

            if($recordDeleted){
                flash('success', 'Pronajímatel byl úspěšně smazán.', 'success');
                redirect('/user/landlords');
            } else {
                flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
                redirect();
            }

        }else{
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

    }

    // New landlord form
    public function addAction(){

        $this->layout = 'account';
        $reCaptcha = true;

        $this->setMeta('Nový pronajímatel', 'Vytvoření nového pronajímatele');
        $this->set(compact('reCaptcha'));

    }


    // Save new landlord
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

            $landlordID = $this->landlord->saveAll([
                'name' => $_POST['landlord_name'],
                'address' => $_POST['landlord_address'],
                'phone_number' => $_POST['landlord_phone_number'],
                'email' => $_POST['landlord_email'],
                'account' => $_POST['landlord_account'],
                'user_id' => $userID
            ]);

            if (!($landlordID)) throw new Exception('Chyba zápisu do DB!');

            flash('success', 'Pronajímatel byl úspěšně vytvořen.', 'success');
            redirect("/user/landlords/profile?landlord_id={$landlordID}");

        } else {
            flash('error', 'Vyplňte prosím všechny potřebné údaje.', 'error');
            redirect('/user/landlords');
        }

    }





    public function getlandlordlistAction(){

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
            exit();
        }

        return null;

    }




}