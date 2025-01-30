<?php

namespace app\db_models;

use app\models\AppModel;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R as R;

class Upload extends AppModel
{

    public function __construct(PaginationSetParams $pagination)
    {
        $this->pagination = $pagination;
        parent::__construct($pagination);
    }





}