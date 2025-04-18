<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit977ff2cfee0f8352e1bfb9fba2bb1edf
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit977ff2cfee0f8352e1bfb9fba2bb1edf', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit977ff2cfee0f8352e1bfb9fba2bb1edf', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit977ff2cfee0f8352e1bfb9fba2bb1edf::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
