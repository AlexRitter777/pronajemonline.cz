<?php
// Import the Router class
use pronajem\Router;

/*
 * Register routes for the application.
 *
 * Each route is defined by a regular expression pattern that the Router will match
 * against the URL. Routes can specify a controller, an action, and an optional prefix.
 * The prefix is used to group routes under a common namespace, making it easier to
 * organize routes for different sections of the application, such as admin and user areas.
 */


//Admin routes
// These routes use the 'admin' prefix to direct requests to controllers in the 'admin' namespace.
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);
Router::add('^admin/users$', ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'admin']);



//User routes
// These routes direct requests to controllers intended for user interactions.
// Each route defines a specific path, controller, action, and uses the 'user' prefix.
Router::add('^user/tenants$', ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/landlords$', ['controller' => 'Landlords', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/properties$', ['controller' => 'Properties', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/calculations$', ['controller' => 'Calculations', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/elsuppliers$', ['controller' => 'Elsuppliers', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/settings$', ['controller' => 'Settings', 'action' => 'index', 'prefix' => 'User']);
Router::add('^user/error$', ['controller' => 'Error', 'action' => 'index', 'prefix' => 'User']);

// Guest routes
// Default routes for guests visiting the site. These do not have a prefix.
// The empty string route ('^$') directs to the main page of the site.
Router::add('^$', ['controller' => 'Main', 'action' => 'index']); //empty string
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$'); // www.example.com/controller/action

//User universal route
// A flexible route pattern that matches any user-related controller and action.
// This pattern is useful for extending the user section without adding specific routes for each controller/action pair.
Router::add('^user/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'User']);
