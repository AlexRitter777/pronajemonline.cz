<?php

/**
 * Outputs the given array or variable in a readable format for debugging.
 * @param mixed $arr The variable to be debugged.
 */
function debug($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

/**
 * Outputs the given array or variable in a readable format and terminates the script.
 * @param mixed $arr The variable to be dumped.
 */
function dd($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
    die();
}

/**
 * Escapes HTML characters in a string to prevent XSS attacks.
 * @param string $string The string to be escaped.
 */
function h($string) {
    echo htmlspecialchars($string);
}

/**
 * Redirects to the specified URL or to the referring page if no URL is provided.
 * @param string|false $http The URL to redirect to. Uses the HTTP referrer or PATH if false.
 */
function redirect($http = false) {
    if($http) {
        $redirect = $http;
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;

    }
    header("Location: $redirect");

    exit;
}


/**
 * Checks if the user is currently logged in.
 * @return bool True if the user is logged in, false otherwise.
 */
function is_user_logged_in(): bool
{

    $user = new \app\models\User();

    return $user->isUserLoggedIn();

}

function is_admin(){

    $admin = new \app\models\Admin;
    
    return $admin->isUserAdmin();

}


/**
 * Flash a message
 *
 * @param string $name
 * @param string $message
 * @param string $type (error, warning, info, success)
 * @return void
 */
function flash(string $name = '', string $message = '', string $type = ''): void
{
    if ($name !== '' && $message !== '' && $type !== '') {
        \pronajem\libs\FlashMessages::create_flash_message($name, $message, $type);
    } elseif ($name !== '' && $message === '' && $type === '') {
        \pronajem\libs\FlashMessages::display_flash_message($name);
    } elseif ($name === '' && $message === '' && $type === '') {
        \pronajem\libs\FlashMessages::display_all_flash_messages();
    }
}


function logErrors($message = '', $file = '', $line = ''){
    error_log("[" . date('Y-m-d H:i:s') . "] Error: {$message} | File: {$file} | Line: {$line}\n============================\n", 3, ROOT . '/tmp/errors.log');
}