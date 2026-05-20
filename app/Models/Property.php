<?php

namespace app\Models;

use app\Support\AppModel;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;

class Property extends AppModel
{

    public function __construct(PaginationSetParams $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }



}