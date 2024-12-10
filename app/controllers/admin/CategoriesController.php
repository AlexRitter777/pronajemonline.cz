<?php

namespace app\controllers\admin;


use app\controllers\AppController;
use app\db_models\Category;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;
use pronajem\libs\Slugger;

class CategoriesController extends AppController
{
#[Inject]
private Category $category;

#[Inject]
private PaginationSetParams $pagination;

#[Inject]
private Slugger $slugger;


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

        $this->setMeta('Sprava kategorií', 'Sprava kategorií');

        $categories = $this->category->getAllRecordsWithPagination(10);

        $pagination = $this->pagination;

        $tokenInput = CSRF::createCsrfInput();

        $this->set(compact('categories', 'pagination', 'tokenInput'));

    }

    public function editAction()
    {

        if (!isset($_GET['category_id'])) {
            redirect('admin/categories');
        }

        $errors = null;
        $oldData = null;
        $categoryId = $_GET['category_id'];

        $validationResult = ValidationWrapper::getValidationResult();

        if ($validationResult) {
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }

        $category = $this->category->getOneRecordById($categoryId);

        if(!$category){
            $this->showRecordNotFoundError('categorie', true);
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($category->title, 'Editace kategorie');
        $this->set(compact('category', 'errors', 'oldData', 'tokenInput'));

    }


    public function updateAction()
    {

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_GET['category_id'])) {
            redirect('admin/categories');
        }

        $categoryId = $_GET['category_id'];

        if (
            !isset($_POST['category_title'])
        ) {
            redirect('admin/categories');
        }

        $categoryTitle = $_POST['category_title'];

        $dataForValidation = [
            'category_title' => $categoryTitle,
            'category_id' => $categoryId
        ];

        if (!ValidationWrapper::validate('validateCategory', $dataForValidation, true, true)) {
            redirect();
        }

        $category = $this->category->getOneRecordById($categoryId);

        if ($category) {
            if (!$this->category->upadateAll([
                'title' => $categoryTitle,
                'updated_at' => date('Y-m-d H:i:s'),
            ],
                $category)) {
                throw new Exception('Chyba zápisu do DB!');
            }
            flash('success', 'Category was updated!', 'success');
            redirect('edit?category_id=' . $categoryId);
        } else {
            $this->showRecordNotFoundError('kategorie', true);
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

        $this->setMeta('Nová kategorie', 'Nová kategorie');
        $tokenInput = CSRF::createCsrfInput();
        $this->set(compact('tokenInput', 'errors', 'oldData'));

    }

    public function saveAction(){
        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if(!isset($_POST['category_title'])){
            redirect('admin/categories');
        }

        $categoryTitle = $_POST['category_title'];

        $dataForValidation = [
            'category_title' => $categoryTitle
        ];

        if(!ValidationWrapper::validate('validateCategory', $dataForValidation, true)){
            redirect();
        }

        $categorySlug = $this->slugger->createSlug($categoryTitle, Category::class);

        if(!$this->category->saveAll([
            'title' => $categoryTitle,
            'slug' => $categorySlug,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])) {
            throw new Exception('Chyba zápisu do DB!');
        }
        flash('success', 'Category was created!', 'success');
        redirect('/admin/categories');

    }

    public function deleteAction(){

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_GET['category_id']))
        {
            redirect('admin/categories');
        }

        $categoryId = $_GET['category_id'];

        $deleteResult = $this->category->deleteOneRecordbyId($categoryId);

        if ($deleteResult) {
            flash('success', 'Category was deleted!', 'success');
            redirect();
        } else {
            $this->showRecordNotFoundError('kategorie', true);
        }
    }



}