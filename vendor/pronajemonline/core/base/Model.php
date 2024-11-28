<?php

namespace pronajem\base;

use pronajem\App;
use pronajem\Db;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R as R;

/**
 * Abstract base model class that provides common functionality for working with the database.
 *
 * Initializes the database connection upon construction and provides a generic method for
 * saving data to any table in the database. Derived model classes are expected to implement
 * specific business logic and data validation, enhancing flexibility and reusability.
 */
abstract class Model {

    protected $table;

    protected $pagination;

    /**
     * Constructs the model, initializes the database connection, and optionally sets up pagination.
     *
     * @param PaginationSetParams|null $pagination An optional instance of the PaginationSetParams class
     *                                             to handle pagination settings. If null, pagination
     *                                             will not be initialized.
     */
    public function __construct(PaginationSetParams $pagination = null) {
        Db::instance();

        if (!$this->table) {
            $this->table = $this->inferTableName();
        }

        $this->pagination = $pagination;

    }

    /**
     * Infers the database table name from the class name using snake_case conversion.
     *
     * @return string The inferred table name in snake_case format.
     */
    private function inferTableName() : string
    {
        $className = (new \ReflectionClass($this))->getShortName();

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));

    }



    public function getAllRecordsWithPagination(int $perPage, int $userId = null)
    {
        if(!$this->pagination) throw new \Exception('Pagination Model is not found', 404);

        if($userId){
            $total = R::count($this->table, 'user_id=?', [$userId] );
        } elseif(is_admin()) {
            $total = R::count($this->table);
        } else {
            throw new \Exception('Access dinided', 403);
        }
                               
        $this->pagination->setPaginationParams($perPage, $total);

        $start = $this->pagination->getStart();


       if($userId) {
           return R::findAll($this->table, "user_id=? LIMIT ?, ?", [$userId, $start, $perPage]);
       }
       elseif(is_admin()) {
           return R::findAll($this->table, "LIMIT ?, ?", [$start, $perPage]);
       } else {
           throw new \Exception('Access dinied', 403);
       }
    }


    public function getOneRecordById(string $recordId, int $userId = null) {

        if($userId) {
            return R::findOne($this->table, 'id=? AND user_id=?',[$recordId, $userId]);
        }

        if(is_admin()){
            return R::findOne($this->table, 'id=?',[$recordId]);
        }

        throw new \Exception('Access dinied', 403);

    }



    public function getOneRecordBySlug(string $slug, int $userId = null) {

        if(!$this->checkIfColumnExists($this->table, 'slug')) {
            throw new \Exception('Column "Slug" does not exists in table' . $this->table);
        }

        if($userId) {
            return R::findOne($this->table, 'slug=? AND user_id=?',[$slug, $userId]);
        }

        if(is_admin()){
            return R::findOne($this->table, 'slug=?',[$slug]);
        }

        throw new \Exception('Access dinied', 403);
    }



    private function checkIfColumnExists(string $table, string $column) : bool {
        $columns = R::inspect($table);
        return array_key_exists($column, $columns);
    }



    public function getAllRecordsByColumn(string $columnName, string $columnValue) {

        if(!$this->checkIfColumnExists($this->table, $columnName)) {
            throw new \Exception("Column $columnName does not exists");
        }

        return R::findAll($this->table, "$columnName=?", [$columnValue]);

    }

    public function saveAll($data) {
        $bean = R::dispense($this->table);
        foreach ($data as $k => $v){

            $bean->$k = $v;

        }
        return R::store($bean);
    }

    
    public function upadateAll($data, $bean) {
        foreach ($data as $k => $v){

            $bean->$k = $v;

        }
        return R::store($bean);
    }

    public function deleteOneRecordbyId(string $recordId){

        $record = $this->getOneRecordById($recordId);
        if(!$record) {
            return false;
        }
        R::trash($record);
        return true;

    }


    /**
     * Saves data to the specified table in the database.
     *
     * This method creates a new bean for the given table, populates it with the provided data,
     * and saves it to the database using RedBeanPHP. It abstracts the process of storing data,
     * making it reusable for any model that extends this base class.
     *
     * @param array $data Data to be saved in the table.
     * @param string $tbl Name of the table where the data should be saved.
     * @return int The ID of the stored bean.
     */
    public static function dbSave($data, $tbl) {
        $bean = R::dispense($tbl);
        foreach ($data as $k => $v){

            $bean->$k = $v;

        }
        return R::store($bean);

    }




    

    
}