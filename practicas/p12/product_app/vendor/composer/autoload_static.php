<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit977ff2cfee0f8352e1bfb9fba2bb1edf
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TECWEB\\MYAPI\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TECWEB\\MYAPI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/backend',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TECWEB\\MYAPI\\Create\\Create' => __DIR__ . '/../..' . '/backend/Create/Create.php',
        'TECWEB\\MYAPI\\DataBase\\DataBase' => __DIR__ . '/../..' . '/backend/Database/DataBase.php',
        'TECWEB\\MYAPI\\Delete\\Delete' => __DIR__ . '/../..' . '/backend/Delete/Delete.php',
        'TECWEB\\MYAPI\\Read\\Read' => __DIR__ . '/../..' . '/backend/Read/Read.php',
        'TECWEB\\MYAPI\\Update\\Update' => __DIR__ . '/../..' . '/backend/Update/Update.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit977ff2cfee0f8352e1bfb9fba2bb1edf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit977ff2cfee0f8352e1bfb9fba2bb1edf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit977ff2cfee0f8352e1bfb9fba2bb1edf::$classMap;

        }, null, ClassLoader::class);
    }
}
