<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use pronajem\libs\Pagination;
use RedBeanPHP\R;

class UsersController extends AppController
{


    public function indexAction(){

        if(!is_admin()){
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

        $this->setMeta('Uživatelé', 'Seznam uživatelů');

        $this->layout = 'account';

        //set pagination
        $total = R::count('users');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $users = R::findAll('users', "LIMIT $start, $perpage");

        $this->set(compact('users',  'pagination', 'total'));

    }


}