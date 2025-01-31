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

    public function getAllFiles(int $perPage){
        if(!$this->pagination) throw new \Exception('Pagination Model is not found', 404);

        $total = R::count($this->table);

        $this->pagination->setPaginationParams($perPage, $total);

        $start = $this->pagination->getStart();

        return R::FindAll($this->table, "ORDER BY created_at DESC LIMIT ?, ?", [$start, $perPage]);
    }



}