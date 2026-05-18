<?php

namespace pronajem;

use DI\Container;
use DI\ContainerBuilder;

/**
 * Application main class responsible for initializing core components.
 *
 * This class bootstraps the application by starting the session, initializing the registry,
 * handling the configuration parameters, setting up error handling, and routing the incoming
 * request.
 */
final class App
{
    /**
     * The single instance of the application registry.
     *
     * @var Registry
     */
    public static $app;

    private Container $container;

    /**
     * Constructs the application and initializes core components.
     */
    public function __construct()
    {


        // Start the session.
        session_start();

        // Instantiate or get the existing Registry instance.
        self::$app = Registry::instance();
//        $this->registry = Registry::instance();

        // Load and set application parameters.
        $this->getParams();

        // Initialize, configure and save DI Container to properties
//        $containerBuilder = new ContainerBuilder();
//        $definitions = require CONF . '/di-config.php';
//        $containerBuilder->addDefinitions($definitions);
//        $containerBuilder->useAttributes(true);
//        $container = $container = $containerBuilder->build();
//        self::$app->setProperty('container', $container);

        $this->container = $this->buildContainer();

        // Set up error handling.
        new ErrorHandler();

    }

    public function run(): void
    {
        // Capture the user's query from the URL.
        $query = trim($_SERVER['QUERY_STRING'], '/'); //cut last "/"

        $router = new Router($this->container);

        require_once CONF . '/routes.php';

        // Dispatch the request to the appropriate route.
        $router->dispatch($query);

    }


    //DI container getter
    public function container(): Container
    {
        return $this->container;
    }

    private function buildContainer(): Container
    {
        $containerBuilder = new ContainerBuilder();
        $definitions = require CONF . '/di-config.php';
        $containerBuilder->addDefinitions($definitions);
        $containerBuilder->useAttributes(true);
        return $containerBuilder->build();
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