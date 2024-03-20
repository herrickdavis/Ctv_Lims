<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit87b1f79edab67b8ca42777333f3ec760
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tests\\PhpOffice\\Math\\' => 21,
        ),
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
            'PhpOffice\\Math\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tests\\PhpOffice\\Math\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/math/tests/Math',
        ),
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'PhpOffice\\Math\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/math/src/Math',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit87b1f79edab67b8ca42777333f3ec760::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit87b1f79edab67b8ca42777333f3ec760::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit87b1f79edab67b8ca42777333f3ec760::$classMap;

        }, null, ClassLoader::class);
    }
}