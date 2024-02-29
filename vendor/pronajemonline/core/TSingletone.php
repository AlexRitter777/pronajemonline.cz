<?php

namespace pronajem;

trait TSingletone {

    private static $instance;

    /**
     * Returns the single instance of the class.
     *
     * @return self The single instance.
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor is private to prevent initiation with 'new'.
     */
    private function __construct() {
        // Initialize the instance.
    }

    /**
     * Prevent the instance from being cloned.
     */
    private function __clone() {
        // Do nothing...
    }

    /**
     * Prevent from being unserialized.
     */
    /*private function __wakeup() {
        // Do nothing...
    }*/
}