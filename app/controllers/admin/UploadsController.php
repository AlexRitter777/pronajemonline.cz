<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\db_models\Upload;
use app\models\validation\ValidationWrapper;
use DI\Attribute\Inject;
use Exception;
use pronajem\libs\CSRF;
use pronajem\libs\PaginationSetParams;

class UploadsController extends AppController
{

    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private Upload $upload;

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

        $this->setMeta('Soubory', 'Správa souborů');

        $errors = null;
        $oldData = null;

        $validationResult = ValidationWrapper::getValidationResult();

        if ($validationResult) {
            $errors = $validationResult['errors'];
            $oldData = $validationResult['old_data'];
        }

        $files = $this->upload->getAllRecordsWithPagination(10);

        $tokenInput = CSRF::createCsrfInput();

        $pagination = $this->pagination;

        $this->set(compact('files', 'pagination', 'tokenInput', 'errors', 'oldData'));

    }

    public function uploadAction()
    {
        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_POST['file_description']) || !isset($_FILES['file_file']['name'])) {
            redirect('/admin/uploads');
        }

        $fileDescription = $_POST['file_description'];
        $fileName = $_FILES['file_file']['name'];
        $file = $_FILES['file_file'];

        $dataForValidation = [
            'file_description' => $fileDescription,
            'file_file' => $file,
            'file_name' => $fileName,
        ];


        if (!ValidationWrapper::validate('validateUpload', $dataForValidation, true)) {
            redirect();
        }

        $filePath = $this->upload->uploadFile($file,'/uploaded_files/');
        if(!$filePath){
            flash('error', "Chyba zápisu souboru!", 'error');
            redirect('/admin/uploads');
        }
        $publicUrl = strstr($filePath, 'uploaded_files');

        $fileId = $this->upload->saveAll([
            'description' => $fileDescription,
            'file_name' => $fileName,
            'path' => $publicUrl,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        if (!$fileId) {
            throw new Exception('Chyba zápisu do DB!');
        }
        flash('success', "File was uploaded!", 'success');
        redirect("/admin/uploads");

    }

    public function deleteAction(){

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            throw new Exception('Method Not Allowed', 405);
        }

        if (!isset($_GET['file_id']))
        {
            redirect();
        }

        $fileId = $_GET['file_id'];
        $file = $this->upload->getOneRecordById($fileId);

        $filePath = $file->path;

        $fileDeleteResult = $this->upload->deleteFile($filePath);

        if (!$fileDeleteResult) {
            flash('error', "File does not exist or can't be deleted!", 'error');
            redirect();
        }

        $deleteResult = $this->upload->deleteOneRecordbyId($fileId);

        if ($deleteResult) {
            flash('success', 'File was deleted!', 'success');
            redirect();
        } else {
            $this->showRecordNotFoundError('soubor', true);
        }

    }

}