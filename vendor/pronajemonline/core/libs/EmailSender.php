<?php

namespace pronajem\libs;

use PHPMailer\PHPMailer\PHPMailer;
use pronajem\App;


/**
 * EmailSender provides static methods for sending emails.
 *
 * Utilizing PHPMailer, this class abstracts the email sending process and allows for easy SMTP configuration.
 * It supports sending HTML emails based on view templates and provides error logging capabilities for failed email attempts.
 * Being part of the core library, it is designed to be used across the entire application without the need for instantiation.
 *
 * @package Core\Libs
 */
class EmailSender
{

    /**
     * Sends an email using PHPMailer.
     *
     * This method allows sending an email with optional SMTP configuration. It supports HTML content
     * and uses a view file for the email body. Parameters allow customization of the sender, recipient,
     * and other email headers.
     *
     * @param string $email Recipient's email address.
     * @param string $subject Email subject.
     * @param string $view The view file used for the email body.
     * @param array $data Data to be passed to the view, default is an empty array.
     * @param bool $useSMTP Indicates whether to use SMTP for sending the email. Default is false.
     * @param string $from Sender's email address. If not provided, the default application email is used.
     * @param string $name Sender's name. If not provided, the default application name is used.
     * @return bool Returns true if the email was sent successfully, false otherwise.
     * @throws \PHPMailer\PHPMailer\Exception If sending the email fails.
     */
    public static function sendEmail(string $email, string $subject, string $view, array $data = [], string $from = '', string $name = '')
    {
        
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $from = empty($from) ? App::$app->getProperty('info_email') : $from ;
        $name = empty($name) ? App::$app->getProperty('info_email_name') : $name ;


        $mail->setFrom($from, $name);
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = self::viewMailBody($view, $data);

        if(SMTP) {

            $mail->isSMTP();
            $mail->Host = app::$app->getProperty('smtp_host');;
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = 'tls';
            $mail->Username = App::$app->getProperty('smtp_login');
            $mail->Password = App::$app->getProperty('smtp_password');
            $mail->Port = 587;
        }

        if($mail->Send()){
            return true;
        };
        self::logEmailError($mail->ErrorInfo, $email, true);
        return false;

    }

    /**
     * Logs an email sending error to a file.
     *
     * This method records details of an email sending error, including the recipient's email address,
     * the error message, and optionally, detailed caller information. If detailed logging is enabled,
     * it captures and logs the calling class and method, enhancing the troubleshooting process by
     * providing context for the error.
     *
     * @param string $mailError The error message returned by the mailer.
     * @param string $email The recipient's email address that was attempted.
     * @param bool $detailedLogging Whether to include detailed calling information in the log. Default is false.
     */
    protected static function logEmailError(string $mailError, string $email,bool $detailedLogging = false) : void {

        $logRecord = sprintf(
            "[%s] Error sending email to %s: %s\n",
            date('Y-m-d H:i:s'),
            $email,
            $mailError
        );

        if ($detailedLogging) {
            $backtrace = debug_backtrace();
            $callerInfo = isset($backtrace[2]) ? $backtrace[2] : null; // Colling method info
            if ($callerInfo) {
                // Add info to log
                $callerDetails = sprintf(
                    "Called by %s::%s on line %d",
                    $callerInfo['class'] ?? '[no class]',
                    $callerInfo['function'] ?? '[no function]',
                    $callerInfo['line'] ?? 0
                );
                $logRecord .= "Caller: $callerDetails\n";
            }
        }

        // Record to logfile
        file_put_contents(ROOT . '/tmp/email_error.log', $logRecord, FILE_APPEND);


    }

    /**
     * Generates the email body from a specified view file.
     *
     * This method extracts variables to be used in the view file, allowing dynamic content generation
     * for the email body. It leverages output buffering to capture the included view file's output
     * as a string.
     *
     * @param string $mailBody The name of the view file (without the '.php' extension) located in the 'views/Emails' directory.
     * @param array $vars Optional associative array of variables to be extracted and made available in the view file.
     * @return string The generated email body content.
     * @throws \Exception Throws an exception if the specified view file does not exist.
     */
    protected static function viewMailBody($mailBody, $vars = []) {

        if (is_array($vars)) extract($vars);
        $viewFile = APP . "/views/Emails/{$mailBody}.php";
        if(is_file($viewFile)) {
            ob_start();
            require $viewFile;
            return ob_get_clean();
        }else{
            throw new \Exception("Mail template {$mailBody} is not found", 500);
        }

    }
    
    
}