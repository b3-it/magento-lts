<?php

require_once "Psr4AutoloaderClass.php";

$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('Ramsey\Uuid', __DIR__  . DIRECTORY_SEPARATOR . 'src');

require_once 'Moontoast/Math/bootstrap.php';