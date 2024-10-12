<?php

namespace app\models\validation;

use app\models\validation\Validation;

class ValidationWrapper {

    /**
     * Contains the accumulated validation errors after calling the validate method.
     * Each key in the array corresponds to a field that failed validation, with the value
     * being the error message associated with that field. This array is reset each time
     * getErrors is called, ensuring that only relevant errors are returned for each validation attempt.
     */
    //private static $errors = [];


    /**
     * Validates data using the specified validation method of the Validation model.
     * This method dynamically calls the specified validation method on the Validation model,
     * passes the data to it, and handles the result. If validation fails, errors can be optionally
     * saved to a static property for later retrieval.
     *
     * @param string $validationMethod The name of the validation method to invoke. This method should exist in the Validation model.
     * @param array $data The data to be validated. This array should match the expected format of the specified validation method.
     * @param bool $saveErrors Optional. If true, validation errors will be stored in the static $errors property. Defaults to false.
     * @return bool Returns true if validation passes (i.e., no errors), false otherwise.
     * @throws \Exception Throws an exception if the specified validation method does not exist in the Validation model.
     */
    public static function validate(string $validationMethod, array $data, bool $saveErrors = false) : bool {

        $validation = new Validation();

        if (!method_exists($validation, $validationMethod)) {
            throw new \Exception("Method '{$validationMethod}' is not found.");
        }

        $validation->load($data);


        $validation->$validationMethod();

        if(!$validation->data['success']){
            if($saveErrors) {
                $_SESSION['errors'] = $validation->data['errors'];

                foreach ($data as $key => $value){
                    $_SESSION['old_data'][$key] = $value;
                }

            }

            return false;
        }

        return true;

    }




    /**
     * Returns errors and clears the stored errors.
     */
    public static function getValidationResult() {

        $result = [];

        if(isset($_SESSION['errors'])){

            $result['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);

            if(isset($_SESSION['old_data'])){
                foreach ($_SESSION['old_data'] as $key => $value){
                    $result['old_data'][$key] = $value;
                }
                unset($_SESSION['old_data']);
            }

        return $result;

        }

        return false;


    }


}