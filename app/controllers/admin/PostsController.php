<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Category;
use app\db_models\Post;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;
use pronajem\libs\Slugger;

class PostsController extends AppController
{

    #[Inject]
    private Post $post;

    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private Slugger $slugger;

    #[Inject]
    private Category $category;



    public function __construct($route)
    {

        parent::__construct($route);

        $this->layout = 'admin';

        if (!is_admin()) {
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

    }


    public function indexAction()
    {

        $this->setMeta('Sprava članků', 'Sprava članků');

        $posts = $this->post->getAllRecordsWithPagination(10);

        $pagination = $this->pagination;

        $tokenInput = CSRF::createCsrfInput();

        $this->set(compact('posts', 'pagination', 'tokenInput'));


    }

    public function editAction()
    {


        if (!isset($_GET['post_id'])) {
            redirect('admin/posts');
        }

        $errors = null;
        $oldData = null;
        $postId = $_GET['post_id'];

        $validationResult = ValidationWrapper::getValidationResult();

        if ($validationResult) {
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }

        $post = $this->post->getOneRecordById($postId);

        if(!$post){
            $this->showRecordNotFoundError('članek', true);
        }

        $categories = $this->category->getAllRecords();

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($post->title, 'Editace članků');
        $this->set(compact('post', 'errors', 'oldData', 'tokenInput', 'categories'));

    }

    public function updateAction()
    {


        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_GET['post_id'])) {
            redirect('admin/posts');
        }

        $postId = $_GET['post_id'];

        if (
            !isset($_POST['post_title']) ||
            !isset($_POST['post_description']) ||
            !isset($_POST['post_content']) ||
            !isset($_POST['post_category']) ||
            !isset($_POST['old_post_image']) ||
            !isset($_POST['post_published'])
        ) {
            redirect('admin/posts');
        }

