<?php

namespace app\services\Person;

use app\Exceptions\RecordNotUpdatedException;

class UpdatePersonService
{



    public function update(object $data, object $person, object $model): string
    {
        //for more entities we need to create dto with getters and interface
        $personId = $model->updateAll([
            'name' => $data->name,
            'address' => $data->address,
            'phone_number' => $data->phone,
            'email' => $data->email,
            'account' => $data->account,
        ], $person);

        if(!$personId){
            throw new RecordNotUpdatedException();
        }

        return $personId;

    }


}