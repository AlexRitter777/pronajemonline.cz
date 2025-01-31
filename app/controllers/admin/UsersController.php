<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Users;
use DI\Attribute\Inject;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R;

class UsersController extends AppController
{
    #[Inject]
    private Users $users;

    #[Inject]
    private PaginationSetParams $pagination;


    public function __construct($route)
    {

        parent::__construct($route);

        $this->layout = 'admin';

        if(!is_admin()){
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

    }

    public function indexAction(){


        $this->setMeta('Uživatelé', 'Seznam uživatelů');

        $users = $this->users->getAllRecordsWithPagination(15);

        $pagination = $this->pagination;

        $this->set(compact('users',  'pagination'));

    }


    public function profileAction(){

        $userId = $_GET['user_id'];

        $user = $this->users->getOneRecordById($userId);

        $this->set(compact('user'));

    }


}