<?php

$installer = $this;

$installer->startSetup();
$installer->run("alter table extstock2 add parent_extstock_id int(10) UNSIGNED DEFAULT NULL;");
$installer->run("alter table extstock2 add journal_id int(10) UNSIGNED DEFAULT NULL;");
$installer->endSetup(); 