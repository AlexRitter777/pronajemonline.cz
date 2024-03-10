<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\models\User;
use Exception;
use RedBeanPHP\R;

class SettingsController extends AppController
{

    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Nastavení uživatele', 'Změna jména a hesla uživatele');

        $this->layout = 'account_form_new';

    }

    /**
     * Save user settings from user profile
     *
     * @throws Exception
     */
    public function saveAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        //Save user name
        if(!empty($_POST['user_name'])){

            $userName = $_POST['user_name'];

            $currentUser = R::findOne('users', 'id = ?', [$userID]);;

            if($currentUser){

                $currentUser->username = $userName;
                if (!R::store($currentUser)) throw new Exception('Chyba zápisu do DB!');
                $_SESSION['username'] = $userName;
                redirect();

            }else{

                $user = new User();
                $user->logout();
                redirect('/user/login');

            }

        }

        redirect();

    }

}