<?php

namespace pronajem;

/**
 * The Router class is responsible for routing HTTP requests to the corresponding controller actions.
 *
 * It matches the request URL against a set of defined routes, extracts and passes parameters to
 * the corresponding controller and action method. This class supports both static and parameterized
 * routes, enabling dynamic routing based on the request URL. Routes are defined using regular expressions,
 * allowing for flexible and powerful URL matching. The Router facilitates the organization of the application's
 * flow and simplifies the mapping between URLs and the application's logic by utilizing controllers.
 */
class Router {

    /**
     * @var array $routes Contains all registered routes with their patterns and associated arrays of parameters.
     */
    protected static $routes = [];

    /**
     * @var array $route The current route that matched the request URL, containing controller, action, and any additional parameters.
     */
    protected static $route = [];


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
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }


    /**
     * Returns all registered routes.
     *
     * This method is useful for debugging purposes, allowing developers to inspect
     * all routes that have been registered in the application.
     *
     * @return array An associative array of all registered routes and their parameters.
     */
    public static function getRoutes (){
        return self::$routes;
    }

    /**
     * Returns the current matched route.
     *
     * This method is useful for debugging purposes, allowing developers to inspect
     * the matched route and its parameters for the current request.
     *
     * @return array An associative array containing the parameters of the current route.
     */
    public static function getRoute(){
        return self::$route;
    }


    /**
     * Dispatches the URL to the appropriate controller and action.
     *
     * This method processes the provided URL to find a matching route. It first removes
     * the query string from the URL to ensure accurate route matching. If a matching route
     * is found, it constructs the fully qualified name of the controller class, including
     * any namespace prefixes. It then instantiates the controller and calls the specified
     * action method. After executing the action, the method ensures that the view associated
     * with the action is rendered, unless the action explicitly terminates the execution
     * (e.g., for AJAX requests, where the controller must end with die() to prevent view rendering).
     * If no matching route is found, or the controller/action cannot be invoked,
     * an exception is thrown.
     *
     * @param string $url The URL path to dispatch.
     * @throws \Exception If no matching route is found or the controller/action cannot be invoked.
     */
    public static function dispatch($url){
        // Remove the query string from the URL for proper matching
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {
            // Construct the fully qualified controller class name with optional prefix
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

            // Check if the controller class exists
            if (class_exists($controller)){
                // Get DI Container instance
                $container = App::$app->getProperty('container');

                //Create Controller objact
                $controllerObject = $container->make($controller, [
                    'route' => self::$route,
                ]);

                // Construct the action method name from the route
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';

                // Check if the action method exists in the controller
                if (method_exists($controllerObject, $action)){
                    // Call the action method
                    $controllerObject->$action();
                    //Get the view associated with the action
                    $controllerObject->getView();
                }else{
                    // The specified action does not exist within the controller
                    throw new \Exception("Method $controller::$action is not found", 404);
                }
            }else{
                // The specified controller does not exist
                throw new \Exception("Controller $controller is not found", 404);
            }

        }else{
            // No matching route was found
            throw new \Exception('Stránka není nalezená', 404);
        }

     }



   /**
    * Matches the provided URL with registered routes and sets the current route.
    *
    * This method iterates through all registered routes and attempts to match the provided URL
    * against them using regular expressions. If a match is found, it extracts and sets parameters
    * from the URL as properties of the current route, such as the controller, action, and any
    * custom parameters defined in the route pattern. The method also ensures default values for
    * the action and prefix if they are not explicitly provided in the route.
    *
    * @param string $url The URL path to match against registered routes.
    * @return bool Returns true if a matching route is found and set as the current route, otherwise false.
    */
    public static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url ?? '', $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                // Set default action to 'index' if not provided
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }

                // Append a backslash to the prefix if it's provided, otherwise set it to an empty string
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                // Convert controller and action names to the appropriate naming conventions
                $route['controller'] = self::upperCamelCase($route['controller']);
                $route['action'] = self::lowerCamelCase($route['action']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }


    /**
     * Converts a string to UpperCamelCase.
     *
     * This method replaces hyphens with spaces, capitalizes the first letter of each word,
     * and then removes spaces to form a string in UpperCamelCase format. It's commonly used
     * to convert route or file names to class names following the naming conventions.
     *
     * @param string $name The string to be converted.
     * @return string The converted string in UpperCamelCase.
     */
    protected static function upperCamelCase($name){
        $name = ucwords(str_replace('-', ' ', $name));
        return str_replace(' ', '', $name);

    }


    /**
     * Converts a string to camelCase.
     *
     * This method first converts the string to UpperCamelCase and then makes the first character lowercase.
     * It's used for converting route or file names to method names following the naming conventions.
     *
     * @param string $name The string to be converted.
     * @return string The converted string in camelCase.
     */
    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
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
    protected static function removeQueryString($url){
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