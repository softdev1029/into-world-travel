<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1a45a5c8f8b8d840e8fe102d45ab00d1
{
    public static $prefixesPsr0 = array (
        'a' => 
        array (
            'abeautifulsite' => 
            array (
                0 => __DIR__ . '/..' . '/abeautifulsite/simpleimage/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit1a45a5c8f8b8d840e8fe102d45ab00d1::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
