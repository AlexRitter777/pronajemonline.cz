<?php

// Enables or disables debug mode. When set to 1, errors will be displayed in the browser.
define("DEBUG", 1);

// Defines the root directory of the site.
define("ROOT", dirname(__DIR__));

// Points to the public directory of the site, typically containing index.php and assets.
define("WWW", ROOT . '/public');

// Directs to the application files.
define("APP", ROOT . '/app');

// Leads to the core of the framework.
define("CORE", ROOT . '/vendor/pronajemonline/core');

// Specifies the directory for additional libraries.
define("LIBS", ROOT . '/vendor/pronajemonline/core/libs');

// Defines the cache directory.
define("CACHE", ROOT . '/tmp/cache');

// Points to the configuration files directory.
define("CONF", ROOT . '/config');

// Sets the default site template.
define("LAYOUT", 'pronajem');

// Determine the protocol used for the request
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Constructs the application path based on the server's host name and PHP self-directory.
$app_path = "{$protocol}{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";  // http://example.com/public/index.php

// Trims the application file name, leaving the path to the directory.
$app_path = preg_replace("#[^/]+$#", '',$app_path); // http://example.com/public/
// "#[^/]+$#" - regex to find everything except a slash from the end of the string.

// Removes the "/public/" part from the path to get the base site URL.
$app_path = str_replace("/public/", '',$app_path); // http://example.com

// Defines the base URL of the site.
define("PATH", $app_path);

// Sets the path to the admin panel.
define("ADMIN", PATH . '/admin');

// Sets the default timezone.
date_default_timezone_set('UTC');

// Includes the Composer autoloader.
require_once ROOT . '/vendor/autoload.php';