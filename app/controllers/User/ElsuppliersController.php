<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\models\Account;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class ElsuppliersController extends AppController
{
    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Dodavatelé elektřiny', 'Seznam dodavatelů elektřiny');

        $this->layout = 'account';

        $elsuppliers = R::findAll('elsupplier', 'user_id=?', [$userID]);

        $this->set(compact('elsuppliers'));

    }

    public function profileAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];


        if(isset($_GET['elsupplier_id'])){
            $elsupplier_id = $_GET['elsupplier_id'];
            $elsupplier = R::findOne('elsupplier', 'id=? AND user_id=?',[$elsupplier_id, $userID]);
            if ($elsupplier) {
                $accountModel = new Account();
                $propertyList = $accountModel->propertyList($elsupplier->id, 'elsupplier');
                $this->setMeta($elsupplier->name, 'Profil dodavatele elektřiny');
                $this->set(compact('elsupplier', 'propertyList'));

            }else{

                $_SESSION['account_error'] = 'Nepodařilo se najít dodavatele elektřiny!';
                redirect('/user/error');

            }

        }else {

            redirect('/user/elsuppliers');

        }

    }

    public function profileeditingAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $userID = $_SESSION['user_id'];


        if(isset($_GET['elsupplier_id'])){
            $elsupplier_id = $_GET['elsupplier_id'];
            $elsupplier = R::findOne('elsupplier', 'id=? AND user_id=?',[$elsupplier_id, $userID]);
            if($elsupplier) {

                $this->set(compact('elsupplier'));
                $this->setMeta($elsupplier->name . '- editace', 'Profil dodavatele elektřiny');

            }else{
                $_SESSION['account_error'] = 'Nepodařilo se najít dodavatele elektřiny!';
                redirect('/user/error');
            }

        } else {
            redirect('/user/elsuppliers');
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

        if (isset($_GET['elsupplier_id'])) {

            $elsupplierID = $_GET['elsupplier_id'];

            if(!empty($_POST['elsupplier_name']) &&
                isset($_POST['elsupplier_add_info'])) {

                $elsupplier = R::findOne('elsupplier', 'id=? AND user_id=?',  [$elsupplierID, $userID] );
                if($elsupplier){

                    $elsupplier->name = $_POST['elsupplier_name'];
                    $elsupplier->add_info = $_POST['elsupplier_add_info'];


                    if (!R::store($elsupplier)) throw new Exception('Chyba zápisu do DB!');


                    redirect("/user/elsuppliers/profile?elsupplier_id={$elsupplierID}");

                } else {
                    $_SESSION['account_error'] = 'Nepodařilo se najít dodavatele elektřiny!';
                    redirect('/user/error');
                }

            }else{
                redirect('/user/elsuppliers');
            }

        } else {
            redirect('/user/elsuppliers');
        }

    }

    public function profiledeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_GET['elsupplier_id'])) {
            $elsupplierID = $_GET['elsupplier_id'];
            $elsupplier = R::findOne('elsupplier', 'id=? AND user_id=?', [$elsupplierID, $userID]);
            if ($elsupplier) {

                R::trash($elsupplier);
                redirect('/user/elsuppliers');

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít dodavatele elektřiny!';
                redirect('/user/error');
            }
        }else{

            redirect('/user/elsuppliers');

        }

    }

    public function addAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form_new';

        $this->setMeta('Nový dodavatel elektřiny', 'Založení nového dodavatele elektřiny');

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


        if (!empty($_POST['elsupplier_name']) &&
            isset($_POST['elsupplier_add_info'])){

            $elsupplier = R::dispense('elsupplier');

            $elsupplier->name = $_POST['elsupplier_name'];
            $elsupplier->add_info = $_POST['elsupplier_add_info'];
            $elsupplier->user_id = $userID;

            if (!($elsupplierID = R::store($elsupplier))) throw new Exception('Chyba zápisu do DB!');

            redirect("/user/elsuppliers/profile?elsupplier_id={$elsupplierID}");

        } else {
            redirect('/user/elsuppliers');
        }

    }


    public function getelsupplierlistAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        $request = $_GET['term'];

        if (isset($request)) {

            $elsuppliers = R::getAll("SELECT id,name FROM elsupplier WHERE (name LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

            $result = [];
            foreach ($elsuppliers as $k => $v) {
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