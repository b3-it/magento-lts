<?php

$installer = $this;

$installer->startSetup();

$installer->run("UPDATE `core_config_data` SET `value` = NULL WHERE `path` = 'general/offline/from_date';");
$installer->run("UPDATE `core_config_data` SET `value` = NULL WHERE `path` = 'general/offline/to_date';");
$installer->run("UPDATE `core_config_data` SET `value` = NULL WHERE `path` = 'general/offline/to_date';");
$installer->run("UPDATE `core_config_data` SET `value` = '0' WHERE `path` = 'general/offline/lock';");

$installer->endSetup();
