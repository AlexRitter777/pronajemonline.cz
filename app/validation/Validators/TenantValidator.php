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
use app\validation\Rules\RegexRule;
use app\validation\Rules\RequiredRule;

class TenantValidator
{
    public function __construct(private ErrorBag $errorBag)
    {}
    public function validate(array $data): ?array
    {
        $rules = [
            'tenant_name' => [
                new RequiredRule(),
                new MaxLengthRule(50),
                new MinLengthRule(3),
                new CharRule(),
            ],
            'tenant_address' => [
                new RequiredRule(),
                new MaxLengthRule(100),
                new MinLengthRule(5),
                new CharRule(),
            ],
            'tenant_email' => [
                new MaxLengthRule(50),
                new MinLengthRule(5),
                new EmailRule(),
            ],
            'tenant_phone_number' => [
                new PhoneRule(),
            ],

            'tenant_account' => [
                new AccountRule(),
            ],
        ];

        $attributeNames = [
            'tenant_name' => 'Jméno nájemníka',
            'tenant_email' => 'Email nájemníka',
            'tenant_phone_number' => 'Telefonní číslo nájemníka',
            'tenant_address' => 'Adresa nájemníka',
            'tenant_account' => 'Číslo účtu nájemníka',
        ];

        $validator = new Validator($rules, $attributeNames);
        $decorator = new RedirectOnFailValidator($validator, $this->errorBag);

        return $decorator->validate($data);


    }




}