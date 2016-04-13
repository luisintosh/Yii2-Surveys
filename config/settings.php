<?php
/**
 * Fill with your data
 */
function settings($key)
{
    $s = [
        // Website
        'website_title' => 'Surveys',
        'website_description' => 'You can create awesome surveys',
        'website_logo' => '', /* http://www.site.com/images/logo.png */

        // Database
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=survey',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],

        // Mail SMTP
        'mailer' => [
            'mailserver_url' => '', /* smtp.gmail.com */
            'mailserver_login' => '', /* 'fakemail.9208@gmail.com' */
            'mailserver_password' => '',
            'mailserver_port' => '', /* 587 */
        ],

        // Google Analytics
        'google_analytics_id' => '', /* UA-XXXXXXXX */
    ];

    return $s[$key];
}