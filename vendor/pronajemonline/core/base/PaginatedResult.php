<?php

namespace pronajem\base;

use pronajem\libs\Pagination;

final readonly class PaginatedResult
{ 
    
    public function __construct(
        public Pagination $pagination,
        public array $records
    ){
    }


    

}