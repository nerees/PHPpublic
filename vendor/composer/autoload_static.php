<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit72bf9668fbf8aa589af976ab1a0d406e
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Myapp\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Myapp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit72bf9668fbf8aa589af976ab1a0d406e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit72bf9668fbf8aa589af976ab1a0d406e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit72bf9668fbf8aa589af976ab1a0d406e::$classMap;

        }, null, ClassLoader::class);
    }
}