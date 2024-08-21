<?php

namespace app\db_models;

use app\models\AppModel;
use pronajem\libs\Pagination;

class Property extends AppModel
{

    public function __construct(Pagination $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }


}