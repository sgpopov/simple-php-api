<?php

namespace App\Services;

class AutoLoaderService
{

    /**
     * A reference to the singleton instance.
     *
     * @var AutoLoaderService
     */
    protected static $instance = null;

    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    private $prefixes = [
        'App\\' => ['app/']
    ];

    /**
     * Protected constructor to prevent creating a new instance of the
     * AutoLoaderService via the "new" operator from outside of this class.
     */
    protected function __construct() {}

    /**
     * Private clone method to prevent cloning of the instance of the
     * AutoLoaderService instance.
     */
    private function __clone() {}

    /**
     * Private unserialize method to prevent unserializing of the
     * AutoLoaderService instance.
     */
    private function __wakeup() {}

    /**
     * Returns the singleton instance of this class.
     *
     * @return AutoLoaderService
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * Loads the class file for a given class name.
     *
     * @param string $class The fully-qualified class name.
     * @return mixed The mapped file name on success, or boolean false on
     * failure.
     */
    public function load($class)
    {
        $prefix = $class;

        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);

            $mapped_file = $this->map($prefix, $relative_class);

            if ($mapped_file) {
                return $mapped_file;
            }

            $prefix = rtrim($prefix, '\\');
        }

        return false;
    }

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $prefix The namespace prefix.
     * @param string $relative_class The relative class name.
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    private function map($prefix, $relative_class)
    {
        // are there any base directories for this namespace prefix?
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        // look through base directories for this namespace prefix
        foreach ($this->prefixes[$prefix] as $base_dir) {

            // replace the namespace prefix with the base directory,
            // replace namespace separators with directory separators
            // in the relative class name, append with .php
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // if the mapped file exists, require it
            if ($this->requireFile($file)) {
                // yes, we're done
                return $file;
            }
        }

        // never found it
        return false;
    }

    /**
     * If a file exists, require it from the file system.
     *
     * @param string $file - The file to require.
     * @return bool - True if the file exists, false if not.
     */
    private function requireFile($file)
    {
        $directory_name = dirname($file);
        $files = glob($directory_name . '/*', GLOB_NOSORT);
        $lowercase_file = strtolower($file);

        foreach($files as $file) {
            if(strtolower($file) == $lowercase_file) {
                require_once($file);

                return;
            }
        }

        return false;
    }
}