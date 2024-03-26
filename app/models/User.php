<?php

namespace app\models;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use pronajem\app;
use pronajem\libs\EmailSender;
use RedBeanPHP\R;

class User extends AppModel
{


    public function registerUser(string $email, string $username, string $password, string $activation_code, int $expiry = 1 * 24 * 60 * 60, bool $is_admin = false)
    {

        $bean = R::dispense('users');

        $bean->username = $username;
        $bean->email = $email;
        $bean->password = password_hash($password, PASSWORD_BCRYPT);
        $bean->is_admin = (int)$is_admin;
        $bean->activation_code = password_hash($activation_code, PASSWORD_DEFAULT);
        $bean->activation_expiry = date('Y-m-d H:i:s', time() + $expiry);

        return R::store($bean);
    }


    public function activationCodeGen(): string
    {

        return bin2hex(random_bytes(16));

    }

    public function sendActivationCode(string $email, string $activation_code)
    {
        $activationLink = PATH . "/user/activate?email=$email&activation_code=$activation_code";

        EmailSender::sendEmail($email,'Pronajemonline.cz - Ověření emailové adresy', 'user_activationlink', compact('activationLink'));



    }

    public function sendRegisterConfirmation(string $email)
    {


        EmailSender::sendEmail($email,'Pronajemonline.cz - Potvrzení registrace', 'user_register_confirmation', compact(null));


    }


    public function sendResetPasswordConfirmation(string $email)
    {
        EmailSender::sendEmail($email,'Pronajemonline.cz - Potvrzení změny hesla', 'user_passwordreset_confirmation', compact(null));
    }


    public function deleteUserById(int $id, int $active = 0): bool
    {
        $bean = R::findOne('users', 'id=? AND active=?', array($id, $active));
        if (!$bean) {
            return false;
        } else {
            R::trash($bean);
            return true;
        }

    }

    public function deleteUserByEmail(string $email): bool
    {
        $bean = R::findOne('users', 'email=?', array($email));
        if (!$bean) {
            return false;
        } else {
            R::trash($bean);
            return true;
        }

    }


    public function findUnverifiedUserByEmail(string $email){

        return R::getAll('SELECT id, activation_code, activation_expiry < now() as expired FROM users WHERE  active = 0 AND email=:email', [':email' => $email]);

    }

    public function findUnverifiedUser(string $activationCode, string $email)
    {

        $user = $this->findUnverifiedUserByEmail($email);

        if ($user) {
            if ((int)$user[0]['expired'] === 1) {
                $this->deleteUserById($user[0]['id']);
                return null;
            }

            if (password_verify($activationCode, $user[0]['activation_code'])) {
                return $user;
            }

        }

        return null;

    }

    public function activateUser(int $userId)
    {
        $user = R::findOne('users', 'id = ?', [$userId]);

        if ($user) {
            $user->active = 1;
            $user->activated_at = date('y-m-d H:i:s');
            return R::store($user);
        } else {
            return false;
        }

    }

    public function updateActivationCode(string $userEmail, string $newCode)
    {

        $user = R::findOne('users', 'email = ?', [$userEmail]);

        if ($user->id) {
            $user->activation_code = password_hash($newCode, PASSWORD_DEFAULT);
            return R::store($user);
        } else {
            return false;
        }
    }

    public function isUserActive(array $user): bool
    {

        return (int)$user[0]['active'] === 1;

    }

    public function isUserActiveByEmail(string $email): bool
    {
        $user = R::findOne('users', 'email = ?', [$email]);

        if ($user) {

            return (int)$user->active === 1;

        }
        return false;

    }

    public function isUserExist(string $email): bool
    {
        $user = R::findOne('users', 'email = ?', [$email]);
        if ($user) {
            return true;
        }

        return false;
    }

    // login methods

    public function findUserByEmail($email)
    {

        return R::getAll('SELECT id, username, password, active, email FROM users WHERE email = :email', [':email' => $email]);

    }


    public function login(string $email, string $password, bool $remember = false): bool
    {

        $user = $this->findUserByEmail($email);

        if ($user && $this->isUserActive($user) && password_verify($password, $user[0]['password'])) {

            $this->logUserIn($user);

            if ($remember) {
               $this->rememberMe($user[0]['id']);
            }

            return true;

        }
        return false;

    }

    public function checkUserPassword(string $email, string $password) : bool
    {

        $user = $this->findUserByEmail($email);

        if ($user && $this->isUserActive($user) && password_verify($password, $user[0]['password'])){

            return true;

        }

        return false;


    }


