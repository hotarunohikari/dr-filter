<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit406c6afe0a798795ce0fc51fe06d202e
{
    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'dr\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'dr\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit406c6afe0a798795ce0fc51fe06d202e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit406c6afe0a798795ce0fc51fe06d202e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
