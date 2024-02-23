<?php

namespace pronajem;

/**
 * Registry class using the Singleton pattern through TSingletone trait.
 *
 * This class serves as a global storage for application-wide settings and values.
 * It provides methods to set and get properties dynamically. Being a singleton,
 * it ensures that the same set of properties is available throughout the application,
 * maintaining a single instance of the registry.
 */
class Registry {

    use TSingletone;

    /**
     * Container for the properties.
     *
     * @var array
     */
    protected static $properties = [];

    /**
     * Sets a property by name.
     *
     * @param string $name The name of the property to set.
     * @param mixed $value The value of the property to set.
     */
    public function setProperty($name, $value) {

        self::$properties[$name] = $value;

    }

    /**
     * Gets a property by name.
     *
     * @param string $name The name of the property to retrieve.
     * @return mixed|null The value of the property if found, or null if not set.
     */
    public function getProperty($name) {
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    /**
     * Returns all stored properties.
     *
     * @return array An associative array of all properties.
     */
    public function getProperties(){
        return self::$properties;
    }

}