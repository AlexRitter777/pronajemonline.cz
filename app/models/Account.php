<?php

namespace app\models;

use mysql_xdevapi\Exception;
use mysql_xdevapi\Table;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class Account extends AppModel {


    public function personProps($table) : array {

        $result = [];
        $temp = 0;
        $userID = $_SESSION['user_id'];
        $personId = $table . '_id';
        $personProp = R::getAll("SELECT id,{$personId},address FROM property WHERE user_id = :user_id ORDER BY {$personId}", [':user_id' => $userID] );
        if($personProp) {
            foreach ($personProp as $id => $value) {

                if ($value[$personId] == $temp) {
                    $result[$value[$personId]] = 'Více nemovitostí';
                } else {
                    $result[$value[$personId]] = $value['address'];
                }
                $temp = $value[$personId];
            }
        }

        return $result;

    }



    public function tenatsProps() : array {
        //muzeme prodat WHERE userID = Session userID pro mensi pole
        $result = [];
        $temp = 0;
        $userID = $_SESSION['user_id'];
        $tenantProp = R::getAll("SELECT tenant_id,address FROM property WHERE user_id = :user_id ORDER BY tenant_id", [':user_id' => $userID] );
        if($tenantProp) {
            foreach ($tenantProp as $id => $value) {

                if ($value['tenant_id'] == $temp) {
                    $result[$value['tenant_id']] = 'Více nemovitostí';
                } else {
                    $result[$value['tenant_id']] = $value['address'];
                }
                $temp = $value['tenant_id'];
            }
        }

        return $result;

    }


    public function propertyList($personId, $table) : array {

        $column = $table . '_id';
        return R::getAll("SELECT id,address FROM property WHERE {$column} = :{$column}", [":{$column}" => $personId] );

    }

    public function getPerson($table) : array {

        $result = [];
        $personList = R::getAll("SELECT id,name FROM {$table}" );
        if($personList){
            foreach ($personList as $id =>$value) {

                $result[$value['id']] = $value['name'];


            }
        }

        return $result;

    }


    public function prepareData(array $data)
    {

        $loadedData = [];

        foreach ($data as $key => $value){

            if (($value['required']) == "true"){

                if(empty($value['name'])) return false;

            }

            if (isset($value['name'])){

                $loadedData[$key] = $value['name'];

            }

        }

        if (count($loadedData) !== 0 ) return $loadedData;

        return false;
    }

    /**
     * Extract and return part of uri between two slashes without last letter s.
     *
     * user/admins/save => admin
     *
     * @return string
     */
    public function getFormName() : string{

        $url = $_SERVER['QUERY_STRING'];

        $positionLeft = strpos($url, "/");

        $withoutLeftPart = substr($url, $positionLeft+1);

        $positionRight = strpos($withoutLeftPart, "/");

        $withoutRightPart = substr($withoutLeftPart, 0, $positionRight);

        return substr($withoutRightPart, 0,-1);


    }

    public function cutLeftPart(string $string, string $symbol) : string
    {
        $positionLeft = strpos($string, $symbol);

        if($positionLeft !== false) {
            return substr($string, $positionLeft + 1);
        }

        return $string;
    }


    public function cutRightPart(string $string, string $symbol) : string
    {
        $positionRight = strrpos($string, $symbol);

        if ($positionRight !== false) {

            return substr($string, 0, $positionRight);
        }

        return $string;
    }


    /**
     * Method receives data from form in array, table name and current user id.
     * Finds table columns titles, compares every data key name with table column name
     * and save data values in case if data key name is matches with column name and value
     * is exists in data array.
     * Returns ID of new row in database
     *
     * @param string $table
     * @param array $data
     * @param int $userID
     * @return int
     * @throws SQL
     * @throws \Exception
     */
    public function saveData(string $table, array $data, int $userID) : int
    {
        //get columns titles
        $columnsNames = R::inspect($table);

        $bean = R::dispense($table);
        $bean->user_id = $userID;

        foreach ($data as $name => $value){
            //cut column name before "_"
            $columnName = $this->cutLeftPart($name,"_");

            //chek if column with this name exists
            if ($columnsNames[$columnName]){

                //pass value to column, if value exists
                if($value) $bean->$columnName = strip_tags($value);

            } else throw new \Exception("Column with name '$name' was not found!", 404);


        }

        if (!($recordId = R::store($bean))) throw new \Exception('Chyba zápisu do DB!', 500);

        return $recordId;
    }


    /**
     * @param int $id
     * @param string $table
     * @param int $userID
     * @return \RedBeanPHP\OODBBean|NULL
     */
    public function getRecordById(int $id, string $table, int $userID)
    {

        return R::findOne($table, 'id=? AND user_id=?',[$id, $userID]);

    }

    public function getCalculation(int $id, string $table, int $userID){
        return R::getRow( "SELECT * FROM $table WHERE id = :id AND user_id = :user_id",
            [':id' => $id, ':user_id' => $userID]
        );
    }

    /**
     * Checks every element of data array and in case if string element contains "^" separator converts this string to array
     * and removes the first empty element form array.
     * We know that the first element is empty, because before save to DB we converted all arrays to strings with firs symbol "^".
     *
     *
     * @param array $data
     * @return array
     */
    public function prepareDataToCalculation(array $data){

        $result = [];

        foreach ($data as $key => $item){

            if(false !== strpos($item, '^')){
                $result[$this->snakeCaseToCamelCase($key)] = explode('^', (string)$item);
                if (empty($result[$this->snakeCaseToCamelCase($key)][0])){
                    array_shift($result[$this->snakeCaseToCamelCase($key)]);
                }
            } else {

                $result[$this->snakeCaseToCamelCase($key)] = $item;
            }


        }

        return $result;

    }


    /**
     *
     * Converts snake_case string to camelCase string.
     *
     * @param string $string
     * @param bool $capitalizeFirstCharacter
     * @return string
     */
    public function snakeCaseToCamelCase(string $string, bool $capitalizeFirstCharacter = false)
    {

        $str = str_replace('_', '', ucwords($string, '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    /**
     * Check if calculation with specific name is exists in specific table for specific User
     *
     * @param string $calcName
     * @param string $table
     * @return bool
     */
    public function isCalculationExist(string $calcName, string $table) : bool
    {
        $userId = $_SESSION['user_id'];
        $calculation = R::findOne($table, 'calculation_name = ? AND user_id =?', [$calcName, $userId]);
        if ($calculation) {
            return true;
        }

        return false;

    }




    public function filterQueryMaker(array $conditions, string $table): array
    {

        $result = [];
        $condition = '';
        $params = [];

        $keys = array_keys($conditions);


        //$keys = $this->removeUrl($keys);//??

        foreach ($keys as $index => $value) {

            if($this->checkFilterTemplate($value)) {
                $columnTitle =  $this->cutRightPart($this->cutLeftPart($value, '_'), '_');

                if ($this->checkColumn($columnTitle, $table)){

                    if (!$condition) {
                        $condition = $columnTitle . '=? ';
                    } else {
                        $condition .= ' OR ' . $columnTitle . '=? ';
                    }
                    array_push($params, urldecode($conditions[$value]));

                }

            }

        }



        if(!empty($condition)) {
            $condition = 'AND (' . $condition . ')';
        }

        $result[0] = $condition;
        $result[1] = $params;


        return $result;


    }



    public function checkAllCalculations(array $calculations) : bool {

        foreach ($calculations as $calculation) {
            if($calculation) return true;
        }

        return false;
    }

    public function createCalculationsBatch(array $calculations, int $userID)  {
        $result =[];
        foreach ($calculations as $calcName => $tableName) {
            $calculation = R::findAll($tableName, "user_id=? ORDER BY updated_at DESC LIMIT 0, 5", [$userID]);

            if (!$calculation){
                $result[$calcName] = null;
            }else{
                $result[$calcName] = $calculation;
            }
        }
        $i = 0;
        foreach ($result as $key => $value) {
            if ($value) {
                $i++;
            }
        }

        if($i === count($result)) return $result;

        return null;
    }





    public function checkColumns(array $columns, $table) : bool {

        //get table columns titles
        $tableColumns = R::inspect($table);

        foreach ($columns as $column) {
            if(!array_key_exists($column, $tableColumns)) return false;
        }

        return true;

    }

    public function checkColumn(string $column, string $table) : bool {

        //get table columns titles
        $tableColumns = R::inspect($table);

        if(array_key_exists($column, $tableColumns)) return true;

        return false;
    }

    public function checkFilterTemplate(string $name) : bool {

        if(preg_match("~^filter_~", $name)) return true;

        return false;

    }

    public function removeDuplicateValues(array $values) : array {

        return array_unique($values);

    }

    public function removeUrl(array $params) : array {

        foreach ($params as $k => $v) {
            if (preg_match("~user/~", $v)) {
                unset($params[$k]);
            }
        }

        return $params;

    }


    public function replaceUrlFilterOrder(string $order) : string
    {

        $url = $_SERVER['REQUEST_URI'];

        // Проверка наличия параметра 'ordered=' в URL
        if (strpos($url, 'ordered=') !== false) {
            // Замена значения параметра 'ordered'
            $url = preg_replace("/(ordered=)[^&]*/", "$1" . $order, $url);
        } else {
            // Добавление параметра 'ordered=' в URL
            if (strpos($url, 'page=') !== false) {
                // Если есть параметр 'page', вставляем перед ним
                $url = str_replace('page=', 'ordered=' . $order . '&page=', $url);
            } else {
                // Если параметра 'page' нет, добавляем в конец строки
                $url .= (strpos($url, '?') !== false ? '&' : '?') . 'ordered=' . $order;
            }
        }

        return $url; // Вывод измененного URL

    }



}