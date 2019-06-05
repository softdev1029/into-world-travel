<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitea4ea1b0c58d15192079142582da6d41
{
	public static $prefixLengthsPsr4 = array(
		'R' =>
			array(
				'RegularLabs\\CacheCleaner\\' => 25,
			),
	);

	public static $prefixDirsPsr4 = array(
		'RegularLabs\\CacheCleaner\\' =>
			array(
				0 => __DIR__ . '/../..' . '/src',
			),
	);

	public static function getInitializer(ClassLoader $loader)
	{
		return \Closure::bind(function () use ($loader)
		{
			$loader->prefixLengthsPsr4 = ComposerStaticInitea4ea1b0c58d15192079142582da6d41::$prefixLengthsPsr4;
			$loader->prefixDirsPsr4    = ComposerStaticInitea4ea1b0c58d15192079142582da6d41::$prefixDirsPsr4;
		}, null, ClassLoader::class);
	}
}
