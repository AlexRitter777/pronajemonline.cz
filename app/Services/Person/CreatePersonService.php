<?php

namespace app\Services\Person;

use app\Exceptions\RecordNotCreatedException;

class CreatePersonService
{

    public function create(object $data, object $model, string $userId) : string
    {
        // for more entities better to have interfaces for models (saveAll)  and dto with getters
        $personId = $model->saveAll([
            'name' => $data->name,
            'address' => $data->address,
            'phone_number' => $data->phone,
            'email' => $data->email,
            'account' => $data->account,
            'user_id' => $userId
        ]);

        if(!$personId){
            throw new RecordNotCreatedException();
        }

        return $personId;

    }

}