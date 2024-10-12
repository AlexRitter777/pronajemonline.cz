<?php

namespace app\models;

use RedBeanPHP\R;

class Admin
{

    /**
     *
     * @return bool
     */
    public function isUserAdmin() : bool
    {

        if(!isset($_SESSION['user_id'])){

            return false;

        }

        $userId = $_SESSION['user_id'];

        $user = R::findOne( 'users', ' id = ? ', [ $userId ] );


        return (bool)$user->is_admin;

    }


}