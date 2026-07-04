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

    $admin = new \app\Support\Admin;
    
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

/**
 * Get the correct path for Vite assets based on the environment.
 *
 * @param string $path The relative path to the asset (e.g., 'main.js').
 * @return string The full URL or path to the asset.
 */
function vite_asset(string $path): string
{

    if (defined('APP_ENV') && APP_ENV === 'local') {
        //run Vite server
        return 'http://pronajemonline.local:5174/' . ltrim($path, '/');
    }

    // Production: read manifest.json from public/assets
    $manifestPath = __DIR__ . '/../public/assets/manifest.json';
    if (!file_exists($manifestPath)) {
        // Not found — connect directly (fallback)
        return '/assets/' . ltrim($path, '/');
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    if (!isset($manifest[$path])) {
        // If path not found in manifest - connect directly
        return '/assets/' . ltrim($path, '/');
    }

    return '/assets/' . $manifest[$path]['file'];
}

/**
 * Render a component by its name with optional data.
 *
 * @param string $name The name of the component to render.
 * @param array $data Optional associative array of data to pass to the component.
 * @return string The rendered component as a string.
 */
function componet(string $name, array $data = []): string
{
    return (new \pronajem\libs\Component())->render($name, $data);
}


/**
 * Sanitize input data by trimming whitespace from string values in the array.
 *
 * @param array $data The input array to be sanitized.
 * @return array The sanitized array with trimmed string values.
 */
function sanitize(array $data): array {
    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $data[$key] = trim($value);
        }
    }
    return $data;
}

function checkCsrfOrRedirect(string $token) : void
{
    if (empty($_POST['token']) || !\pronajem\libs\CSRF::checkCsrfToken($_POST['token'])) {
        flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
        redirect();
    }
}



