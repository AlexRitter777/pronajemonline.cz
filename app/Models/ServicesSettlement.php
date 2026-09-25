<?php

namespace app\Models;

use pronajem\base\Model;
use pronajem\libs\PaginationSetParams;

class ServicesSettlement extends Model
{
    protected $table = 'servicescalc';

    public function __construct(PaginationSetParams $pagination)
    {
        $this->pagination = $pagination;

        parent::__construct($pagination);
    }
}