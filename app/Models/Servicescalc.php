<?php

namespace app\Models;

use pronajem\base\Model;
use pronajem\libs\PaginationSetParams;

class Servicescalc extends Model
{
    public function __construct(PaginationSetParams $pagination)
    {
        $this->pagination = $pagination;

        parent::__construct($pagination);
    }
}