<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\ClassLoader\ClassLoader;
use Symfony\Component\ClassLoader\ApcClassLoader;

$loader = new ClassLoader();
$loader->register();

$loader->addPrefix('Controller', __DIR__ . '/../src');
$loader->addPrefix('Document', __DIR__ . '/../src');
$loader->addPrefix('Repository', __DIR__ . '/../src');
$loader->addPrefix('Mapper', __DIR__ . '/../src');
$loader->addPrefix('Exception', __DIR__ . '/../src');
$loader->addPrefix('Entities', __DIR__ . '/../src');

$loader = new ApcClassLoader('apc.prefix.', $loader);
$loader->register();
