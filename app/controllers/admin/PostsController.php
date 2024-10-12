<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Post;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;

class PostsController extends AppController
{

    #[Inject]
    private Post $post;

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

        $this->setMeta('Sprava članků', 'Sprava članků');

        $posts = $this->post->getAllRecordsWithPagination(8);

        $pagination = $this->pagination;

        $this->set(compact('posts', 'pagination'));


    }

    public function editAction(){

        if(!isset($_GET['post_id'])){

            redirect('admin/posts');
        }

        $errors = null;
        $oldData = null;

        $postId = $_GET['post_id'];

        $validationResult = ValidationWrapper::getValidationResult();

        if($validationResult){
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }

        $post = $this->post->getOneRecordById($postId);

        if(!$post) throw new \Exception('Post has not found!', 404);

        $tokenInput = CSRF::crateCsrfInput();

        $this->setMeta($post->title , 'Editace članků');

        $this->set(compact('post', 'errors', 'oldData', 'tokenInput'));

    }

    public function updateAction(){

        if(!isset($_GET['post_id'])){

            redirect('admin/posts');
        }

        $postId = $_GET['post_id'];


        if(
           !isset($_POST['post_title']) ||
           !isset($_POST['post_description']) ||
           !isset($_POST['post_content']) ||
           !isset($_POST['token'])
        ){
            redirect('admin/posts');
        }

        $postTitle =  $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $token = $_POST['token'];

        if(!CSRF::checkCsrfToken($token)) {
            throw new Exception('Method not allowed', 405);
        };

        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' =>  $postContent
        ];

        if(!ValidationWrapper::validate('validatePost', $dataForValidation,true, true)){

            redirect();

        }

        $post = $this->post->getOneRecordById($postId);

        if($post){

            if(!$this->post->upadateAll(['title' => $postTitle,
                                        'description' => $postDescription,
                                        'content' =>  $postContent],
                                        $post))
            {
                throw new Exception('Chyba zápisu do DB!');
            }
            flash('success', 'Post was updated!', 'success');
            redirect('edit?post_id=' . $postId);

        } else {
            //new error page for admin
            $_SESSION['admin_error'] = 'Nepodařilo se najít članek!';
            redirect('/admin/error');
        }

    }

    public function createAction(){
        $errors = null;
        $oldData = null;

        $validationResult = ValidationWrapper::getValidationResult();

        if($validationResult){
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }
        $this->setMeta('Nový članek', 'Nový članek');
        $tokenInput = CSRF::crateCsrfInput();
        $this->set(compact('tokenInput', 'errors', 'oldData'));

    }

    public function saveAction(){

        if(
            !isset($_POST['post_title']) ||
            !isset($_POST['post_description']) ||
            !isset($_POST['post_content']) ||
            !isset($_POST['token'])
        ){
            redirect('admin/posts');
        }

        $postTitle =  $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $token = $_POST['token'];

        if(!CSRF::checkCsrfToken($token)) {
            throw new Exception('Method not allowed', 405);
        };

        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' =>  $postContent
        ];

        if(!ValidationWrapper::validate('validatePost', $dataForValidation,true, true)){

            redirect();

        }

        if(!$this->post->saveAll([
                            'title' => $postTitle,
                            'description' => $postDescription,
                            'content' =>  $postContent
                            ])
        )
        {
            throw new Exception('Chyba zápisu do DB!');
        }
        flash('success', 'Post was created!', 'success');
        redirect('/posts');

    }

}