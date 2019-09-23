<?php

require_once "Psr4AutoloaderClass.php";

$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('Moontoast\Math', __DIR__  . DIRECTORY_SEPARATOR . 'src'  . DIRECTORY_SEPARATOR . "Moontoast" . DIRECTORY_SEPARATOR . "Math");