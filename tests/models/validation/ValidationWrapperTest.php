<?php

use app\models\validation\ValidationWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidationWrapperTest
 * Tests for the ValidationWrapper class.
 */
class ValidationWrapperTest extends TestCase
{

    /**
     * Tests successful validation for the registration form.
     */
    public function testValidateRegisterSuccess()
    {
        $data = [
                    'userName' => 'Test test',
                    'userEmail' => 'test@test.fu',
                    'userPassword' => 'Password',
                    'userPasswordRepeat' => 'Password'
                 ];

        // Call validate, check result
        $result = ValidationWrapper::validate('validateRegister', $data, true);
        $this->assertTrue($result);

        // Check, if errors array is empty
        $errors = ValidationWrapper::getErrors();
        $this->assertEmpty($errors);
    }

    /**
     * Tests validation for the registration form with missing user name.
     */
    public function testValidateRegisterMissingUserName()
    {
        // initial data
        $data = [
            'userName' => '',
            'userEmail' => 'test@test.fu',
            'userPassword' => 'Password',
            'userPasswordRepeat' => 'Password'
        ];
        // Call validate, check result
        $result = ValidationWrapper::validate('validateRegister', $data, true);
        $this->assertFalse($result);

        // Check, if errors array is not empty
        $errors = ValidationWrapper::getErrors();
        $this->assertArrayHasKey('userName', $errors);
        $this->assertEquals('"Jméno uživatele" je povinný údaj!', $errors['userName']);
    }


    /**
     * Tests validation for the registration form with missing email.
     */
    public function testValidateRegisterMissingEmail()
    {
        // initial data
        $data = [
            'userName' => 'Test test',
            'userEmail' => '',
            'userPassword' => 'Password',
            'userPasswordRepeat' => 'Password'
        ];
        // Call validate, check result
        $result = ValidationWrapper::validate('validateRegister', $data, true);
        $this->assertFalse($result);

        // Check, if errors array is not empty
        $errors = ValidationWrapper::getErrors();
        $this->assertArrayHasKey('userEmail', $errors);
        $this->assertEquals('"E-mailová adresa" je povinný údaj!', $errors['userEmail']);
    }


    /**
     * Tests validation for the registration form with mismatched passwords.
     */
    public function testValidateRegisterDiffPasswords()
    {
        // initial data
        $data = [
            'userName' => 'Test test',
            'userEmail' => 'test@emai.com',
            'userPassword' => 'Password1',
            'userPasswordRepeat' => 'Password2'
        ];
        // Call validate, check result
        $result = ValidationWrapper::validate('validateRegister', $data, true);
        $this->assertFalse($result);

        // Check, if errors array is not empty
        $errors = ValidationWrapper::getErrors();
        $this->assertArrayHasKey('comparePasswords', $errors);
    }

    /**
     * Tests successful validation for the contact form.
     */
    public function testValidateContactSuccess()
    {
        $data = [
            'contactName' => 'Test test',
            'contactEmail' => 'test@test.fu',
            'contactMessage' => 'Password',

        ];

        // Call validate, check result
        $result = ValidationWrapper::validate('validateContact', $data, true);
        $this->assertTrue($result);

        // Check, if errors array is empty
        $errors = ValidationWrapper::getErrors();
        $this->assertEmpty($errors);
    }

    /**
     * Tests validation for the contact form with missing name.
     */
    public function testValidateRegisterMissingContactName()
    {
        // initial data
        $data = [
            'contactName' => '',
            'contactEmail' => 'test@test.fu',
            'contactMessage' => 'Password',
        ];
        // Call validate, check result
        $result = ValidationWrapper::validate('validateContact', $data, true);
        $this->assertFalse($result);

        // Check, if errors array is not empty
        $errors = ValidationWrapper::getErrors();
        $this->assertArrayHasKey('contactName', $errors);

    }

}