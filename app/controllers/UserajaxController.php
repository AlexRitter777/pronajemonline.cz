<?php

namespace app\controllers;

use app\models\User;


class UserajaxController extends AppController
{

    public function checkuserAction(){

        $email = $_POST['email'];

        $result = null;

        if(!empty($email)){

            if (filter_var($email, FILTER_VALIDATE_EMAIL)){

                $user = new User();

                    if($user->isUserExist($email) && $user->isUserActiveByEmail($email)){

                        $result = "User with email $email  is already exists!";


                    }

            }

        }

        echo json_encode($result);

        die();

    }

}