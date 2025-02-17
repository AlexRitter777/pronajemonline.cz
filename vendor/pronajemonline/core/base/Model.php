<?php

namespace pronajem\base;

use pronajem\App;
use pronajem\Db;
use pronajem\libs\Pagination;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R as R;
use Exception;

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
           return R::findAll($this->table, "user_id=? ORDER BY created_at DESC LIMIT ?, ?", [$userId, $start, $perPage]);
       }
       elseif(is_admin()) {
           return R::findAll($this->table, "ORDER BY created_at DESC LIMIT ?, ?", [$start, $perPage]);
       } else {
           throw new \Exception('Access dinied', 403);
       }
    }

    public function getAllRecords(int $userId = null)
    {
        if($userId) {
            return R::findAll($this->table, "user_id=?", [$userId]);
        }
        elseif(is_admin()) {
            return R::findAll($this->table);
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

    public function getOneRecordByIdManual(string $recordId, string $table, int $userId = null) {

        if($userId) {
            return R::findOne($table, 'id=? AND user_id=?',[$recordId, $userId]);
        }

        if(is_admin()){
            return R::findOne($table, 'id=?',[$recordId]);
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
     * Checks if a record exists in the specified table and column.
     *
     * @param string $record The value to search for in the column.
     * @param string $column The name of the column to check.
     * @param string $table The name of the table to search in.
     * @param string|null $userId (Optional) The ID of the user for scoping the search.
     *
     * @return mixed|null Returns the record if found, otherwise null.
     *
     * @throws \Exception If the column does not exist in the table.
     * @throws \Exception If the access is denied for non-admin users without a user ID.
     */
    public function isRecordExistsManual(string $record, string $column, string $table, string $userId = null) {

        if(!$this->checkIfColumnExists($table, $column)) {
            throw new \Exception("Column '$column' does not exists in table" . $table);
        }

        if($userId) {
            return R::findOne($table, "$column=? AND user_id=?",[$record, $userId]);
        }

        if(is_admin()){
            return R::findOne($table, "$column=?",[$record]);
        }

        throw new \Exception('Access dinied', 403);

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


    public function getSlug(string $url) : string
    {
        $needlePosition = strrpos($url, "/");
        return substr($url, $needlePosition + 1);
    }

    /**
     * Uploads an file file to the server.
     *
     * If the upload fails, logs the error and returns null.
     *
     * @param array $image The uploaded file data ($_FILES['input_name']).
     * @return string|null The relative path to the uploaded file, or null if the upload fails.
     */
    public function uploadFile(array $file, $publicFolder)
    {
        if(empty($file)){
            return null;
        }

        $uploadDir = WWW . $publicFolder;

        try {
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                throw new Exception('Failed to create upload directory.', 500);
            }
            $fileName = basename($file['name']);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $uniqueFileName;

            if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                return $uploadFilePath;
            } else {
                throw new Exception('Error saving the file.');
            }
        }catch(Exception $e) {
            logErrors($e->getMessage(), $e->getFile(), $e->getLine());
            return null;
        }
    }

    /**
     * Deletes a file from the server.
     *
     * Logs an error if the file cannot be deleted or does not exist.
     * This method does not return a value, as file deletion is not critical
     * for the application workflow.
     *
     * @param string $imageFile The absolute path to the image file.
     */
    public function deleteFile(string $filePath){

        if(file_exists($filePath)) {
            try {
                if (!unlink($filePath)) {
                    throw new Exception("Image $filePath was not deleted");
                }
            }catch (Exception $e){
                logErrors($e->getMessage(), $e->getFile(), $e->getLine());
                return false;
            }
        }else{
            logErrors("File $filePath does not exist.");
            return false;
        }
        return true;
    }

    
}