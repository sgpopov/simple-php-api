<?php

namespace App\Services;

use App\App as App;

class DatabaseService
{
    /**
     * A reference to the singleton instance.
     *
     * @var DatabaseService
     */
    protected static $instance = null;

    /**
     * Protected constructor to prevent creating a new instance of the
     * DatabaseService via the "new" operator from outside of this class.
     */
    protected function __construct() {}

    /**
     * Private clone method to prevent cloning of the instance of the
     * DatabaseService instance.
     */
    private function __clone() {}

    /**
     * Private unserialize method to prevent unserializing of the
     * DatabaseService instance.
     */
    private function __wakeup() {}

    /**
     * Returns the singleton instance of this class.
     *
     * @return DatabaseService
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            $db = App::instance()->config['db'];

            self::$instance = new \PDO(
                'mysql:host='. $db['host'] .';dbname='. $db['name'],
                $db['username'], $db['password'], $db['options']
            );
        }

        return self::$instance;
    }
}