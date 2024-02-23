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
 * Usage of these configurations can be found throughout the application, particularly
 * in the initialization process and when rendering views, sending emails, or setting
 * up the application environment.
 *
 * Ensure to keep sensitive information such as SMTP passwords secure and not expose
 * them in version control or publicly accessible areas!
 */
return [

    // General application settings
    'admin_email' => 'admin@pronajemonline.cz',
    'app_name' => 'pronajemonline.cz',

    // SMTP settings for sending emails
    'smtp_login' => 'info@pronajemonline.cz',
    'smtp_password' => 'Pharma11021985k!',
    'smtp_host' => 'smtp.hostinger.com',

    // Additional email settings
    'info_email' => 'info@pronajemonline.cz',
    'info_email_name' => 'pronajemonline.cz',

    // Layout includes configuration for different view contexts
    'includes' => [
        'account' => ['header','footer','left_side_bar'],
        'account_form' => ['header','footer','left_side_bar'],
        'account_from_new' => ['header','footer','left_side_bar'],
        'default' => [],
        'pdf' => [],
        'pronajem' => ['header', 'footer'],
        'pronajemcalc' => ['header', 'footer'],
        'pronajemform' => ['header', 'footer']

    ]

];