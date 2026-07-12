<?php

namespace app\validation\Validators;

use app\validation\Core\ErrorBag;
use app\validation\Core\RedirectOnFailValidator;
use app\validation\Core\Validator;
use app\validation\Rules\CharRule;
use app\validation\Rules\MaxLengthRule;
use app\validation\Rules\MinLengthRule;
use app\validation\Rules\RequiredRule;

class ElsupplierValidator
{
    public function __construct(private ErrorBag $errorBag)
    {
    }

    public function validate(array $data): ?array
    {
        $rules = [
            'elsupplier_name' => [
                new RequiredRule(),
                new MaxLengthRule(70),
                new MinLengthRule(3),
                new CharRule(),
            ],
            'elsupplier_add_info' => [
                new MaxLengthRule(200),
                new CharRule(),
            ],
        ];

        $attributeNames = [
            'elsupplier_name' => 'Název dodavatele elektřiny',
            'elsupplier_add_info' => 'Informace',
        ];

        $validator = new Validator($rules, $attributeNames);
        $decorator = new RedirectOnFailValidator($validator, $this->errorBag);

        return $decorator->validate($data);
    }
}
