<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\UniversalClassLoader;
/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

//require_once $_SERVER['SYMFONY'].'/Symfony/Component/HttpFoundation/UniversalClassLoader.php';
//
//
//
//$loader = new UniversalClassLoader();
//$loader->registerNamespace('Symfony', $_SERVER['SYMFONY']);
//$loader->register();
//return $loader;