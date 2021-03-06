<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8bfe47e9cae548375e0a337f3905d3b
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

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Detection' => 
            array (
                0 => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/namespaced',
            ),
        ),
    );

    public static $classMap = array (
        'Mobile_Detect' => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/Mobile_Detect.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8bfe47e9cae548375e0a337f3905d3b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8bfe47e9cae548375e0a337f3905d3b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitb8bfe47e9cae548375e0a337f3905d3b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitb8bfe47e9cae548375e0a337f3905d3b::$classMap;

        }, null, ClassLoader::class);
    }
}
