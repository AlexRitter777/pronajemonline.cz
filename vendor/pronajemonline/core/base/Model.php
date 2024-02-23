<?php

namespace pronajem\base;

use pronajem\Db;
use RedBeanPHP\R as R;

/**
 * Abstract base model class that provides common functionality for working with the database.
 *
 * Initializes the database connection upon construction and provides a generic method for
 * saving data to any table in the database. Derived model classes are expected to implement
 * specific business logic and data validation, enhancing flexibility and reusability.
 */
abstract class Model {


    /**
     * Constructs the model and initializes the database connection.
     */
    public function __construct() {
        Db::instance();

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