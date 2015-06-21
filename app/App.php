<?php
namespace App;

use App\Services\AutoLoaderService as AutoLoader;

class App
{
    /**
     * @var App - Reference to the singleton instance.
     */
    private static $instance = null;

    /**
     * @var Array
     */
    public $config;

    /**
     * Protected constructor to prevent creating a new instance of the
     * App via the "new" operator from outside of this class.
     */
    protected function __construct() {}

    /**
     * Private clone method to prevent cloning of the instance of the
     * App instance.
     */
    private function __clone() {}


    /**
     * Private unserialize method to prevent unserializing of the
     * App instance.
     */
    private function __wakeup(){}

    /**
     * Returns the singleton instance of this class.
     *
     * @return App
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Run the app.
     *
     * @param $config Array
     */
    public function run($config)
    {
        self::instance()->config = $config;
        self::instance()->setDebugMode();
        self::instance()->loadFiles();
    }

    /**
     * If the debug mode in the config.php is set to true then
     * all errors will be printed to the screen as part of the output.
     */
    private static function setDebugMode()
    {
        if (self::instance()->config['debug']) {
            ini_set('display_errors', 1);
            ini_set('error_reporting', E_ALL & ~E_NOTICE);
        }
    }

    private static function loadFiles()
    {
        $loader = AutoLoader::instance();
        $loader->register();

        require_once __DIR__ . '/config/routes.php';
    }
}