        $postTitle = $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $postCategoryId = $_POST['post_category'];
        $postPublished = $_POST['post_published'];
        $oldPostImage = $_POST['old_post_image'];
        $postImage = $_FILES['post_image'];


        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' => $postContent,
            'post_category' => $postCategoryId,
            'is_published' => $postPublished
        ];

        if (!ValidationWrapper::validate('validatePost', $dataForValidation, true, true)) {
            redirect();
        }

        $post = $this->post->getOneRecordById($postId);

        $postCategory = $this->category->getOneRecordById($postCategoryId);

        $updateCondition = [
            'title' => $postTitle,
            'description' => $postDescription,
            'content' => $postContent,
            'category' => $postCategory,
            'is_published' => $postPublished,
            'updated_at' => date('Y-m-d H:i:s'),
        ];



        if($postImage['error'] == 0){
            if($post->thumbnail){
                $this->post->deleteImage($post->thumbnail);
            }
            $updateCondition['thumbnail'] = $this->post->uploadImage($postImage);
        } else {
            if($post->thumbnail && !$oldPostImage){
                $this->post->deleteImage($post->thumbnail);
                $updateCondition['thumbnail'] = null;
            }
        }


        if ($post) {
            if (!$this->post->upadateAll(
                    $updateCondition,
                $post)) {
                throw new Exception('Chyba zápisu do DB!');
            }
            flash('success', 'Post was updated!', 'success');
            redirect('edit?post_id=' . $postId);
        } else {
            $this->showRecordNotFoundError('članek', true);
        }

    }

    public function createAction()
    {
        $errors = null;
        $oldData = null;

        $validationResult = ValidationWrapper::getValidationResult();

        if ($validationResult) {
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }
        $this->setMeta('Nový članek', 'Nový članek');
        $categories = $this->category->getAllRecords();
        $tokenInput = CSRF::createCsrfInput();
        $this->set(compact('tokenInput', 'errors', 'oldData', 'categories'));

    }

    public function saveAction()
    {
        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (
            !isset($_POST['post_title']) ||
            !isset($_POST['post_description']) ||
            !isset($_POST['post_content']) ||
            !isset($_POST['post_category']) ||
            !isset($_POST['post_published'])
        ) {
            redirect('/admin/posts');
        }

        $postTitle = $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $postCategoryId = $_POST['post_category'];
        $postPublished = $_POST['post_published'];
        $postImage = $_FILES['post_image'];


        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' => $postContent,
            'post_category' => $postCategoryId,
            'post_image' =>$postImage
        ];

        if (!ValidationWrapper::validate('validatePost', $dataForValidation, true, true)) {
            redirect();
        }

        $postSlug = $this->slugger->createSlug($postTitle, Post::class);

        $postCategory = $this->category->getOneRecordById($postCategoryId);

        $imageUrl = $this->post->uploadImage($postImage);

        $postId = $this->post->saveAll([
            'title' => $postTitle,
            'slug' => $postSlug,
            'description' => $postDescription,
            'content' => $postContent,
            'category' => $postCategory,
            'is_published' => $postPublished,
            'thumbnail' => $imageUrl,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);


        if (!$postId) {
            throw new Exception('Chyba zápisu do DB!');
        }
        flash('success', "Post was created!", 'success');
        redirect("/admin/posts/edit?post_id=$postId");

    }


    public function previewAction(){

        if (!isset($_GET['post_id'])) {
            redirect('admin/posts');
        }

        $this->layout = 'pronajem';

        $postId = $_GET['post_id'];

        $post = $this->post->getOneRecordById($postId);

        if(!$post){
            $this->showRecordNotFoundError('članek', true);
        }

        $this->setMeta($post->title, 'Nahled članků');
        $this->set(compact('post'));

    }

    public function deleteAction(){


        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_GET['post_id']))
        {
            redirect('admin/posts');
        }

        $postId = $_GET['post_id'];
        $post = $this->post->getOneRecordById($postId);
        $postThumbnail =  $post->thumbnail;
        $this->post->deleteAllPostImages($postId);
        $this->post->deleteImage($postThumbnail);

        $deleteResult = $this->post->deleteOneRecordbyId($postId);

        if ($deleteResult) {
            flash('success', 'Post was deleted!', 'success');
            redirect();
        } else {
            $this->showRecordNotFoundError('članek', true);
        }


    }




    /**
     * Handles the image upload process via AJAX.
     *
     * This method processes image files received through an AJAX POST request.
     * It verifies the request type, checks CSRF tokens, creates the upload directory
     * if needed, and saves the images with unique filenames. In case of any errors,
     * appropriate HTTP status codes and JSON responses are returned.
     *
     * @throws Exception If the request is not an AJAX request or not sent with POST method.
     * @return void JSON response containing file paths or error messages.
     */
    public function saveimageAction()
    {
        $this->validateHttpRequest();

        if(!CSRF::checkCsrfToken($_POST['token'], true)){
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden.']);
            exit();
        }

        $folder = date('Y-m-d');
        $uploadDir = WWW . "/uploads/{$folder}/";
        $defaultImage = 'img/default-blog-image.webp';
        $response = [];

        // Create the upload directory if it does not exist
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create upload directory.']);
            exit();
        }

        if(!empty($_FILES)) {
            foreach ($_FILES as $index => $file) {
                $fileName = basename($file['name']);
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                // Add a unique identifier to the file name to avoid overwrites
                $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $fileExtension;
                $uploadFilePath = $uploadDir . $uniqueFileName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                    $relativePath = strstr($uploadFilePath, 'uploads');
                    $response[$index] = $relativePath;
                } else {
                    $response[$index] = $defaultImage;
                }
            }
            echo json_encode($response);
            exit();
        }
        http_response_code(500);
        echo json_encode(['error' => 'Data has not received.']);
        exit();

    }


    /**
     * Deletes specified images from the server based on provided links.
     *
     * @throws Exception If the HTTP request or CSRF token is invalid.
     * @return void JSON response containing file paths or error messages.
     */
    public function deleteImagesAction(){

        $this->validateHttpRequest();

        if(!CSRF::checkCsrfToken($_POST['token'], true)){
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden.']);
            exit();
        }

        $errors = 0;

        if(!empty($_POST['links'])){

            $links = $_POST['links'];
            foreach ($links as $link){
                $imageFile = WWW . '/' . $link;
                if(file_exists($imageFile)) {
                    try {
                        if (!unlink($imageFile)) {
                            $errors++;
                            throw new Exception("Image $link was not deleted");
                        }
                    }catch (Exception $e){
                        logErrors($e->getMessage(), $e->getFile(), $e->getLine());
                    }
                }
            }

            if($errors>0){
                echo json_encode(['success' => 'true', 'message' => 'Some images were not deleted.']);
                exit();
            }

            echo json_encode(['success' => 'true', 'message' => 'All images were deleted.']);
            exit();
        }

        echo json_encode(['success' => 'true', 'message' => 'Link were not received. No images were deleted.']);
        exit();

    }




}