    public function logUserIn(array $user): bool
    {

        if(session_regenerate_id()) {

            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['username'] = $user[0]['username'];
            $_SESSION['useremail'] = $user[0]['email'];
            return true;
        }

        return false;

    }





    //logout
    public function logout(): void
    {

        if($this->isUserLoggedIn()){

            $this->deleteUserToken($_SESSION['user_id'], 'usertokens');

            unset($_SESSION['username'], $_SESSION['user_id']);

            if (isset($_COOKIE['remember_me'])){
                unset($_COOKIE['remember_me']);
                setcookie('remember_me', null, -1, '/');
            }


        }






    }

    public function isUserLoggedIn(): bool
    {
        if (isset($_SESSION['user_id'])){
            return true;
        };


        $token = $_COOKIE['remember_me'] ?? null;

        if($token && $this->tokenIsValid($token, 'usertokens')) {

            $user = $this->findUserByToken($token, 'usertokens');

            if($user) {
                return $this->logUserIn($user);
            }

        }

        return false;
    }


    // remember me functionality methods


    /**
     * @throws \Exception
     */
    public function generateTokens(): array
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ':' . $validator];
    }


    public function parseToken(string $token): ?array
    {
        $parts = explode(':', $token);

        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }
        return null;
    }

    public function insertUserToken(string $table, int $user_id, string $selector, string $hashed_validator, string $expiry)
    {

        $bean = R::dispense($table);

        $bean->user_id = $user_id;
        $bean->selector = $selector;
        $bean->hashed_validator = $hashed_validator;
        $bean->expiry = $expiry;

        return R::store($bean);
    }


    public function findUserTokenBySelector(string $selector, string $table): array
    {

        return R::getAll("SELECT id, selector, hashed_validator, user_id, expiry FROM $table WHERE  selector =:selector AND expiry >= now() LIMIT 1", [':selector' => $selector]);

    }


    public function deleteUserToken(int $userId, string $table): bool
    {
        $bean = R::findOne($table, 'user_id=?', array($userId));
        if (empty($bean)) {
            return false;
        } else {
            R::trash($bean);
            return true;
        }

    }

    public function findUserByToken(string $token, string $table)
    {

        $tokens = $this->parseToken($token);

        if (!$tokens) {
            return null;
        }

        return R::getAll("SELECT users.id, username
            FROM users
            INNER JOIN $table ON user_id = users.id
            WHERE selector = :selector AND
                expiry > now()
            LIMIT 1", [':selector' => $tokens[0]]);


    }

    public function tokenIsValid(string $token, string $table): bool
    {
        [$selector, $validator] = $this->parseToken($token);

        $tokens = $this->findUserTokenBySelector($selector, $table);

        if (!$tokens) {
            return false;
        }

        return password_verify($validator, $tokens[0]['hashed_validator']);


    }


    public function rememberMe(int $userId, int $day = 30)
    {
        [$selector, $validator, $token] = $this->generateTokens();

        $this->deleteUserToken($userId, 'usertokens');

        $expired_seconds = time() + 60 * 60 * 24 * $day;

        $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', $expired_seconds);

        if($this->insertUserToken('usertokens', $userId, $selector, $hash_validator, $expiry)) {
            setcookie('remember_me', $token, $expired_seconds, "/");
        }

    }

    //Password reset functionality

    public function sendPasswordResetCode(string $email, string $resetCode)
    {
        $resetLink = PATH . "/user/password-reset-auth?email=$email&reset_code=$resetCode";

        EmailSender::sendEmail($email,'Pronajemonline.cz - Změna hesla', 'user_passwordreset', compact('resetLink'));

    }



    public function insertResetPasswordToken(int $userId, string $selector, string $validator, int $minutes = 60) : bool
    {

        $expired_seconds = time() + 60 * $minutes;

        $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', $expired_seconds);

        if($this->insertUserToken('usertokensreset', $userId, $selector, $hash_validator, $expiry)) {

            return true;

        }

        return false;

    }


    public function verifyResetToken(string $token) : ?array {

        if($token && $this->tokenIsValid($token, 'usertokensreset')){

            return $this->findUserByToken($token,'usertokensreset');

        }

        return null;

    }


    public function changePassword(int $userId, string $newPassword)
    {
        $user = R::findOne('users', 'id = ?', [$userId]);

        if (count($user)) {
            $user->password = password_hash($newPassword, PASSWORD_BCRYPT);
            return R::store($user);
        } else {
            return false;
        }

    }

    public function findUserById(int $userId){

        $user = R::findOne('users', 'id = ?', [$userId]);
        if(count($user)){
            return $user;
        }
        return null;

    }












}