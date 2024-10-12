<?php

/**
 * Configuration settings for the application.
 *
 * This file contains key-value pairs that configure various aspects of the application,
 * including email settings, application name, SMTP credentials for sending emails, and
 * layout includes for different views. The 'includes' section specifically defines
 * which additional view components (like headers, footers, and sidebars) should be
 * included for different layouts or view contexts.
 *
 * The SMTP settings are separated into 'config_smtp.php' to enhance security practices by
 * isolating sensitive information, thus making it easier to exclude from version control
 * and reduce exposure risk.
 *
 * Usage of these configurations can be found throughout the application, particularly
 * in the initialization process and when rendering views, sending emails, or setting
 * up the application environment.
 *
 * Ensure to keep sensitive information such as SMTP passwords secure and not expose
 * them in version control or publicly accessible areas!
 */


$smtpConfig = [];

// Importing SMTP settings from a separate configuration file, if this file exists
if(is_file(CONF . '/config_smtp.php')) {
    $smtpConfig = require_once CONF . '/config_smtp.php';
}

return [

    // General application settings
    'admin_email' => 'admin@pronajemonline.cz',
    'app_name' => 'pronajemonline.cz',


    // Additional email settings
    'info_email' => 'info@pronajemonline.cz',
    'info_email_name' => 'pronajemonline.cz',

    // Layout includes configuration for different view contexts
    'includes' => [
        'admin' => ['admin_header','footer','admin_side_bar'],
        'account' => ['header','footer','left_side_bar'],
        'account_form' => ['header','footer','left_side_bar'],
        'account_form_new' => ['header','footer','left_side_bar'],
        'default' => [],
        'pdf' => [],
        'pronajem' => ['header', 'footer'],
        'pronajemcalc' => ['header', 'footer'],
        'pronajemform' => ['header', 'footer']

    ]

] + $smtpConfig; // Integrating SMTP settings with general configurations.

