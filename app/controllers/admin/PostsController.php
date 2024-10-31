<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Post;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;
use URLify;

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

        if (!is_admin()) {
            throw new \Exception('Stránka nebyla nalezena', 404);
        }

    }


    public function indexAction()
    {

        $this->setMeta('Sprava članků', 'Sprava članků');

        $posts = $this->post->getAllRecordsWithPagination(8);

        $pagination = $this->pagination;

        $this->set(compact('posts', 'pagination'));


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

        if (!$post) throw new \Exception('Post has not found!', 404);

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($post->title, 'Editace članků');

        $this->set(compact('post', 'errors', 'oldData', 'tokenInput'));

    }

    public function updateAction()
    {

        if (!isset($_GET['post_id'])) {

            redirect('admin/posts');
        }

        $postId = $_GET['post_id'];


        if (
            !isset($_POST['post_title']) ||
            !isset($_POST['post_description']) ||
            !isset($_POST['post_content']) ||
            !isset($_POST['token'])
        ) {
            redirect('admin/posts');
        }

        $postTitle = $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $token = $_POST['token'];

        if (!CSRF::checkCsrfToken($token)) {
            throw new Exception('Method not allowed', 405);
        };

        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' => $postContent
        ];

        if (!ValidationWrapper::validate('validatePost', $dataForValidation, true, true)) {

            redirect();

        }

        $post = $this->post->getOneRecordById($postId);

        if ($post) {


            if (!$this->post->upadateAll(['title' => $postTitle,
                'description' => $postDescription,
                'content' => $postContent,
                'updated_at' => date('Y-m-d H:i:s'),
            ],
                $post)) {
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
        $tokenInput = CSRF::createCsrfInput();
        $this->set(compact('tokenInput', 'errors', 'oldData'));

    }

    public function saveAction()
    {

        if (
            !isset($_POST['post_title']) ||
            !isset($_POST['post_description']) ||
            !isset($_POST['post_content']) ||
            !isset($_POST['token'])
        ) {
            redirect('admin/posts');
        }

        $postTitle = $_POST['post_title'];
        $postDescription = $_POST['post_description'];
        $postContent = $_POST['post_content'];
        $token = $_POST['token'];


        if (!CSRF::checkCsrfToken($token)) {
            throw new Exception('Method not allowed', 405);
        };

        $dataForValidation = [
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'post_content' => $postContent
        ];

        if (!ValidationWrapper::validate('validatePost', $dataForValidation, true, true)) {

            redirect();

        }

        $postSlug = URLify::slug($postTitle);

        if (!$this->post->saveAll([
            'title' => $postTitle,
            'slug' => $postSlug,
            'description' => $postDescription,
            'content' => $postContent,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])
        ) {
            throw new Exception('Chyba zápisu do DB!');
        }
        flash('success', 'Post was created!', 'success');
        redirect('/admin/posts');

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

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!CSRF::checkCsrfToken($_POST['token'], true)){
                    http_response_code(403);
                    echo json_encode(['error' => 'Forbidden.']);
                    exit();
                }

                $uploadDir = WWW . '/uploads/';
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
            http_response_code(404);
            echo json_encode(['error' => 'Page is not found']);
            exit();
        }

        throw new Exception('Page is not found', 404);
    }


    public function deleteImagesAction(){

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!CSRF::checkCsrfToken($_POST['token'], true)){
                    http_response_code(403);
                    echo json_encode(['error' => 'Forbidden.']);
                    exit();
                }

                $response = [];

                if(!empty($_POST['links'])){

                    $links = $_POST['links'];
                    foreach ($links as $link){

                        $imageFile = WWW . '/' . $link;

                        if(file_exists($imageFile)) {

                            try {
                                if (!unlink($imageFile)) {
                                    throw new Exception("Image $link was not deleted");
                                }
                            }catch (Exception $e){
                                logErrors($e->getMessage(), $e->getFile(), $e->getLine());
                            }

                        }
                    }

                    if(!empty($errors)){
                        $response['success'] = false;
                        echo json_encode($response);
                        exit();
                    }

                    $response['success'] = true;
                    echo json_encode($response);
                    exit();
                }

                echo json_encode(['success' => 'true', 'message' => 'No images were deleted.']);
                exit();


            }
            http_response_code(404);
            echo json_encode(['error' => 'Page is not found']);
            exit();
        }
        throw new Exception('Page is not found', 404);

    }




}