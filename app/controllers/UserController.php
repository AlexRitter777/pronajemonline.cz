<?php

namespace app\controllers;

use app\models\Account;
use app\models\User;
use Exception;
use Mpdf\Tag\U;
use RedBeanPHP\R;

class UserController extends AppController
{



    public function indexAction(){
        if(is_user_logged_in()){
            redirect('/user/account');
        }

        redirect('/user/login');

    }



    public function signupAction() {


        if(is_user_logged_in()){
            redirect('/user/account');
        }

        $this->setMeta('Registrace uživatele');
        $this->layout = 'pronajemform';

    }


    /**
     * @throws Exception
     */
    public function registerAction() : void // test wrong resending email with link
    {

        if(is_user_logged_in()){
            redirect('/user/account');
        }


        if (($_POST) && !empty($_POST['userName']) && !empty($_POST['userEmail']) && !empty($_POST['userPassword'])){

            $userName = $_POST['userName'];
            $userPassword = $_POST['userPassword'];
            $userEmail = $_POST['userEmail'];

            $user = new User();

            if($user->isUserExist($userEmail) && $user->isUserActiveByEmail($userEmail)){
                redirect('login');
            }

            if(!$user->isUserActiveByEmail($userEmail)){
                $user->deleteUserByEmail($userEmail);
            }

            $activationCode = $user->activationCodeGen();

            if($user->registerUser($userEmail, $userName, $userPassword, $activationCode)) {

                $user->sendActivationCode($userEmail, $activationCode);
                $_SESSION['user_email'] = $userEmail;
                $_SESSION['activation_email_sent'] = true;

            } else {

                throw new Exception('Chyba registraci!', 500);

            }

            redirect('/user/activation-link-sent');

        } else {

            redirect('/user/signup');

        }

    }


    public function activationlinksentAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }

