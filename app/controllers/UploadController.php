<?php

namespace app\controllers;

use app\db_models\Upload;
use DI\Attribute\Inject;
use pronajem\libs\PaginationSetParams;

class UploadController extends AppController
{
    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private Upload $upload;

    public function indexAction() {

        $this->setMeta('Návody', 'Návody k naším aplikacím');

        $files = $this->upload->getAllFiles(10);

        $pagination = $this->pagination;

        $this->set(compact('files', 'pagination'));


    }


}