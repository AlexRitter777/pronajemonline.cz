<?php

namespace app\models;

use Exception;

class Validationnew extends AppModel
{

    protected  $errors;
    protected  $data;
    protected  $result;
    protected  $rules;



    public function __construct($data, $rules){

        $this->data = $data;
        $this->rules = $rules;

    }

    /**
     * Returns protected array with validation data
     * Uses for testing and debugging
     *
     * @return array
     */
    public function getData() : array {
        return $this->data;
    }

    /**
     * Returns protected array with validation rules
     * Uses for testing and debugging
     *
     * @return array
     */
    public function getRules() : array {
        return $this->rules;
    }


    /**
     * Makes validation of client data from property $this->data based on validation rules from property $this->rules
     * Returns validation result and errors list
     *
     * @return array
     * @throws Exception
     */
    public function validate() : array {

        $result = [];

        //check if rules exists for this form
        if(empty($this->rules) && !is_array($this->rules)) {

            throw new Exception('Rules for this form has not founded!', 404);

        }

        $rules = $this->rules;

        //iterate data from client form
        foreach ($this->data as $name => $values) {

            //iterate validation rules for this form
            foreach ($rules as $fieldName => $fieldRules ){

                //make validation, if for specific field has found a suitable group of rules
                if($fieldName == $name) {

                    //iterate every rule and call suitable validation method
                    foreach ($fieldRules as $fieldRule){

                        if(!empty($this->errors[$fieldName])) break;

                        //check if rule has separator and should be separated
                        if($parsedRuleName = $this->parseRuleName($fieldRule)){

                            $methodName = $parsedRuleName['methodName'];
                            $secondArgument = $parsedRuleName['secondArgument'];

                            //is method exists, call method with two arguments
                            if (method_exists($this, $methodName)){
                                $this->$methodName($fieldName, $secondArgument);
                            } else {

                                throw new Exception("Method " . get_class($this) . "::$methodName' has not founded!", 404);

                            }

                        } else {

                            //is method exists, call method only one argument
                            if (method_exists($this, $fieldRule)) {
                                $this->$fieldRule($fieldName);
                            } else {

                                throw new Exception("Method " . get_class($this) . "::$fieldRule' has not founded!", 404);

                            }
                        }

                    }


                }

            }

        }

        //check error property and return suitable result
        if ($this->errors) {
            $result['errors'] = $this->errors;
            $result['success'] = false;
        } else {
            $result['success'] = true;
        }

        return $result;

    }

    /**
     * Splits string into two strings before and after separator ":".
     *
     * Receives a string with rule name contains of two parts slitted ":".
     * Splits rule into 2 parts and save them into array:
     * Left part  - with key methodName
     * Right part  - with key - secondArgument
     *
     * @param string $rule
     * @return array|false
     */
    protected function parseRuleName(string $rule){

        $result = [];

        if (preg_match('~:~', $rule)){
            $result['methodName'] = substr($rule, 0, strpos($rule, ":"));
            $result['secondArgument'] = substr($rule, strpos($rule, ":") + 1);
            return $result;
        }

        return false;

    }


    /**
     * Checks is field data is empty or not
     * Creates error and save it in Errors array with field name key
     *
     * @param string $name
     */
    protected function required(string $name) : void
    {
        if (empty(trim($this->data[$name][0]))) {
            $this->errors[$name] = '"' . $this->data[$name][1]. '" ' . 'je povinný údaj!';
        }
    }


    /**
     * Checks is string length is less than given in argument value
     * Creates error and save it in Errors array with field name key
     *
     * @param string $name
     * @param int $length
     */
    protected function max_length(string $name, int $length) : void {
        if (strlen($this->data[$name][0]) > $length) {
            $this->errors[$name] = 'Maximální počet symbolů pro "' . $this->data[$name][1] . ' " ' . 'je ' . $length . '!';
        }

    }

    /**
     *
     * Checks is string contains not allowed symbols
     * Creates error and save it in Errors array with field name key
     *
     * @param string $name
     */
    public function chars(string $name) : void {

        if (!preg_match('~^[a-zěščřžýáíéúůťň0-9)(+.,-/@ ?]{1,}$~ui', $this->data[$name][0]) && ($this->data[$name][0])){
            $this->errors[$name] = "{$this->data[$name][1]} obsahuje nepovolené znaky!";
        }
    }

    /**
     *
     * Checks is email has given in the correct format
     * Creates error and save it in Errors array with field name key
     *
     * @param string $name
     */
    public function email(string $name) : void
    {
        if (!empty($this->data[$name][0])) {
            if (!filter_var($this->data[$name][0], FILTER_VALIDATE_EMAIL))
                $this->errors[$name] = "\"{$this->data[$name][1]}\" není validní!";
        }
    }


    /**
     *
     * Checks is phone number has given in the correct format
     * Creates error and save it in Errors array with field name key
     *
     * @param string $name
     */
    public function phone(string $name) : void {
        if (!empty($this->data[$name][0])) {
            if (!preg_match('~^\+?[0-9]{0,3}[ ]?[0-9]{3}[ ]?[0-9]{3}[ ]?[0-9]{3}$~', $this->data[$name][0] )){
                $this->errors[$name] = "\"{$this->data[$name][1]}\" musí byt ve správném formátu!'";
            }

        }
    }

    /**
     * @param string $name
     *
     * Checks if calculation with specific name is exists in database for specific calculation type
     *
     */
    public function calc_exists(string $name) : void {

        if($_POST['calculation_type']) {
            $calc_type = $_POST['calculation_type'] . 'calc';
            $account = new Account();
            if($account->isCalculationExist($this->data[$name][0], $calc_type)){
                $this->errors[$name] = "Kalkulace \"{$this->data[$name][0]}\" už existuje!";
            }

        }


    }


}