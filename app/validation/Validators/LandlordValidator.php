<?php

namespace app\validation\Validators;

use app\validation\Core\ErrorBag;
use app\validation\Core\RedirectOnFailValidator;
use app\validation\Core\Validator;
use app\validation\Rules\AccountRule;
use app\validation\Rules\CharRule;
use app\validation\Rules\EmailRule;
use app\validation\Rules\MaxLengthRule;
use app\validation\Rules\MinLengthRule;
use app\validation\Rules\PhoneRule;
use app\validation\Rules\RequiredRule;

class LandlordValidator
{

    public function __construct(private ErrorBag $errorBag)
    {}
    public function validate(array $data): ?array
    {
        $rules = [
            'landlord_name' => [
                new RequiredRule(),
                new MaxLengthRule(50),
                new MinLengthRule(3),
                new CharRule(),
            ],
            'landlord_address' => [
                new RequiredRule(),
                new MaxLengthRule(100),
                new MinLengthRule(5),
                new CharRule(),
            ],
            'landlord_email' => [
                new MaxLengthRule(50),
                new MinLengthRule(5),
                new EmailRule(),
            ],
            'landlord_phone_number' => [
                new PhoneRule(),
            ],

            'landlord_account' => [
                new AccountRule(),
            ],
        ];

        $attributeNames = [
            'landlord_name' => 'Jméno pronajímatele',
            'landlord_email' => 'Email pronajímatele',
            'landlord_phone_number' => 'Telefonní číslo pronajímatele',
            'landlord_address' => 'Adresa pronajímatele',
            'landlord_account' => 'Číslo účtu pronajímatele',
        ];

        $validator = new Validator($rules, $attributeNames);
        $decorator = new RedirectOnFailValidator($validator, $this->errorBag);

        return $decorator->validate($data);


    }
}