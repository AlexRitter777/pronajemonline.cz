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
use app\controllers\DashboardController;
use app\controllers\LandlordsController;
use app\controllers\NewSettlementController;
use app\controllers\PropertiesController;
use app\controllers\SettlementController;
use app\controllers\AdminsController;
use app\controllers\ElsuppliersController;
use app\controllers\TenantsController;
use app\Middleware\Auth;

//$router->add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
//$router->add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);
//$router->add('^admin/users$', ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']);
//$router->add('^admin/admins$', ['controller' => 'Admins', 'action' => 'index', 'prefix' => 'admin']);







$router->add('^calculations$', ['controller' => 'Calculations', 'action' => 'index', 'prefix' => 'User']);
$router->add('^settings$', ['controller' => 'Settings', 'action' => 'index', 'prefix' => 'User']);
$router->add('^error$', ['controller' => 'Error', 'action' => 'index', 'prefix' => 'User']);


//*** New routes ***//

//Dashboard
$router->add('dashboard', [
    'controller' => DashboardController::class,
    'action' => 'index',
    'view' => 'dashboard',
    'middleware' =>[ Auth::class ],
]);


// Settlements
$router->add('settlements', [
    'controller' => SettlementController::class,
    'action' => 'index',
    'view' => 'settlements/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('settlements/new', [
    'controller' => NewSettlementController::class,
    'action' => 'index',
    'view' => 'new-settlement/index',
]);

$router->add('settlements/create', [
    'controller' => SettlementController::class,
    'action' => 'create',
    'view' => 'settlements/create',
    'middleware' => [ Auth::class ],
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

$router->add('properties', [
    'controller' => PropertiesController::class,
    'action' => 'index',
    'view' => 'Properties/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('properties/create', [
    'controller' => PropertiesController::class,
    'action' => 'create',
    'view' => 'Properties/create',
    'middleware' =>[ Auth::class ],
]);

$router->add('^properties/destroy$', [
    'controller' => 'Properties',
    'action' => 'destroy',
    'view' => null,
]);

//Landlords

$router->add('landlords', [
    'controller' => LandlordsController::class,
    'action' => 'index',
    'view' => 'Landlords/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/(?P<id>\d+)', [
    'controller' => LandlordsController::class,
    'action' => 'show',
    'view' => 'Landlords/show',
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/create', [
    'controller' => LandlordsController::class,
    'action' => 'create',
    'view' => 'Landlords/create',
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/store', [
    'controller' => LandlordsController::class,
    'action' => 'store',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/(?P<id>\d+)/edit', [
    'controller' => LandlordsController::class,
    'action' => 'edit',
    'view' => 'Landlords/edit',
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/(?P<id>\d+)/update', [
    'controller' => LandlordsController::class,
    'action' => 'update',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('landlords/destroy', [
    'controller' => LandlordsController::class,
    'action' => 'destroy',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);


//Ajax routes
$router->add('ajax/landlords/get-list', [
    'controller' => app\controllers\Ajax\LandlordsController::class,
    'action' => 'getList',
    'view' => null,
    'middleware' =>[ Auth::class ],

    ]
);

$router->add('ajax/tenants/get-list', [
    'controller' => app\controllers\Ajax\TenantsController::class,
    'action' => 'getList',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('ajax/admins/get-list', [
    'controller' => app\controllers\Ajax\AdminsController::class,
    'action' => 'getList',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('ajax/elsuppliers/get-list', [
    'controller' => app\controllers\Ajax\ElsuppliersController::class,
    'action' => 'getList',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

//Tenants

$router->add('tenants', [
    'controller' => TenantsController::class,
    'action' => 'index',
    'view' => 'tenants/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/(?P<id>\d+)', [
    'controller' => TenantsController::class,
    'action' => 'show',
    'view' => 'tenants/show',
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/create', [
    'controller' => TenantsController::class,
    'action' => 'create',
    'view' => 'tenants/create',
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/store', [
    'controller' => TenantsController::class,
    'action' => 'store',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/(?P<id>\d+)/edit', [
    'controller' => TenantsController::class,
    'action' => 'edit',
    'view' => 'tenants/edit',
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/(?P<id>\d+)/update', [
    'controller' => TenantsController::class,
    'action' => 'update',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('tenants/destroy', [
    'controller' => TenantsController::class,
    'action' => 'destroy',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

//Admins

$router->add('admins', [
    'controller' => AdminsController::class,
    'action' => 'index',
    'view' => 'Admins/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/get-admin-list', [
    'controller' => AdminsController::class,
    'action' => 'getAdminList',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/(?P<id>\d+)', [
    'controller' => AdminsController::class,
    'action' => 'show',
    'view' => 'Admins/show',
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/create', [
    'controller' => AdminsController::class,
    'action' => 'create',
    'view' => 'Admins/create',
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/store', [
    'controller' => AdminsController::class,
    'action' => 'store',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/save-modal', [
    'controller' => AdminsController::class,
    'action' => 'saveModal',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/(?P<id>\d+)/edit', [
    'controller' => AdminsController::class,
    'action' => 'edit',
    'view' => 'Admins/edit',
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/(?P<id>\d+)/update', [
    'controller' => AdminsController::class,
    'action' => 'update',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('admins/destroy', [
    'controller' => AdminsController::class,
    'action' => 'destroy',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

//Elsuppliers

$router->add('elsuppliers', [
    'controller' => ElsuppliersController::class,
    'action' => 'index',
    'view' => 'Elsuppliers/index',
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/get-elsupplier-list', [
    'controller' => ElsuppliersController::class,
    'action' => 'getElsupplierList',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/(?P<id>\d+)', [
    'controller' => ElsuppliersController::class,
    'action' => 'show',
    'view' => 'Elsuppliers/show',
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/create', [
    'controller' => ElsuppliersController::class,
    'action' => 'create',
    'view' => 'Elsuppliers/create',
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/store', [
    'controller' => ElsuppliersController::class,
    'action' => 'store',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/(?P<id>\d+)/edit', [
    'controller' => ElsuppliersController::class,
    'action' => 'edit',
    'view' => 'Elsuppliers/edit',
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/(?P<id>\d+)/update', [
    'controller' => ElsuppliersController::class,
    'action' => 'update',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);

$router->add('elsuppliers/destroy', [
    'controller' => ElsuppliersController::class,
    'action' => 'destroy',
    'view' => null,
    'middleware' =>[ Auth::class ],
]);


//Login form validation
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



