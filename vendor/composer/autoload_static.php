<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb9ef021e9d2db76057718497c61948d
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb9ef021e9d2db76057718497c61948d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb9ef021e9d2db76057718497c61948d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
