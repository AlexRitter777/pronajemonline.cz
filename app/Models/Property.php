<?php

namespace app\Models;

use app\Support\AppModel;
use pronajem\libs\PaginationSetParams;

class Property extends AppModel
{

    public function __construct(PaginationSetParams $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }

    public function getPropertyList(int $userId = null) : array
    {

        $properties = $this->getAllRecords($userId);

        if(!$properties) return [];

        $propertyList = [];

        foreach($properties as $property) {
            $propertyList[$property->id] = $property->address;
        }

        return $propertyList;
    }



}