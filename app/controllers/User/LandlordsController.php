<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\db_models\Landlord;
use app\models\Account;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;
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

        $landlords = $this->landlord->getAllRecordsWithPagination(8, $userID);

        $landlordProp = $this->accountModel->personProps('landlord');

        $pagination = $this->pagination;

        $accountModel = $this->accountModel;

        $tokenInput = CSRF::createCsrfInput();

        $this->set(compact('landlords', 'landlordProp', 'pagination', 'accountModel', 'tokenInput'));

    }

    // Landlord profile
    public function showAction(){

        $userID = $_SESSION['user_id'];

        if(!isset($_GET['landlord_id'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }

        $landlord_id = $_GET['landlord_id'];

        $landlord = $this->landlord->getOneRecordById($landlord_id, $userID);

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
    public function createAction(){

        $this->layout = 'account';
        $reCaptcha = true;
        $tokenInput = CSRF::createCsrfInput();
        $this->setMeta('Nový pronajímatel', 'Vytvoření nového pronajímatele');
        $this->set(compact('reCaptcha', 'tokenInput'));

    }

    // Save new landlord
    /**
     * @throws SQL
     * @throws Exception
     */
    public function saveAction(){

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }

        $userID = $_SESSION['user_id'];

        //Ajax validation via form-validation.js

        if(
            empty($_POST['landlord_name']) ||
            empty($_POST['landlord_address']) ||
            !isset($_POST['landlord_email']) ||
            !isset($_POST['landlord_phone_number']) ||
            !isset($_POST['landlord_account'])
        ) {
            flash('error', 'Vyplňte prosím všechny potřebné údaje.', 'error');
            redirect('/user/landlords/add');
        }

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
        redirect("/user/landlords/show?landlord_id={$landlordID}");

    }

    // Edit landlord profile
    public function editAction(){

        $userID = $_SESSION['user_id'];

        if(!isset($_GET['landlord_id'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }
        $landlord_id = $_GET['landlord_id'];
        $landlord = $this->landlord->getOneRecordById($landlord_id, $userID);

        if(!$landlord) {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

        $reCaptcha = true;
        $tokenInput = CSRF::createCsrfInput();

        $this->set(compact('landlord', 'reCaptcha', 'tokenInput'));
        $this->setMeta($landlord->name . '- editace', 'Profil pronajímatele');

    }

    // Save edited landlord profile
    /**
     * @throws SQL
     * @throws Exception
     */
    public function updateAction()
    {

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

        $userID = $_SESSION['user_id'];


        if(!isset($_GET['landlord_id'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect();
        }

        $landlordID = $_GET['landlord_id'];

        //Ajax validation via form-validation.js

        if(
            empty($_POST['landlord_name']) ||
            empty($_POST['landlord_address']) ||
            !isset($_POST['landlord_email']) ||
            !isset($_POST['landlord_phone_number']) ||
            !isset($_POST['landlord_account'])
        ) {
            flash('error', 'Vyplňte prosím všechny potřebné údaje.', 'error');
            redirect("/user/landlords/edit?landlord_id={$landlordID}");
        }


        $landlord = $this->landlord->getOneRecordById($landlordID, $userID);

        if(!$landlord) {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

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
        redirect("/user/landlords/show?landlord_id={$landlordID}");

    }

    // Delete landlord
    public function destroyAction(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }


        if(empty($_POST['landlord'])){
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/user/landlords');
        }

        $userId = $_SESSION['user_id'];

        $landlordID = $_POST['landlord'];

        $recordDeleted = $this->landlord->deleteOneRecordbyIdAndUserId($landlordID, $userId);

        if($recordDeleted){
            flash('success', 'Pronajímatel byl úspěšně smazán.', 'success');
            redirect('/user/landlords');
        } else {
            flash('error', 'Nepodařilo se najít pronajímatele!', 'error');
            redirect();
        }

    }


}