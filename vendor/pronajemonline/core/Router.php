<?php

namespace pronajem;

use DI\Container;

final class Router {

    private Container $container;
    public function __construct(Container $container){
        $this->container = $container;
    }

    /**
     * @var array $routes Contains all registered routes with their patterns and associated arrays of parameters.
     */
    protected array $routes = [];

    /**
     * @var array $route The current route that matched the request URL, containing controller, action, and any additional parameters.
     */
    protected array $route = [];


    /**
     * Registers a new route with a specific pattern and associated parameters.
     *
     * This method is used to define routes in the application. Each route is associated
     * with a URL pattern and an array of parameters, including the controller, action,
     * and optional prefix. It is typically called in the routes.php file.
     *
     * @param string $regexp The URL pattern to match against the request URL.
     * @param array $route The associated parameters for the route, including controller, action, and prefix.
     */
    public function add($regexp, $route = []) {
       $this->routes[$regexp] = $route;
    }


    /**
     * Returns all registered routes.
     *
     * This method is useful for debugging purposes, allowing developers to inspect
     * all routes that have been registered in the application.
     *
     * @return array An associative array of all registered routes and their parameters.
     */
    public function getRoutes (){
        return $this->routes;
    }

    /**
     * Returns the current matched route.
     *
     * This method is useful for debugging purposes, allowing developers to inspect
     * the matched route and its parameters for the current request.
     *
     * @return array An associative array containing the parameters of the current route.
     */
    public function getRoute(){
        return $this->route;
    }


    /**
     * Dispatches the URL to the appropriate controller, action, view and middlware.
     *
     * @param string $url The URL path to dispatch.
     * @throws \Exception If no matching route is found or the controller/action cannot be invoked.
     */

    public function dispatch($url){
        // Remove the query string from the URL for proper matching
        $url = $this->removeQueryString($url);

        if(! $this->matchRoute($url)){
            throw new \Exception('Stránka není nalezená', 404);
        }

        foreach ($this->route['middleware'] ?? [] as $mwClass) {
            $this->container->make($mwClass)->handle();
        }

        $controller = $this->route['controller'];
        $action = $this->route['action'];

        //Create Controller objact
        $controllerObject = $this->container->make($controller);

        if(!method_exists($controllerObject, $action)){
            throw new \Exception("Method $controller::$action is not found", 404);
        }

        $controllerObject->$action(...array_values($this->route['params']));


        if (isset($this->route['view'])) {
            $controllerObject->getView($this->route['view']);
        }

     }


    /**
    * Matches the provided URL with registered routes and sets the current route.
    *
    * @param string $url The URL path to match against registered routes.
    * @return bool Returns true if a matching route is found and set as the current route, otherwise false.
    */
    public function matchRoute($url)
    {
        foreach ($this->routes as $pattern => $route) {
            if (preg_match("#^{$pattern}$#", $url ?? '', $matches)) {
                $params = [];
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $params[$k] = $v;
                    }
                }
                $route['params'] = $params;

                $this->route = $route;

                return true;
            }
        }
        return false;
    }




    /**
     * Adjusts the URL path for routing by removing any query string parameters.
     *
     * Due to the specific rewrite rule in .htaccess, the original '?' that separates the URL path
     * from query string parameters is replaced with '&'. This method processes such modified URLs
     * by separating the path from additional GET parameters. It distinguishes the first parameter
     * as the path (anything before the first '&') and discards any subsequent parameters. This
     * adjustment is crucial for the router to accurately identify the route without interference
     * from appended GET parameters. If the segment before the first '&' contains '=', it is
     * considered a query parameter, and an empty string is returned, indicating the absence of a
     * valid path.
     *
     * @param string $url The URL path combined with query string parameters, where '?' is replaced
     *                    with '&' due to .htaccess rewrite rules.
     * @return string The cleaned URL path without query string parameters. Returns an empty string
     *                if the initial segment of the URL includes '=', suggesting it is a query
     *                parameter rather than a part of the path.
     */
    protected function removeQueryString($url){
        if($url){
            // Split the URL on the first occurrence of '&' which was originally '?' in the URL
            $params = explode('&', $url, 2);

            // Check if the first segment contains '=', indicating it's a parameter, not a path
            if(false === strpos($params[0], '=')){
                // The URL does not contain '=' in the first segment, indicating it is the path
                return rtrim($params[0], '/'); //cut last "/"
            }else{
                // The first segment contains '=', indicating it's a parameter, not part of the path
                return '';
            }
        }
    }


}