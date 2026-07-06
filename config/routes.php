<?php

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
use app\controllers\SettlementController;

$router->add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
$router->add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);
$router->add('^admin/users$', ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']);
$router->add('^admin/admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'admin']);



//User routes
// These routes direct requests to controllers intended for user interactions.
// Each route defines a specific path, controller, action, and uses the 'user' prefix.
$router->add('^dashboard$', [
    'controller' => 'User',
    'action' => 'dashboard',
    'view' => 'User/dashboard',
]);


$router->add('^tenants$', ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'User']);
$router->add('^landlords$', ['controller' => 'Landlords', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^properties$', ['controller' => 'Properties', 'action' => 'index', 'prefix' => 'User']);
$router->add('^calculations$', ['controller' => 'Calculations', 'action' => 'index', 'prefix' => 'User']);
$router->add('^admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'User']);
$router->add('^elsuppliers$', ['controller' => 'Elsuppliers', 'action' => 'index', 'prefix' => 'User']);
$router->add('^settings$', ['controller' => 'Settings', 'action' => 'index', 'prefix' => 'User']);
$router->add('^error$', ['controller' => 'Error', 'action' => 'index', 'prefix' => 'User']);


//New routes

// Settlements
$router->add('^settlements$', [
    'controller' => 'Settlement',
    'action' => 'index',
    'view' => 'settlements/index',
]);

$router->add('^settlements/list$', [
    'controller' => 'NewSettlement',
    'action' => 'index',
    'view' => 'NewSettlement/index',
]);

$router->add('settlements/create', [
    'controller' => SettlementController::class,
    'action' => 'create',
    'view' => 'settlements/create',
    'middleware' => 'auth',
]);


$router->add('^settlements/destroy$', [
    'controller' => 'Settlement',
    'action' => 'destroy',
    'view' => null,
]);


$router->add('^services-settlements/create$', [
    'controller' => 'ServicesSettlement',
    'action' => 'create',
    'view' => 'services-settlements/create',
]);

$router->add('^login$', [
    'controller' => 'User',
    'action' => 'login',
    'view' => 'User/login',
]);

$router->add('^check-user$', [
    'controller' => 'Userajax',
    'action' => 'checkuser',
    'view' => null,

]);

$router->add('^authorization$', [
    'controller' => 'User',
    'action' => 'authorization',
    'view' => null,

]);

// Property

$router->add('^properties$', [
    'controller' => 'Properties',
    'action' => 'index',
    'view' => 'Properties/index',
]);


$router->add('^properties/create$', [
    'controller' => 'Properties',
    'action' => 'create',
    'view' => 'Properties/create',
]);

$router->add('^properties/destroy$', [
    'controller' => 'Properties',
    'action' => 'destroy',
    'view' => null,
]);

//Landlords

$router->add('^landlords$', [
    'controller' => 'Landlords',
    'action' => 'index',
    'view' => 'Landlords/index',
]);

$router->add('^validator/authorization-validation$', [
    'controller' => 'Validator',
    'action' => 'authorizationvalidation',
    'view' => null,

]);





$router->add('^calculations/servicesform$', ['controller' => 'Servicesform', 'action' => 'create', 'prefix' => 'User']);
$router->add('^calculations/servicesform/edit$', ['controller' => 'Servicesform', 'action' => 'edit', 'prefix' => 'User']);


//Ajax on calculation form loading
$router->add('^services/rent-finish-reasons$', ['controller' => 'Services', 'action' => 'rentfinishreasons']);
$router->add('^services/meters$', ['controller' => 'Services', 'action' => 'meters']);
$router->add('^services/services$', ['controller' => 'Services', 'action' => 'services']);
$router->add('^services/origins$', ['controller' => 'Services', 'action' => 'origins']);
$router->add('^services/origins-electro$', ['controller' => 'Services', 'action' => 'originselectro']);
$router->add('^services/deposit-items$', ['controller' => 'Services', 'action' => 'deposititems']);
$router->add('^services/calculation-type$', ['controller' => 'Services', 'action' => 'calculationtype']);
$router->add('^services/calculation-year$', ['controller' => 'Services', 'action' => 'calculationyear']);
$router->add('^services/calculation-list$', ['controller' => 'Services', 'action' => 'calculationlist']);
$router->add('^services/simply-services$', ['controller' => 'Services', 'action' => 'simplyservices']);
$router->add('^services/simply-meters$', ['controller' => 'Services', 'action' => 'simplymeters']);


//Ajax validators
$router->add('^validator/services-validation$', ['controller' => 'Validator', 'action' => 'servicesvalidation']);



//$router->add('^user/tenants$', ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/landlords$', ['controller' => 'Landlords', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/properties$', ['controller' => 'Properties', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/calculations$', ['controller' => 'Calculations', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/elsuppliers$', ['controller' => 'Elsuppliers', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/settings$', ['controller' => 'Settings', 'action' => 'index', 'prefix' => 'User']);
//$router->add('^user/error$', ['controller' => 'Error', 'action' => 'index', 'prefix' => 'User']);


// Guest routes
// Default routes for guests visiting the site. These do not have a prefix.
// The empty string route ('^$') directs to the main page of the site.
$router->add('^$', ['controller' => 'Main', 'action' => 'index']); //empty string
// Public Single Category Rote
$router->add('^blog/category/([\w\-]+)/?', ['controller' => 'Blog', 'action' => 'category']);
// Public Blog route
$router->add('^blog/([\w\-]+)/?', ['controller' => 'Blog', 'action' => 'single']);
// Universal guest route
//$router->add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$'); // www.example.com/controller/action





//User universal route
// A flexible route pattern that matches any user-related controller and action.
// This pattern is useful for extending the user section without adding specific routes for each controller/action pair.
$router->add('^user/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'User']);








