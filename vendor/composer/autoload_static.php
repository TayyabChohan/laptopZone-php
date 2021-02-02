<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit24922b654f9734f8155b062bd83e2c19
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'o' => 
        array (
            'org\\bovigo\\vfs' => 
            array (
                0 => __DIR__ . '/..' . '/mikey179/vfsstream/src/main/php',
            ),
        ),
        'E' => 
        array (
            'EasyPost' => 
            array (
                0 => __DIR__ . '/..' . '/easypost/easypost-php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit24922b654f9734f8155b062bd83e2c19::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit24922b654f9734f8155b062bd83e2c19::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit24922b654f9734f8155b062bd83e2c19::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}