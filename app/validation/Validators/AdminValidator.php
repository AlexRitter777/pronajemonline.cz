<?php

namespace app\validation\Validators;

use app\validation\Core\ErrorBag;
use app\validation\Core\RedirectOnFailValidator;
use app\validation\Core\Validator;
use app\validation\Rules\CharRule;
use app\validation\Rules\EmailRule;
use app\validation\Rules\MaxLengthRule;
use app\validation\Rules\MinLengthRule;
use app\validation\Rules\PhoneRule;
use app\validation\Rules\RequiredRule;

class AdminValidator
{
    public function __construct(private ErrorBag $errorBag)
    {
    }

    public function validate(array $data): ?array
    {
        $rules = [
            'admin_name' => [
                new RequiredRule(),
                new MaxLengthRule(70),
                new MinLengthRule(3),
                new CharRule(),
            ],
            'admin_phone' => [
                new PhoneRule(),
            ],
            'admin_email' => [
                new MaxLengthRule(50),
                new MinLengthRule(5),
                new EmailRule(),
            ],
            'admin_tech_name' => [
                new MaxLengthRule(70),
                new CharRule(),
            ],
            'admin_tech_phone' => [
                new PhoneRule(),
            ],
            'admin_tech_email' => [
                new MaxLengthRule(50),
                new MinLengthRule(5),
                new EmailRule(),
            ],
            'admin_acc_name' => [
                new MaxLengthRule(70),
                new CharRule(),
            ],
            'admin_acc_phone' => [
                new PhoneRule(),
            ],
            'admin_acc_email' => [
                new MaxLengthRule(50),
                new MinLengthRule(5),
                new EmailRule(),
            ],
        ];

        $attributeNames = [
            'admin_name' => 'Název správce',
            'admin_phone' => 'Telefon správce',
            'admin_email' => 'E-mail správce',
            'admin_tech_name' => 'Jméno technika',
            'admin_tech_phone' => 'Telefon technika',
            'admin_tech_email' => 'E-mail technika',
            'admin_acc_name' => 'Jméno účetní',
            'admin_acc_phone' => 'Telefon účetní',
            'admin_acc_email' => 'E-mail účetní',
        ];

        $validator = new Validator($rules, $attributeNames);
        $decorator = new RedirectOnFailValidator($validator, $this->errorBag);

        return $decorator->validate($data);
    }
}
