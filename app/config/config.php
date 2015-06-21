<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Developing Mode
    |--------------------------------------------------------------------------
    | Whenever the errors should be printed to the screen as part of the output
    | or if they should be hidden from the user.
    */
    'debug' => true,


    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    | All database work is done through the PHP PDO facility
    |
    | Default PDO settings:
    |   - MYSQL_ATTR_INIT_COMMAND: Command to execute when connecting to the MySQL server.
    |   - ATTR_ERRMODE: Throw exceptions when errors occurs.
    |   - ATTR_DEFAULT_FETCH_MODE - Array indexed by column name.
    */
    'db' => [
        'host' => 'localhost',
        'name' => 'simple_api',
        'username' => 'root',
        'password' => 'root',
        'options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ],
        'fetch_mode' => \PDO::FETCH_ASSOC
    ],


    /*
    |--------------------------------------------------------------------------
    | JSON Options
    |--------------------------------------------------------------------------
    */
    'json_options' => JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK
];