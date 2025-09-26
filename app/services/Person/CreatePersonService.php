<?php

namespace app\services\Person;

class CreatePersonService
{
    public function __construct(
        private object $model,
    )
    {}

    public function create(object $data, string $userId): string
    {
        //for more entities we need to create dto with getters and interface
        $personId = $this->model->saveAll([
            'name' => $data->name,
            'address' => $data->address,
            'phone_number' => $data->phone,
            'email' => $data->email,
            'account' => $data->account,
            'user_id' => $userId
        ]);

        if(!$personId){
            throw new \Exception('Chyba zápisu do DB!');
        }

        return $personId;

    }

}