/*        if(!isset($_SESSION['activation_email_sent'])){
            redirect('signup');
        }*/

        unset($_SESSION['activation_email_sent']);


        $this->setMeta('Registrace uživatele');

    }



    /**
     * @throws Exception
     */
    public function resendactivationemailAction()
    {
        if(is_user_logged_in()){
            redirect('/user/account');
        }

        if (!empty($_SESSION['user_email'])){

            $user = new User();
            $userEmail = $_SESSION['user_email'];

            if (!$user->isUserActiveByEmail($userEmail) && $user->isUserExist($userEmail)){
                $activationCode = $user->activationCodeGen();
                if($user->updateActivationCode($userEmail, $activationCode)){

                    $user->sendActivationCode($userEmail, $activationCode);

                }else{
                    throw new Exception('Chyba registraci!', 500);
                }

            }else{
                redirect('/user/login');
            }

        }else{

            redirect('/user/signup');
        }


    }



    public function activateAction(){


        if(is_user_logged_in()){
            redirect('/user/account');
        }

        if(isset($_GET['email']) && isset($_GET['activation_code'])) {

            unset($_SESSION['user_email']);
            $email = $_GET['email'];
            $activationCode = $_GET['activation_code'];

            $user = new User();

            if (!$user->isUserExist($email)){
                redirect('/user/signup');
            }

            if ($user->isUserActiveByEmail($email)) {
                redirect('/user/login');
            }

            $newUser = $user->findUnverifiedUser($activationCode, $email);

            if($newUser[0]['id'] && $user->activateUser($newUser[0]['id'])){

                $_SESSION['verification_result'] = 'Gratulujeme! Vás účet byl úspěšně aktivován. Můžete <a class="login_link" href="/user/login">se přihlásit</a>.';
                $user->sendRegisterConfirmation($email);

            } else {

                $_SESSION['verification_result'] = 'Aktivační odkaz není validní!';
            }

            redirect('verification-result');

        } else {

            redirect('/user/signup');

        }

    }

    public function verificationresultAction(){
        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if (!isset($_SESSION['verification_result'])){
            redirect('/user/login');
        }

        $verificationResult = $_SESSION['verification_result'];

        $this->set(compact('verificationResult'));

        unset($_SESSION['verification_result']);

        $this->setMeta('Verification result', 'Registrace' );

    }


    public function loginAction()
    {

        if (is_user_logged_in()){
            redirect('/user/account');
        }


        $this->setMeta('Přihlášení uživatele');

        $this->layout = 'pronajemform';

    }


    public function accountAction()
    {

        if (!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->setMeta('Můj účet', 'My account');

        $userID = $_SESSION['user_id'];

        $this->layout = 'account';

        //create Account model
        $accountModel = new Account();

        //Get five last changed calculations from each table . Returns NULL when there are no calculations

        $calcTypes = [
            'Vyúčtování služeb spojených s užíváním nemovitostí' => 'servicescalc',
            'Zjednodušené vyúčtování služeb spojených s užíváním nemovitostí' => 'easyservicescalc',
            'Vyúčtování spotřeby elektřiny' => 'electrocalc',
            'Vyúčtování kauce složené nájemníkem' => 'depositcalc',
            'Souhrnné vyúčtování' => 'totalcalc',
            'Univerzalní vyúčtování' => 'universalcalc',
        ];

        $calculations = $accountModel->createCalculationsBatch($calcTypes, $userID);

        //Count records from all tables
        $count = [];
        $count['landlord'] = R::count('landlord', "user_id=?", [$userID]);
        $count['tenant'] = R::count('tenant', "user_id=?", [$userID]);
        $count['property'] = R::count('property', "user_id=?", [$userID]);
        $count['admin'] = R::count('admin', "user_id=?", [$userID]);
        $count['elsupplier'] = R::count('elsupplier', "user_id=?", [$userID]);


        $this->set(compact('calculations', 'calcTypes', 'count'));


    }



    public function logoutAction() {

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $user = new User();
        $user->logout();
        redirect('/user/login');


    }

    public function authorizationAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if($_POST && !empty($_POST['userEmail'] && !empty($_POST['userPassword']))) {
            $userEmail = $_POST['userEmail'];
            $userPassword = $_POST['userPassword'];
            $rememberMe = isset($_POST['remember_me']);
        } else {

            redirect('/user/login');

        }

        $user = new User();

        if (!$user->login($userEmail, $userPassword, $rememberMe)){

            redirect('/user/login');

        }

        redirect('/user/account');


    }


    public function authorizationajaxAction(){

        if (is_user_logged_in()){
            echo json_encode(['success' => false]);
            die();
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $userEmail = $_POST['userEmail'];
                $userPassword = $_POST['userPassword'];
                $rememberMe = isset($_POST['remember_me']);

                $user = new User();

                if (!$user->login($userEmail, $userPassword, $rememberMe)){

                    echo json_encode(['success' => false]);
                    die();

                }

                echo json_encode(['success' => true]);
                die();

            }
        }

        redirect('/user/login');


    }





    public function passwordresetAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }
        $this->layout = 'pronajemform';

        $this->setMeta('Zapomenuté heslo', 'Zapomenuté heslo' );

    }

    /**
     * @throws Exception
     */
    public function sendresetlinkAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }


        if (isset($_POST['userEmail'])) {
            $email = $_POST['userEmail'];

            $user = new User();
            $resetUser = $user->findUserByEmail($email);


            if ($resetUser && $user->isUserActiveByEmail($email)){

                $user->deleteUserToken($resetUser[0]['id'],'usertokensreset');

                [$selector, $validator, $token] = $user->generateTokens();

                if($user->insertResetPasswordToken($resetUser[0]['id'], 60, $selector, $validator)){

                     $user->sendPasswordResetCode($email, $token);
                     $_SESSION['link_sent'] = true;
                     redirect('send-link-success');

                }else{
                    throw new Exception('Chyba zápisu do DB!', 500);
                };


            }else{
                redirect('/user/login');
            }


        }else{
            redirect('/user/login');
        }


    }


    public function sendlinksuccessAction(){
        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if(!isset($_SESSION['link_sent'])){
            redirect('/user/login');
        }

        unset($_SESSION['link_sent']);

        $this->setMeta('Zapomenuté heslo');

    }

    public function passwordresetauthAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if(isset($_GET['reset_code'])){

            $resetCode = $_GET['reset_code'];

            $user = new User();

            $resetUser = $user->verifyResetToken($resetCode);

            if($resetUser){
                $_SESSION['reset_user_id'] = $resetUser[0]['id'];
                $_SESSION['password_reset_form'] = true;
                redirect('password-reset-form');


            }else{

                $_SESSION['password_reset_result'] = 'Odkaz pro resetování hesla není validní!';
                redirect('password-reset-result');

            }

        }else{
            redirect('/user/login');
        }


    }

    public function passwordresetformAction(){

        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if(!isset($_SESSION['password_reset_form'])){
            redirect('/user/login');
        }

        unset($_SESSION['password_reset_form']);

        $this->layout = 'pronajemform';

        $this->setMeta('Password reset', 'Zapomenuté heslo' );

    }


    public function passwordresetresultAction(){
        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if (!isset($_SESSION['password_reset_result'])){
            redirect('/user/login');
        }

        $passwordResetResult = $_SESSION['password_reset_result'];

        $this->set(compact('passwordResetResult'));

        unset($_SESSION['password_reset_result']);

        $this->setMeta('Password reset result', 'Zapomenuté heslo' );

    }

    /**
     * @throws Exception
     */
    public function changepasswordAction(){
        if (is_user_logged_in()){
            redirect('/user/account');
        }

        if(!isset($_SESSION['reset_user_id'])){
            redirect('/user/login');
        }

        if (isset($_POST['userPassword'])) {

            $resetUserId = $_SESSION['reset_user_id'];
            $newPassword = $_POST['userPassword'];
            $user = new User();

            if ($user->changePassword($resetUserId, $newPassword)) {

                $user->deleteUserToken($resetUserId, 'usertokensreset');

                $resetUser = $user->findUserById($resetUserId);

                unset($_SESSION['reset_user_id']);

                $_SESSION['password_reset_result'] = 'Vaše heslo bylo úspěšně změněno!';

                $user->sendResetPasswordConfirmation($resetUser->email);

                redirect('password-reset-result');

            } else {
                throw new Exception('Chyba zapisu do DB!', 500);
            }



        }else{
            redirect('/user/login');
        }


    }


    /**
     * Changes password via ajax request from user account settings
     *
     * @throws Exception
     */
    public function changepasswordajaxAction(){

        if (!is_user_logged_in()){
            redirect('user/login');
        }

        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {


                $userId = $_SESSION['user_id'];
                $currentPassword = $_POST['current_password'];
                $newPassword = $_POST['new_password'];

                $user = new User();

                //get current user email
                if($currentUser = $user->findUserById($userId)){

                    $userEmail = $currentUser->email;

                    //Check current email and password
                    if($user->checkUserPassword($userEmail, $currentPassword)){

                        //change user password
                        if ($user->changePassword($userId, $newPassword)) {

                            //send email confirmation
                            $user->sendResetPasswordConfirmation($userEmail);

                            echo json_encode(['success' => true]);
                            die();

                        } else {
                            throw new Exception('Chyba zápisu do DB!', 500);
                        }


                    } else {

                        echo json_encode(['success' => false]);
                        die();

                    }

                }

                echo json_encode(['success' => false]);
                die();

            }

        }

    }



}