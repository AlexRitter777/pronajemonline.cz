<?php

namespace pronajem;

use DI\Container;

/**
 * Application main class responsible for initializing core components.
 *
 * This class bootstraps the application by starting the session, initializing the registry,
 * handling the configuration parameters, setting up error handling, and routing the incoming
 * request.
 */
class App
{
    /**
     * The single instance of the application registry.
     *
     * @var Registry
     */
    public static $app;

    /**
     * Constructs the application and initializes core components.
     */
    public function __construct(){
        // Capture the user's query from the URL.
        $query = trim($_SERVER['QUERY_STRING'], '/'); //cut last "/"

        // Start the session.
        session_start();

        // Instantiate or get the existing Registry instance.
        self::$app = Registry::instance();

        // Load and set application parameters.
        $this->getParams();

        // Initialize and save DI Container to properties
        $container = new Container();
        self::$app->setProperty('container', $container);

        // Set up error handling.
        new ErrorHandler();

        // Dispatch the request to the appropriate route.
        Router::dispatch($query);
     }

    /**
     * Loads application parameters from the configuration file and sets them in the registry.
     */
    protected function getParams(){
        $params = require_once  CONF . '/params.php';
        if(!empty($params)){
            foreach ($params as $k => $v) {
                self::$app->setProperty($k, $v);
            }
        }
    }
}