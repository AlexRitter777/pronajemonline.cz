<?php

namespace pronajem;

/**
 * ErrorHandler class manages exception handling throughout the application.
 *
 * It configures the PHP environment to either show or hide errors based on the application's
 * debug mode. It also logs errors to a file and displays them to the user in a user-friendly
 * manner.
 */
class ErrorHandler
{

    /**
     * Initializes the error handler by setting error reporting levels and registering
     * the exception handler method.
     */
    public function __construct(){
        if(DEBUG) {
          error_reporting(-1); // Show all errors in development mode.
        }
        else {
          error_reporting(0); // Hide all errors in production mode.
        }
        set_exception_handler([$this, 'exceptionHandler']);// Register custom exception handler.
    }

    /**
     * Handles exceptions by logging them and displaying an error page.
     *
     * @param \Exception $e The exception to handle.
     */
    public function exceptionHandler($e){
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('výjimka', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    /**
     * Logs error details to a file.
     *
     * @param string $message The error message.
     * @param string $file The file where the error occurred.
     * @param int $line The line number where the error occurred.
     */
    protected function logErrors($message = '', $file = '', $line = ''){
        error_log("[" . date('Y-m-d H:i:s') . "] Error: {$message} | File: {$file} | Lime: {$line}\n============================\n", 3, ROOT . '/tmp/errors.log');
    }


    /**
     * Displays an error page to the user, adapting the level of detail based on the application's mode.
     *
     * In development mode (DEBUG = 1), this method displays a detailed error page with information about
     * the error type, message, file, and line number to facilitate debugging.
     * In production mode, it displays a generic error page to the user, hiding the specific details of the error
     * to prevent potential security risks and to offer a better user experience. The production error page may
     * simply inform the user that an error has occurred without exposing any internal application details.
     *
     * @param string $errno The error number or type, used primarily in development mode for debugging.
     * @param string $errstr The error message.
     * @param string $errfile The file where the error occurred.
     * @param int $errline The line number where the error occurred.
     * @param int $response The HTTP response code to send. Defaults to 404, indicating a not found error.
     */
    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404){

        http_response_code($responce); //show error in conslole.

        if($responce == 404 && !DEBUG) {
            require WWW . '/errors/404.php'; // Show 404 error page in production mode.
            die;
        }

        if (DEBUG) {
            require WWW . '/errors/dev.php'; // Show detailed error in development mode.
        }else{
            require WWW. '/errors/prod.php'; //Show generic error page in production mode.
        }
        die;
    }

}