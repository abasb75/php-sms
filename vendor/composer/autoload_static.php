<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d49c09fe191107c3732fedfcc9eb9c4
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'IPPanel\\' => 8,
        ),
        'A' => 
        array (
            'Abasb75\\PhpSms\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'IPPanel\\' => 
        array (
            0 => __DIR__ . '/..' . '/ippanel/php-rest-sdk/src/IPPanel',
        ),
        'Abasb75\\PhpSms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d49c09fe191107c3732fedfcc9eb9c4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d49c09fe191107c3732fedfcc9eb9c4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5d49c09fe191107c3732fedfcc9eb9c4::$classMap;

        }, null, ClassLoader::class);
    }
}
