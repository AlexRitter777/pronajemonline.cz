<?php

namespace app\db_models;

use app\models\AppModel;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;

class Admin extends AppModel
{


    public function __construct(PaginationSetParams $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }



}