<?php

use app\models\validation\Validation;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{

    public function testValidateOlnAdnNewPasswordsSuccess(){

        $data = [
            'userPasswordOld' => 'Password1',
            'userPasswordNew' => 'Password2',
        ];

        $validation = new Validation();
        $validation->load($data);
        $validation->validateNewAndOldPassword();
        $this->assertTrue($validation->data['success']);

    }

    public function testValidateOlnAdnNewPasswordsFailure(){

        $data = [
            'userPasswordOld' => 'Password',
            'userPasswordNew' => 'Password',
        ];

        $validation = new Validation();
        $validation->load($data);
        $validation->validateNewAndOldPassword();
        $this->assertFalse($validation->data['success']);
        $this->assertArrayHasKey('oldAndNewPasswords', $validation->data['errors']);

    }


}