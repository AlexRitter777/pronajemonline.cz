<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Admin;
use app\db_models\Property;
use app\models\User;
use DI\Attribute\Inject;
use pronajem\libs\PaginationSetParams;

class AdminsController extends AppController
{

    #[Inject]
    private Admin $admin;

    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private User $user;

    #[Inject]
    private Property $property;


    public function __construct($route)
    {

        parent::__construct($route);

        $this->layout = 'admin';

        if(!is_admin()){
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

    }


    public function indexAction(){

        $this->setMeta('Správci', 'Seznam správců');

        $admins = $this->admin->getAllRecordsWithPagination(8);

        $user = $this->user;

        $pagination = $this->pagination;

        $this->set(compact('admins', 'user', 'pagination'));

    }

    public function profileAction(){

        if(isset($_GET['admin_id'])){

            $adminId = $_GET['admin_id'];

            $admin = $this->admin->getOneRecordById($adminId);

            if ($admin) {

                $propertyList = $this->property->getAllRecordsByColumn('admin_id', $adminId);
                $user = $this->user->findUserById($admin->user_id);
                $this->setMeta($admin->name, 'Profil správce');
                $this->set(compact('admin', 'propertyList', 'user'));

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít správce!';
                redirect('/user/error');
            }

        }else {

            redirect('/admin/admins');

        }


    }




}