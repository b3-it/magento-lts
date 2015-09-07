<?php

$installer = $this;

$installer->startSetup();


$installer->run("ALTER TABLE extstock2_stock ADD `addressname2` varchar(512) default ''");

$installer->endSetup(); 