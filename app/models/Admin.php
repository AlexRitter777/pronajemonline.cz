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

        $userId =  $_SESSION['user_id'];

        if(!$userId) return false;

        $user = R::findOne( 'users', ' id = ? ', [ $userId ] );

        return (bool)$user->is_admin;

    }


}