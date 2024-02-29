<?php

namespace pronajem;

use \RedBeanPHP\R as R;

/**
 * Database connection class that uses the Singleton pattern.
 *
 * This class establishes a database connection using RedBeanPHP ORM.
 */
class Db {

    use TSingletone;

    /**
     * Protected constructor to prevent direct creation of object.
     *
     * Establishes the database connection using RedBeanPHP and sets up the
     * environment according to application configuration. It throws an exception
     * if the connection cannot be established.
     *
     * @throws \Exception If unable to establish a database connection.
     */
    protected function __construct(){
        
        $db = require_once CONF . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['pass']);
        if( !R::testConnection()){
            throw new \Exception('No database connection', 500);
        }
        R::freeze(false);

        if(DEBUG) {
            R::debug(true,1);
        }
    }

}