<?php

namespace app\controllers\admin;


use app\controllers\AppController;
use app\db_models\Category;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;

class CategoriesController extends AppController
{
#[Inject]
private Category $category;

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



}