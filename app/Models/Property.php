<?php

namespace app\Models;

use pronajem\base\Model;

class Property extends Model
{

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