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
            'tenant_name' => 'Jméno pronajímatele',
            'tenant_email' => 'Email pronajímatele',
            'tenant_phone_number' => 'Telefonní číslo pronajímatele',
            'tenant_address' => 'Adresa pronajímatele',
            'tenant_account' => 'Číslo účtu pronajímatele',
        ];

        $validator = new Validator($rules, $attributeNames);
        $decorator = new RedirectOnFailValidator($validator, $this->errorBag);

        return $decorator->validate($data);


    }
}